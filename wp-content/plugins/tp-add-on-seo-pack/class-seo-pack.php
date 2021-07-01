<?php

class TRP_Seo_Pack {

    protected $loader;
    protected $slug_manager;
    protected $settings;
    protected $url_converter;
    protected $render;
    /* @var TRP_Editor_Api_Slugs */
    protected $editor_api_post_slug;
    /* @var TRP_SP_String_Translation_SEO */
    protected $string_translation;

    /**
     * Timezone.
     *
     * @var Timezone
     */
    public $timezone;

    public function __construct() {

        // This is needed in the TP core version to show message if Seo Pack needs update
        define( 'TRP_SP_PLUGIN_VERSION', '1.4.2' );

        define( 'TRP_SP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
        define( 'TRP_SP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

        require_once TRP_SP_PLUGIN_DIR . 'includes/class-slug-manager.php';
        require_once TRP_SP_PLUGIN_DIR . 'includes/class-editor-api-post-slug.php';
        require_once TRP_SP_PLUGIN_DIR . 'includes/string-translation/class-string-translation-seo.php';
        require_once TRP_SP_PLUGIN_DIR . 'includes/string-translation/class-meta-based-strings.php';
        require_once TRP_SP_PLUGIN_DIR . 'includes/string-translation/class-option-based-strings.php';
        require_once TRP_SP_PLUGIN_DIR . 'includes/string-translation/class-string-translation-api-taxonomy-slug.php';
        require_once TRP_SP_PLUGIN_DIR . 'includes/string-translation/class-string-translation-api-post-type-base-slug.php';
        require_once TRP_SP_PLUGIN_DIR . 'includes/string-translation/class-string-translation-api-term-slug.php';

        $trp                 = TRP_Translate_Press::get_trp_instance();
        $this->loader        = $trp->get_component( 'loader' );
        $this->url_converter = $trp->get_component( 'url_converter' );
        $trp_settings        = $trp->get_component( 'settings' );
        $this->settings      = $trp_settings->get_settings();
        $this->render        = $trp->get_component( 'translation_render' );;

        include_once('includes/class-timezone.php');
        $this->timezone = new TranslatePress\Seo\Timezone;


        $this->slug_manager         = new TRP_SP_Slug_Manager( $this->settings );
        $this->editor_api_post_slug = new TRP_Editor_Api_Post_Slug( $this->settings, $this->slug_manager );
        $this->string_translation   = new TRP_SP_String_Translation_SEO();

        $this->loader->add_filter( 'trp_node_accessors', $this, 'add_seo_node_accessor_details', 10, 1 );

	    $this->loader->add_filter( 'trp_st_string_types_config', $this->string_translation, 'add_string_translation_types', 10, 2 );
	    $this->loader->add_filter( 'trp_editors_navigation', $this->string_translation, 'enable_editors_navigation', 10, 1 );

        // not used in TP
        $this->loader->add_filter( 'trp_translate_slug', $this->slug_manager, 'get_translated_slug_filter', 10, 3 );

        $this->loader->add_action( 'wp_head', $this->slug_manager, 'add_slug_as_meta_tag', 1 );
        $this->loader->add_filter( 'request', $this->slug_manager, 'change_slug_var_in_request' );
        $this->loader->add_filter( 'pre_get_posts', $this->slug_manager, 'change_slug_var_in_query' );

        $this->loader->add_filter( 'sanitize_title', $this->slug_manager, 'change_query_for_page_by_page_slug', 10, 3 );
        $this->loader->add_filter( 'post_link', $this->slug_manager, 'translate_slug_for_posts', 10, 3 );
        $this->loader->add_filter( 'post_type_link', $this->slug_manager, 'translate_slug_for_posts', 10, 3 );
        $this->loader->add_filter( 'get_page_uri', $this->slug_manager, 'translate_slugs_for_pages', 10, 2 );
        $this->loader->add_action( 'trp_translateable_strings', $this->slug_manager, 'include_slug_for_machine_translation', 10, 6 );
        $this->loader->add_action( 'trp_translateable_information', $this->slug_manager, 'save_machine_translated_slug', 10, 3 );

        $this->loader->add_action( 'wp_ajax_trp_get_translations_postslug', $this->editor_api_post_slug, 'postslug_get_translations' );
        $this->loader->add_action( 'wp_ajax_trp_save_translations_postslug', $this->editor_api_post_slug, 'postslug_save_translations' );

        $this->loader->add_filter( 'template_redirect', $this->slug_manager, 'redirect_to_translated_slug', 100, 2 );

        require_once( TRP_SP_PLUGIN_DIR . 'includes/class-plugin-updater.php' );
        $this->plugin_updater = new TRP_SP_Plugin_Updater();
        $this->loader->add_action( 'admin_init', $this->plugin_updater, 'activate_license' );
        $this->loader->add_action( 'admin_init', $this->plugin_updater, 'deactivate_license' );
        $this->loader->add_action( 'admin_notices', $this->plugin_updater, 'admin_notices' );

        global $trp_license_page;
        if ( !isset( $trp_license_page ) ) {
            $trp_license_page = new TRP_LICENSE_PAGE();
            $this->loader->add_action( 'admin_menu', $trp_license_page, 'license_menu' );
            $this->loader->add_action( 'admin_init', $trp_license_page, 'register_option' );
        }

        // Yoast SEO Sitemap Support
        if ( !apply_filters('trp_disable_languages_sitemap', false)){
            $this->loader->add_action( 'pre_get_posts', $this, 'wpseo_init_sitemap', 1 );
            $this->loader->add_action( 'wpseo_sitemap_url', $this, 'sitemap_add_language_urls', 10, 2 );
            // clear sitemap when saving TP settings.
            $this->loader->add_filter( 'trp_extra_sanitize_settings', $this, 'wpseo_clear_sitemap', 10 );
        }

        // RankMath Sitemap Support
        if ( !apply_filters('trp_disable_languages_sitemap', false)){
            $this->loader->add_action( 'parse_query', $this, 'rankmath_init_sitemap', 0 );
            $this->loader->add_action( 'rank_math/sitemap/url', $this, 'sitemap_add_language_urls', 10, 2 );
        }

        //SeoPress Sitemap Support
        if ( !apply_filters('trp_disable_languages_sitemap', false)){
            $this->loader->add_action( 'seopress_sitemaps_url', $this, 'sitemap_add_language_urls', 10, 2 );
            $this->loader->add_action( 'seopress_sitemaps_urlset', $this, 'sitemap_add_xhtml_to_urlset', 10, 1 );
        }

        // All In One SEO Support
        if ( !apply_filters('trp_disable_languages_sitemap', false)){
            $this->loader->add_action( 'aiosp_sitemap_data', $this, 'aiosp_sitemap_data', 1, 4 );

            $this->loader->add_action( 'aioseo_sitemap_posts', $this, 'aiosp_sitemap_add_language_urls', 1, 1 );
            $this->loader->add_action( 'aioseo_sitemap_terms', $this, 'aiosp_sitemap_add_language_urls', 1, 1 );

            // we're not implementing the xhtml alternate yet. Maybe in a future update.
            // Also, we can't add the xhtml alternate tag to each url because there are no filters there.
            /* @to-do
             * create pull request for All In One SEO so we can add <xhtml:link rel='alternate' /> in a future version.
             **/
            //$this->loader->add_action( 'aiosp_sitemap_xml_namespace', $this, 'aiosp_sitemap_xml_namespace', 10, 1 );
        }


        //Taxonomy and CPT base slug translation, we filter the $args['rewrite']['slug']
        $this->loader->add_filter( 'register_taxonomy_args', $this->slug_manager, 'filter_registration_args_for_slug', 100, 2 );
        $this->loader->add_filter( 'register_post_type_args', $this->slug_manager, 'filter_registration_args_for_slug', 100, 2 );
        // Filter saved permalinks from db so we don't get 404 on translated slugs. This is for tax and cpt base slugs
        $this->loader->add_filter( "option_rewrite_rules", $this->slug_manager, 'filter_permalinks_on_other_languages', 10 );
        //Filter our on language switcher links, hopefully that's all it does :)
        $this->loader->add_filter( 'trp_get_url_for_language', $this->slug_manager, 'filter_language_switcher_link', 10, 3 );

        //Term translation
        $this->loader->add_filter( 'term_link', $this->slug_manager, 'translate_term_link_slugs', 10, 3 );//filter term links
        $this->loader->add_filter( 'request', $this->slug_manager, 'change_term_slug_var_in_request' );//so we don't get 404
        $this->loader->add_filter( 'pre_get_posts', $this->slug_manager, 'change_term_slug_var_in_query' );//so we have propper results in queries

        //Handle %category% in custom permalinks structures
        $this->loader->add_filter( 'post_link_category', $this->slug_manager, 'filter_term_slugs_in_custom_permalink_structure', 10, 3 );
        $this->loader->add_filter( 'get_term', $this->slug_manager, 'filter_parent_term_slugs_in_custom_permalink_structure', 10 );

        //WooCommerce translation
        if( class_exists( 'WooCommerce' ) ) {
            $this->loader->add_filter('trp_x', $this->slug_manager, 'translate_woocommerce_main_slugs', 10, 5);//filters product, product-category and product-tag
            $this->loader->add_filter('trp_before_based_slug_save', $this->slug_manager, 'reset_woocommerce_transients', 10, 5);//filters product, product-category and product-tag

            $this->loader->add_filter('wc_product_post_type_link_product_cat', $this->slug_manager, 'woocommerce_product_cat_in_permalinks', 10, 3);//filters %product_cat% in custom product permalinks
        }

        //schema.org support
        $this->loader->add_filter( 'trp_before_translate_content', $this, 'append_schema_data', 10 );//append in translation editor the nodes we want to translate to the html so we have access in the String Dropdown
        $this->loader->add_filter( 'trp_process_other_text_nodes', $this, 'translate_schema_data', 10 );//translate the nodes inside the schema json
    }

    public function wpseo_init_sitemap() {
        global $wp_query;
        if ( !empty( $wp_query ) ) {
            $type = get_query_var( 'sitemap', '' );
            add_filter( "wpseo_sitemap_{$type}_urlset",  array( $this, 'sitemap_add_xhtml_to_urlset' ) );
        }
    }

    public function rankmath_init_sitemap(){
        global $wp_query;
        if( !empty($wp_query) ){
            $type = get_query_var( 'sitemap', '' );
            add_filter( "rank_math/sitemap/{$type}_urlset",  array( $this, 'sitemap_add_xhtml_to_urlset' ) );
        }
    }

    public function sitemap_add_xhtml_to_urlset( $urlset ){
        $urlset = str_replace(  '<urlset', '<urlset xmlns:xhtml="http://www.w3.org/1999/xhtml" ', $urlset);
        return $urlset;
    }

    public function sitemap_add_language_urls( $output, $url ){

        $date = null;

        $url = apply_filters( 'trp_filter_url_sitemap_before_output', $url );

        if ( ! empty( $url['mod'] ) ) {
            $date = $this->timezone->format_date( $url['mod'] );
        }

        $trp           = TRP_Translate_Press::get_trp_instance();
        $url_converter = $trp->get_component( 'url_converter' );
        $settings      = $this->settings;
        $languages     = $settings['publish-languages'];

        $alternate       = '';
        $other_lang_urls = array();

        /* The original sitemaps urls are generated in a translation language instead of a default language if
         * the "Use subdirectory for default language" is on and the first language is not the default one.
         * Thus the urls come with the language slug of an translated language and all the other ones
         * except $original_language need to be generated.
        */
        $original_language = ( isset( $this->settings['add-subdirectory-to-default-language'] ) && $this->settings['add-subdirectory-to-default-language'] == 'yes' && isset( $this->settings['publish-languages'][0] ) ) ? $settings['publish-languages'][0] : $settings['default-language'];

        foreach ( $languages as $language ) {
            $add_language = apply_filters( 'trp_add_language_url_to_sitemap', true, $language, $url, $output );

            if ( ! $add_language ){
                continue;
            }
            // hreflang should have - instead of _ . For example: en-EN, not en_EN like the locale
            $hreflang = str_replace('_', '-', $language);
            $alternate .= "<xhtml:link rel='alternate' hreflang='" . $hreflang . "' href='" . $url_converter->get_url_for_language( $language, $url["loc"] ) . "' />\n";

            if ( $language != $original_language ) {
                $lastmod = '';
                if (!empty( $date )){
                    $lastmod = "<lastmod>" . htmlspecialchars($date) . "</lastmod>\n";
                }

                // add images if it's set
                $images = '';
                if( isset($url['images']) && is_array($url['images']) ){
                    foreach ($url['images'] as $image) {
                        $images .= "<image:image><image:loc>{$image['src']}</image:loc></image:image>\n";
                    }
                }

                // add news tags if it's set. SEOPress uses them.
                $news = '';
                if( isset($url['news']) && is_array($url['news']) ){
                    $news .= '<news:news>';
                    $news .= "\n";
                    $news .= '<news:publication>';
                    $news .= "\n";
                    $news .= '<news:name>'.$url['news']['name'].'</news:name>';
                    $news .= "\n";
                    $news .= '<news:language>'. $hreflang .'</news:language>';
                    $news .= "\n";
                    $news .= '</news:publication>';
                    $news .= "\n";
                    $news .= '<news:publication_date>';
                    $news .= $url['news']['publication_date'];
                    $news .= '</news:publication_date>';
                    $news .= "\n";
                    $news .= '<news:title>';
                    $news .= $url['news']['title'];
                    $news .= '</news:title>';
                    $news .= "\n";
                    $news .= '</news:news>';
                    $news .= "\n";
                }

                $other_lang_urls[] = "\n<url>\n<loc>" . $url_converter->get_url_for_language($language, $url["loc"]) . "</loc>\n" . $lastmod . $images . $news ;
            }
        }

        // add support for x-default hreflang.
        if( isset($this->settings['trp_advanced_settings']['enable_hreflang_xdefault']) && $this->settings['trp_advanced_settings']['enable_hreflang_xdefault'] != 'disabled' ){
            $default_lang = $this->settings['trp_advanced_settings']['enable_hreflang_xdefault'];
            $alternate .= "<xhtml:link rel='alternate' hreflang='x-default' href='" . $url_converter->get_url_for_language( $default_lang, $url["loc"] ) . "' />\n";
        }

        foreach ( $other_lang_urls as &$value){
            $value .= $alternate . "</url>\n";
        }
        $all_lang_urls = implode( '', $other_lang_urls );

        $new_output = str_replace("</url>", $alternate . "</url>" . $all_lang_urls , $output);

        /* Add the language slug to URL's in the case it is not present and
         * Use a subdirectory for the default language is set to Yes
         */
	    if(isset($settings["add-subdirectory-to-default-language"]) && $settings["add-subdirectory-to-default-language"] ==='yes' && $url_converter->get_lang_from_url_string($url['loc']) === null ) {
		    $new_output = str_replace( '<loc>' . $url['loc'] . '</loc>', '<loc>' . $url['loc'] .$url_converter->get_url_slug($original_language, false)."/"."</loc>", $new_output );
	    }

	    /* Clean the final output for any leftover #TRPLINKPROCESSED strings as they are not needed after
         * An alternative to doing that here would be in the class-url-converter inside get_url_for_language function
        */
	    $new_output = str_replace("#TRPLINKPROCESSED", '', $new_output);
        return apply_filters( 'trp_xml_sitemap_output_for_url', $new_output, $output, $settings, $alternate, $all_lang_urls, $url );
    }

    static function wpseo_clear_sitemap($settings){
        global $wpdb;
        // delete all "yst_sm" transients
        $sql = "
            DELETE
            FROM {$wpdb->options}
            WHERE option_name like '\_transient\_yst\_sm%'
            OR option_name like '\_transient\_timeout\_yst\_sm%'
        ";

        $wpdb->query( $sql );
        return $settings;
    }

    public function aiosp_sitemap_xml_namespace($namespace){
        $namespace['xhtml'] = 'http://www.w3.org/1999/xhtml';
        return $namespace;
    }

    public function aiosp_sitemap_data($sitemap_data, $sitemap_type, $page_number, $aioseop_options){

        if( $sitemap_type == 'root' )
            return $sitemap_data;

        return $this->aiosp_sitemap_add_language_urls( $sitemap_data );

    }

    public function aiosp_sitemap_add_language_urls( $entries ){

        if( empty( $entries ) )
            return $entries;

        $trp_sitemap_data = [];

        foreach( $entries as $url ){
            $trp_sitemap_data[] = $url;
            $trp                = TRP_Translate_Press::get_trp_instance();
            $url_converter      = $trp->get_component( 'url_converter' );
            $settings           = $this->settings;
            $languages          = $settings['publish-languages'];

            foreach( $languages as $language ){
                $add_language = apply_filters( 'trp_add_language_url_to_sitemap', true, $language, $url, '' );

                if ( ! $add_language )
                    continue;

                if( $language != $settings['default-language'] ){
                    $url['loc'] = $url_converter->get_url_for_language($language, $url["loc"]) ;
                    $trp_sitemap_data[] = $url;
                }
            }
        }

        return $trp_sitemap_data;

    }

    public function add_seo_node_accessor_details( $node_accessor_array ){
	    $node_accessor_array['image_alt'] = array(
		    'selector' => 'img[alt]',
		    'accessor' => 'alt',
		    'attribute' => true
	    );


	    $node_accessor_array['meta_desc'] = array(
		    'selector' => 'meta[name="description"],meta[property="og:title"],meta[property="og:description"],meta[property="og:site_name"],meta[name="twitter:title"],meta[name="twitter:description"],meta[name="DC.Title"],meta[name="DC.Description"]',
		    'accessor' => 'content',
		    'attribute' => true
	    );

	    $node_accessor_array['page_title'] = array(
		    'selector' => 'title',
		    'accessor' => 'innertext',
		    'attribute' => false
	    );

	    return $node_accessor_array;
    }

    /**
     * Function that appends the nodes from schema.org json to the html when we are in translation editor so those strings are detected and can be translated
     * @param string $output the html string from translate_page function before it gets processed
     * @return string returns the html string with the schema strings attached or the original one if no schema detected
     */
    public function append_schema_data( $output ){
        //check to see if we are in the editor
        $preview_mode = isset($_REQUEST['trp-edit-translation']) && $_REQUEST['trp-edit-translation'] == 'preview';
        if ($preview_mode) {//only do this in the editor
            //try to create html object with the dom parser
            $html = TranslatePress\str_get_html($output, true, true, TRP_DEFAULT_TARGET_CHARSET, false, TRP_DEFAULT_BR_TEXT, TRP_DEFAULT_SPAN_TEXT);
            if( $html ) {

                foreach ( $html->find('script[type="application/ld+json"]') as $schema ) {//get all the schema
                    $schema_content = $schema->innertext;

                    if ($schema_content) {
                        global $json_schema_remaining_array;
                        $json_schema_remaining_array = array();
                        $this->process_schema_json($schema_content, 'get_schema_nodes');

                        if (!empty($json_schema_remaining_array)) {//if we have text from the schema append it to the end of the body tag
                            $body = $html->find('body', 0);
                            if ($body) {
                                $append_schema_info = '';
                                foreach ($json_schema_remaining_array as $schema_value) {
                                    $append_schema_info .= '<div style="display:none">' . $schema_value . '</div>';//don't show it to the user
                                }
                                $body->innertext .= $append_schema_info;
                            }
                        }
                    }
                }

                $output = $html->save();
            }
        }

        return $output;
    }


    /**
     * Function that translates some of the leaves of a json schema and replaces them in the dom node
     * @param $row a node from html DOM parser
     * @return mixed the node with some of the leaves translated
     */
    function translate_schema_data( $row ){

        $outertext = $row->outertext;
        $parent = $row->parent();
        $trimmed_string = trp_full_trim( $outertext );

        if( $parent->tag === "script" && isset( $parent->attr['type'] ) && $parent->attr['type'] === "application/ld+json" ){//this is the type of the script that contains the json
            $json_schema_array = $this->process_schema_json($trimmed_string, 'translate_schema'); //translate here
            $row->outertext = trp_safe_json_encode( $json_schema_array ); //reencode the JSON
        }

        return $row;
    }

    /**
     * Function that aplies a callback to a valid json object
     * @param $json_text the json in text form
     * @param $action_type
     * @return array|false|mixed
     */
    function process_schema_json( $json_text, $action_type ){
        $json_schema_array = json_decode( $json_text, true );
        if( $json_schema_array && $json_schema_array != $json_text ) { //if we successfully decoded the json
            if ( is_array( $json_schema_array ) ) {
                array_walk_recursive($json_schema_array, array( $this, $action_type ) );//apply the callback
                return $json_schema_array;
            }

        }

        return false;
    }

    /**
     * Funciton that returns the keys of the schema that we allow translation
     * @return mixed|void
     */
    function get_schema_node_keys(){
        return apply_filters('trp_schema_node_keys', array( 'name', 'description' ) );
    }

    /**
     * Callback function that passes through the schema json and populates a global array with the desired text in certain keys
     * @param $value
     * @param $key
     */
    function get_schema_nodes( $value, $key ){
        global $json_schema_remaining_array;
        $schema_node_keys = $this->get_schema_node_keys();
        if( in_array( $key, $schema_node_keys ) ){
            if( !in_array( $value,  $json_schema_remaining_array ) )//don't duplicate strings
                $json_schema_remaining_array[] = $value;
        }
    }

    /**
     * Callback function that translates some of the keys in the json
     * @param $value
     * @param $key
     */
    function translate_schema( &$value, $key ){
        $schema_node_keys = $this->get_schema_node_keys();
        if( in_array( $key, $schema_node_keys ) ) {
            $value = $this->render->translate_page($value);
        }
    }

}
