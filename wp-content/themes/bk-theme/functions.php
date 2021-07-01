<?php


add_theme_support('post-thumbnails');
add_filter('use_block_editor_for_post', '__return_false');

function register_my_menu()
{
	register_nav_menus(
		array(
			'primary-menu' =>  __('Menu top left'),
			'primary-menu-right' => 'Menu top right',
			'language'	=> 'Language'
		)
	);
}
add_action('init', 'register_my_menu');

/**
 * ADD WIDGET
 */

function register_widget_areas()
{
	register_sidebar(array(
		'name'          => 'Sidebar',
		'id'            => 'sidebar_section',
		'description'   => 'This widget for display sidebar section',
		'before_widget' => '<section class="%2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4><hr class="line-left">',
	));

	register_sidebar(array(
		'name'          => 'Link Contact',
		'id'            => 'link_contact',
		'description'   => 'This widget for display link to contact page',
	));
}
add_action('widgets_init', 'register_widget_areas');

/**
 * CREATE CUSTOM WIDGET
 */

class custom_Widget_Recent_Posts extends WP_Widget
{

	/**
	 * Sets up a new Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 */
	public function __construct()
	{
		$widget_ops = array(
			'classname'                   => 'custom_widget_recent_entries',
			'description'                 => __('CUSTOM RECENT POSTS.'),
			'customize_selective_refresh' => true,
		);
		parent::__construct('custom-recent-posts', __('Recent Posts Custom'), $widget_ops);
		$this->alt_option_name = 'custom_widget_recent_entries';
	}

	/**
	 * Outputs the content for the current Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Recent Posts widget instance.
	 */
	public function widget($args, $instance)
	{
		if (!isset($args['widget_id'])) {
			$args['widget_id'] = $this->id;
		}

		$default_title = __('Recent Posts');
		$title         = (!empty($instance['title'])) ? $instance['title'] : $default_title;

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters('widget_title', $title, $instance, $this->id_base);

		$number = (!empty($instance['number'])) ? absint($instance['number']) : 5;
		if (!$number) {
			$number = 5;
		}
		$show_date = isset($instance['show_date']) ? $instance['show_date'] : false;

		$r = new WP_Query(
			/**
			 * Filters the arguments for the Recent Posts widget.
			 *
			 * @since 3.4.0
			 * @since 4.9.0 Added the `$instance` parameter.
			 *
			 * @see WP_Query::get_posts()
			 *
			 * @param array $args     An array of arguments used to retrieve the recent posts.
			 * @param array $instance Array of settings for the current widget.
			 */
			apply_filters(
				'widget_posts_args',
				array(
					'posts_per_page'      => $number,
					'no_found_rows'       => true,
					'post_status'         => 'publish',
					'ignore_sticky_posts' => true,
				),
				$instance
			)
		);

		if (!$r->have_posts()) {
			return;
		}
?>

		<?php echo $args['before_widget']; ?>

		<?php
		if ($title) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		$format = current_theme_supports('html5', 'navigation-widgets') ? 'html5' : 'xhtml';

		/** This filter is documented in wp-includes/widgets/class-wp-nav-menu-widget.php */
		$format = apply_filters('navigation_widgets_format', $format);

		if ('html5' === $format) {
			// The title may be filtered: Strip out HTML and make sure the aria-label is never empty.
			$title      = trim(strip_tags($title));
			$aria_label = $title ? $title : $default_title;
			echo '<nav role="navigation" aria-label="' . esc_attr($aria_label) . '">';
		}
		?>

		<?php foreach ($r->posts as $recent_post) : ?>
			<?php
			$post_title   = get_the_title($recent_post->ID);
			$title        = (!empty($post_title)) ? $post_title : __('(no title)');
			$aria_current = '';
			$post_image = get_the_post_thumbnail($recent_post);

			if (get_queried_object_id() === $recent_post->ID) {
				$aria_current = ' aria-current="page"';
			}
			?>

			<div class="display-grid recent-item">
				<div class="col-3">
					<a href="<?php the_permalink($recent_post->ID); ?>" <?php echo $aria_current; ?>><?php echo $post_image ?></a>

				</div>
				<div class="col-9">
					<?php if ($show_date) : ?>
						<span class="date"><?php echo get_the_date('', $recent_post->ID); ?></span>
					<?php endif; ?>
					<h5><a href="<?php the_permalink($recent_post->ID); ?>" <?php echo $aria_current; ?>><?php echo $title; ?></a></h5>
				</div>
			</div>

		<?php endforeach; ?>

		<?php
		if ('html5' === $format) {
			echo '</nav>';
		}

		echo $args['after_widget'];
	}

	/**
	 * Handles updating the settings for the current Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update($new_instance, $old_instance)
	{
		$instance              = $old_instance;
		$instance['title']     = sanitize_text_field($new_instance['title']);
		$instance['number']    = (int) $new_instance['number'];
		$instance['show_date'] = isset($new_instance['show_date']) ? (bool) $new_instance['show_date'] : false;
		return $instance;
	}

	/**
	 * Outputs the settings form for the Recent Posts widget.
	 *
	 * @since 2.8.0
	 *
	 * @param array $instance Current settings.
	 */
	public function form($instance)
	{
		$title     = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$number    = isset($instance['number']) ? absint($instance['number']) : 5;
		$show_date = isset($instance['show_date']) ? (bool) $instance['show_date'] : false;
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:'); ?></label>
			<input class="tiny-text" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" />
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($show_date); ?> id="<?php echo $this->get_field_id('show_date'); ?>" name="<?php echo $this->get_field_name('show_date'); ?>" />
			<label for="<?php echo $this->get_field_id('show_date'); ?>"><?php _e('Display post date?'); ?></label>
		</p>
		<?php
	}
}

class custom_Widget_Archives extends WP_Widget
{

	/**
	 * Sets up a new Archives widget instance.
	 *
	 * @since 2.8.0
	 */
	public function __construct()
	{
		$widget_ops = array(
			'classname'                   => 'widget_archive',
			'description'                 => __('CUSTOM ARCHIVE.'),
			'customize_selective_refresh' => true,
		);
		parent::__construct('custom_archives', __('Archives Custom'), $widget_ops);
	}

	/**
	 * Outputs the content for the current Archives widget instance.
	 *
	 * @since 2.8.0
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Archives widget instance.
	 */
	public function widget($args, $instance)
	{
		$default_title = __('Archives');
		$title         = !empty($instance['title']) ? $instance['title'] : $default_title;

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters('widget_title', $title, $instance, $this->id_base);

		$count    = !empty($instance['count']) ? '1' : '0';
		$dropdown = !empty($instance['dropdown']) ? '1' : '0';

		echo $args['before_widget'];

		if ($title) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		if ($dropdown) {
			$dropdown_id = "{$this->id_base}-dropdown-{$this->number}";
		?>
			<label class="screen-reader-text" for="<?php echo esc_attr($dropdown_id); ?>"><?php echo $title; ?></label>
			<select id="<?php echo esc_attr($dropdown_id); ?>" name="archive-dropdown">
				<?php
				/**
				 * Filters the arguments for the Archives widget drop-down.
				 *
				 * @since 2.8.0
				 * @since 4.9.0 Added the `$instance` parameter.
				 *
				 * @see wp_get_archives()
				 *
				 * @param array $args     An array of Archives widget drop-down arguments.
				 * @param array $instance Settings for the current Archives widget instance.
				 */
				$dropdown_args = apply_filters(
					'widget_archives_dropdown_args',
					array(
						'type'            => 'monthly',
						'format'          => 'option',
						'show_post_count' => $count,
					),
					$instance
				);

				switch ($dropdown_args['type']) {
					case 'yearly':
						$label = __('Select Year');
						break;
					case 'monthly':
						$label = __('Select Month');
						break;
					case 'daily':
						$label = __('Select Day');
						break;
					case 'weekly':
						$label = __('Select Week');
						break;
					default:
						$label = __('Select Post');
						break;
				}

				$type_attr = current_theme_supports('html5', 'script') ? '' : ' type="text/javascript"';
				?>

				<option value=""><?php echo esc_attr($label); ?></option>
				<?php wp_get_archives($dropdown_args); ?>

			</select>

			<script<?php echo $type_attr; ?>>
				/*
				<![CDATA[ */
(function() {
	var dropdown = document.getElementById( "<?php echo esc_js($dropdown_id); ?>" );
	function onSelectChange() {
		if ( dropdown.options[ dropdown.selectedIndex ].value !== '' ) {
			document.location.href = this.options[ this.selectedIndex ].value;
		}
	}
	dropdown.onchange = onSelectChange;
})();
/* ]]> */
				</script>
			<?php
		} else {
			$format = current_theme_supports('html5', 'navigation-widgets') ? 'html5' : 'xhtml';

			/** This filter is documented in wp-includes/widgets/class-wp-nav-menu-widget.php */
			$format = apply_filters('navigation_widgets_format', $format);

			if ('html5' === $format) {
				// The title may be filtered: Strip out HTML and make sure the aria-label is never empty.
				$title      = trim(strip_tags($title));
				$aria_label = $title ? $title : $default_title;
				echo '<nav role="navigation" aria-label="' . esc_attr($aria_label) . '">';
			}
			?>

				<ul>
					<?php
					wp_get_archives_custom(
						/**
						 * Filters the arguments for the Archives widget.
						 *
						 * @since 2.8.0
						 * @since 4.9.0 Added the `$instance` parameter.
						 *
						 * @see wp_get_archives()
						 *
						 * @param array $args     An array of Archives option arguments.
						 * @param array $instance Array of settings for the current widget.
						 */
						apply_filters(
							'widget_archives_args',
							array(
								'type'            => 'monthly',
								'show_post_count' => $count,
							),
							$instance
						)
					);
					?>
				</ul>

			<?php
			if ('html5' === $format) {
				echo '</nav>';
			}
		}

		echo $args['after_widget'];
	}

	/**
	 * Handles updating settings for the current Archives widget instance.
	 *
	 * @since 2.8.0
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget_Archives::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update($new_instance, $old_instance)
	{
		$instance             = $old_instance;
		$new_instance         = wp_parse_args(
			(array) $new_instance,
			array(
				'title'    => '',
				'count'    => 0,
				'dropdown' => '',
			)
		);
		$instance['title']    = sanitize_text_field($new_instance['title']);
		$instance['count']    = $new_instance['count'] ? 1 : 0;
		$instance['dropdown'] = $new_instance['dropdown'] ? 1 : 0;

		return $instance;
	}

	/**
	 * Outputs the settings form for the Archives widget.
	 *
	 * @since 2.8.0
	 *
	 * @param array $instance Current settings.
	 */
	public function form($instance)
	{
		$instance = wp_parse_args(
			(array) $instance,
			array(
				'title'    => '',
				'count'    => 0,
				'dropdown' => '',
			)
		);
			?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked($instance['dropdown']); ?> id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>" />
				<label for="<?php echo $this->get_field_id('dropdown'); ?>"><?php _e('Display as dropdown'); ?></label>
				<br />
				<input class="checkbox" type="checkbox" <?php checked($instance['count']); ?> id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" />
				<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Show post counts'); ?></label>
			</p>
		<?php
	}
}


function wp_get_archives_custom($args = '')
{
	global $wpdb, $wp_locale;

	$defaults = array(
		'type'            => 'monthly',
		'limit'           => '',
		'format'          => 'html',
		'before'          => '',
		'after'           => '',
		'show_post_count' => false,
		'echo'            => 1,
		'order'           => 'DESC',
		'post_type'       => 'post',
		'year'            => get_query_var('year'),
		'monthnum'        => get_query_var('monthnum'),
		'day'             => get_query_var('day'),
		'w'               => get_query_var('w'),
	);

	$parsed_args = wp_parse_args($args, $defaults);

	$post_type_object = get_post_type_object($parsed_args['post_type']);
	if (!is_post_type_viewable($post_type_object)) {
		return;
	}

	$parsed_args['post_type'] = $post_type_object->name;

	if ('' === $parsed_args['type']) {
		$parsed_args['type'] = 'monthly';
	}

	if (!empty($parsed_args['limit'])) {
		$parsed_args['limit'] = absint($parsed_args['limit']);
		$parsed_args['limit'] = ' LIMIT ' . $parsed_args['limit'];
	}

	$order = strtoupper($parsed_args['order']);
	if ('ASC' !== $order) {
		$order = 'DESC';
	}

	// This is what will separate dates on weekly archive links.
	$archive_week_separator = '&#8211;';

	$sql_where = $wpdb->prepare("WHERE post_type = %s AND post_status = 'publish'", $parsed_args['post_type']);

	/**
	 * Filters the SQL WHERE clause for retrieving archives.
	 *
	 * @since 2.2.0
	 *
	 * @param string $sql_where   Portion of SQL query containing the WHERE clause.
	 * @param array  $parsed_args An array of default arguments.
	 */
	$where = apply_filters('getarchives_where', $sql_where, $parsed_args);

	/**
	 * Filters the SQL JOIN clause for retrieving archives.
	 *
	 * @since 2.2.0
	 *
	 * @param string $sql_join    Portion of SQL query containing JOIN clause.
	 * @param array  $parsed_args An array of default arguments.
	 */
	$join = apply_filters('getarchives_join', '', $parsed_args);

	$output = '';

	$last_changed = wp_cache_get_last_changed('posts');

	$limit = $parsed_args['limit'];

	if ('monthly' === $parsed_args['type']) {
		$query   = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date $order $limit";
		$key     = md5($query);
		$key     = "wp_get_archives:$key:$last_changed";
		$results = wp_cache_get($key, 'posts');
		if (!$results) {
			$results = $wpdb->get_results($query);
			wp_cache_set($key, $results, 'posts');
		}
		if ($results) {
			$after = $parsed_args['after'];
			foreach ((array) $results as $result) {
				$url = get_month_link($result->year, $result->month);
				if ('post' !== $parsed_args['post_type']) {
					$url = add_query_arg('post_type', $parsed_args['post_type'], $url);
				}
				/* translators: 1: Month name, 2: 4-digit year. */
				$text = sprintf(__('%1$s %2$d'), $wp_locale->get_month($result->month), $result->year);
				if ($parsed_args['show_post_count']) {
					$parsed_args['after'] = '<strong>' . $result->posts . '</strong>' . $after;
				}
				$selected = is_archive() && (string) $parsed_args['year'] === $result->year && (string) $parsed_args['monthnum'] === $result->month;
				$output  .= get_archives_link($url, $text, $parsed_args['format'], $parsed_args['before'], $parsed_args['after'], $selected);
			}
		}
	} elseif ('yearly' === $parsed_args['type']) {
		$query   = "SELECT YEAR(post_date) AS `year`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date) ORDER BY post_date $order $limit";
		$key     = md5($query);
		$key     = "wp_get_archives:$key:$last_changed";
		$results = wp_cache_get($key, 'posts');
		if (!$results) {
			$results = $wpdb->get_results($query);
			wp_cache_set($key, $results, 'posts');
		}
		if ($results) {
			$after = $parsed_args['after'];
			foreach ((array) $results as $result) {
				$url = get_year_link($result->year);
				if ('post' !== $parsed_args['post_type']) {
					$url = add_query_arg('post_type', $parsed_args['post_type'], $url);
				}
				$text = sprintf('%d', $result->year);
				if ($parsed_args['show_post_count']) {
					$parsed_args['after'] = '<strong>' . $result->posts . '</strong>' . $after;
				}
				$selected = is_archive() && (string) $parsed_args['year'] === $result->year;
				$output  .= get_archives_link($url, $text, $parsed_args['format'], $parsed_args['before'], $parsed_args['after'], $selected);
			}
		}
	} elseif ('daily' === $parsed_args['type']) {
		$query   = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, DAYOFMONTH(post_date) AS `dayofmonth`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date), DAYOFMONTH(post_date) ORDER BY post_date $order $limit";
		$key     = md5($query);
		$key     = "wp_get_archives:$key:$last_changed";
		$results = wp_cache_get($key, 'posts');
		if (!$results) {
			$results = $wpdb->get_results($query);
			wp_cache_set($key, $results, 'posts');
		}
		if ($results) {
			$after = $parsed_args['after'];
			foreach ((array) $results as $result) {
				$url = get_day_link($result->year, $result->month, $result->dayofmonth);
				if ('post' !== $parsed_args['post_type']) {
					$url = add_query_arg('post_type', $parsed_args['post_type'], $url);
				}
				$date = sprintf('%1$d-%2$02d-%3$02d 00:00:00', $result->year, $result->month, $result->dayofmonth);
				$text = mysql2date(get_option('date_format'), $date);
				if ($parsed_args['show_post_count']) {
					$parsed_args['after'] = '<strong>' . $result->posts . '</strong>' . $after;
				}
				$selected = is_archive() && (string) $parsed_args['year'] === $result->year && (string) $parsed_args['monthnum'] === $result->month && (string) $parsed_args['day'] === $result->dayofmonth;
				$output  .= get_archives_link($url, $text, $parsed_args['format'], $parsed_args['before'], $parsed_args['after'], $selected);
			}
		}
	} elseif ('weekly' === $parsed_args['type']) {
		$week    = _wp_mysql_week('`post_date`');
		$query   = "SELECT DISTINCT $week AS `week`, YEAR( `post_date` ) AS `yr`, DATE_FORMAT( `post_date`, '%Y-%m-%d' ) AS `yyyymmdd`, count( `ID` ) AS `posts` FROM `$wpdb->posts` $join $where GROUP BY $week, YEAR( `post_date` ) ORDER BY `post_date` $order $limit";
		$key     = md5($query);
		$key     = "wp_get_archives:$key:$last_changed";
		$results = wp_cache_get($key, 'posts');
		if (!$results) {
			$results = $wpdb->get_results($query);
			wp_cache_set($key, $results, 'posts');
		}
		$arc_w_last = '';
		if ($results) {
			$after = $parsed_args['after'];
			foreach ((array) $results as $result) {
				if ($result->week != $arc_w_last) {
					$arc_year       = $result->yr;
					$arc_w_last     = $result->week;
					$arc_week       = get_weekstartend($result->yyyymmdd, get_option('start_of_week'));
					$arc_week_start = date_i18n(get_option('date_format'), $arc_week['start']);
					$arc_week_end   = date_i18n(get_option('date_format'), $arc_week['end']);
					$url            = add_query_arg(
						array(
							'm' => $arc_year,
							'w' => $result->week,
						),
						home_url('/')
					);
					if ('post' !== $parsed_args['post_type']) {
						$url = add_query_arg('post_type', $parsed_args['post_type'], $url);
					}
					$text = $arc_week_start . $archive_week_separator . $arc_week_end;
					if ($parsed_args['show_post_count']) {
						$parsed_args['after'] = '<strong>' . $result->posts . '</strong>' . $after;
					}
					$selected = is_archive() && (string) $parsed_args['year'] === $result->yr && (string) $parsed_args['w'] === $result->week;
					$output  .= get_archives_link($url, $text, $parsed_args['format'], $parsed_args['before'], $parsed_args['after'], $selected);
				}
			}
		}
	} elseif (('postbypost' === $parsed_args['type']) || ('alpha' === $parsed_args['type'])) {
		$orderby = ('alpha' === $parsed_args['type']) ? 'post_title ASC ' : 'post_date DESC, ID DESC ';
		$query   = "SELECT * FROM $wpdb->posts $join $where ORDER BY $orderby $limit";
		$key     = md5($query);
		$key     = "wp_get_archives:$key:$last_changed";
		$results = wp_cache_get($key, 'posts');
		if (!$results) {
			$results = $wpdb->get_results($query);
			wp_cache_set($key, $results, 'posts');
		}
		if ($results) {
			foreach ((array) $results as $result) {
				if ('0000-00-00 00:00:00' !== $result->post_date) {
					$url = get_permalink($result);
					if ($result->post_title) {
						/** This filter is documented in wp-includes/post-template.php */
						$text = strip_tags(apply_filters('the_title', $result->post_title, $result->ID));
					} else {
						$text = $result->ID;
					}
					$selected = get_the_ID() === $result->ID;
					$output  .= get_archives_link($url, $text, $parsed_args['format'], $parsed_args['before'], $parsed_args['after'], $selected);
				}
			}
		}
	}

	if ($parsed_args['echo']) {
		echo $output;
	} else {
		return $output;
	}
}

function add_Custom_Widgets()
{
	register_widget('custom_Widget_Recent_Posts');
	register_widget('custom_Widget_Archives');
}
add_action('widgets_init', 'add_Custom_Widgets');

// Search titles only 
function __search_by_title_only($search, $wp_query)
{
	global $wpdb;
	if (empty($search)) {
		return $search; // skip processing - no search term in query
	}
	$q = $wp_query->query_vars;
	$n = !empty($q['exact']) ? '' : '%';
	$search =
		$searchand = '';
	foreach ((array) $q['search_terms'] as $term) {
		$term = esc_sql($wpdb->esc_like($term));
		$search .= "{$searchand}($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
		$searchand = ' AND ';
	}
	if (!empty($search)) {
		$search = " AND ({$search}) ";
		if (!is_user_logged_in())
			$search .= " AND ($wpdb->posts.post_password = '') ";
	}
	return $search;
}
add_filter('posts_search', '__search_by_title_only', 500, 2);


function customize_all_logo($wp_customize)
{

	$wp_customize->add_setting('logo-img', array('default' => ''));
	$wp_customize->add_control(
		new WP_Customize_Image_Control($wp_customize, 'logo-img', array(
			'label' => 'Logo Image',
			'section' => 'title_tagline',
			'settings' => 'logo-img',
			'priority' => 80
		))
	);
}
add_action('customize_register', 'customize_all_logo');

function customize_footer($wp_customize)
{
	$wp_customize->add_section(
		'footer',
		array(
			'title' => 'Footer',
			'description' => 'Footer',
			'priority' => 25
		)
	);

	$wp_customize->add_setting('ft_slogan', array('default' => ''));
	$wp_customize->add_control(new WP_Customize_Image_Control(
		$wp_customize,
		'ft_slogan',
		array(
			'type' => 'image',
			'section' => 'footer',
			'label' => __('Footer slogan'),
			'description' => __('Footer slogan'),
			'settings' => 'ft_slogan',
		)
	));

	$wp_customize->add_setting('copyright-line', array('default' => ''));
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'copyright-line',
		array(
			'type' => 'text',
			'section' => 'footer',
			'label' => __('Dental copyright line'),
			'description' => __('Change dental copyright line here'),
			'settings' => 'copyright-line',
			'priority' => 86
		)
	));
}
add_action('customize_register', 'customize_footer');

function m_customize_social($wp_customize)
{
	$wp_customize->add_section(
		'social',
		array(
			'title' => 'Social',
			'description' => 'Social',
			'priority' => 25
		)
	);

	$wp_customize->add_setting('Follow_us_title', array('default' => ''));
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'Follow_us_title',
		array(
			'type' => 'text',
			'section' => 'social',
			'label' => __('Follow us title'),
			'settings' => 'Follow_us_title',
		)
	));
	$wp_customize->add_setting('Follow_us_description', array('default' => ''));
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'Follow_us_description',
		array(
			'type' => 'textarea',
			'section' => 'social',
			'label' => __('Follow us description'),
			'settings' => 'Follow_us_description',
		)
	));

	$wp_customize->add_setting('Link_fb', array('default' => ''));
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'Link_fb',
		array(
			'type' => 'text',
			'section' => 'social',
			'label' => __('Link Facebook'),
			'description' => __('Link Facebook'),
			'settings' => 'Link_fb',
		)
	));

	$wp_customize->add_setting('Link_yt', array('default' => ''));
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'Link_yt',
		array(
			'type' => 'text',
			'section' => 'social',
			'label' => __('Link Youtube'),
			'description' => __('Link Youtube'),
			'settings' => 'Link_yt',
		)
	));

	$wp_customize->add_setting('Link_ins', array('default' => ''));
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'Link_ins',
		array(
			'type' => 'text',
			'section' => 'social',
			'label' => __('Link Instagram'),
			'description' => __('Link Instagram'),
			'settings' => 'Link_ins',
		)
	));
	$wp_customize->add_setting('Link_ggplus', array('default' => ''));
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'Link_ggplus',
		array(
			'type' => 'text',
			'section' => 'social',
			'label' => __('Link Google Plus'),
			'description' => __('Link Google Plus'),
			'settings' => 'Link_ggplus',
		)
	));
}
add_action('customize_register', 'm_customize_social');

function m_customize_contact($wp_customize)
{
	$wp_customize->add_section(
		'contact',
		array(
			'title' => 'Contact',
			'description' => 'Contact',
			'priority' => 25
		)
	);

	$wp_customize->add_setting('address_label', array('default' => ''));
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'address_label',
		array(
			'type' => 'text',
			'section' => 'contact',
			'label' => __('Address label'),
			'settings' => 'address_label',
		)
	));
	$wp_customize->add_setting('address', array('default' => ''));
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'address',
		array(
			'type' => 'text',
			'section' => 'contact',
			'label' => __('Dental address'),
			'description' => __('Change dental address here'),
			'settings' => 'address',
		)
	));


	$wp_customize->add_setting('phone_label', array('default' => ''));
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'phone_label',
		array(
			'type' => 'text',
			'section' => 'contact',
			'label' => __('Phone label'),
			'settings' => 'phone_label',
		)
	));
	$wp_customize->add_setting('phone', array('default' => ''));
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'phone',
		array(
			'type' => 'text',
			'section' => 'contact',
			'label' => __('Dental phone 1'),
			'description' => __('Change dental phone here'),
			'settings' => 'phone',
		)
	));

	$wp_customize->add_setting('phone_2', array('default' => ''));
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'phone_2',
		array(
			'type' => 'text',
			'section' => 'contact',
			'label' => __('Dental phone 2'),
			'description' => __('Change dental phone here'),
			'settings' => 'phone_2',
		)
	));


	$wp_customize->add_setting('email_label', array('default' => ''));
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'email_label',
		array(
			'type' => 'text',
			'section' => 'contact',
			'label' => __('Email label'),
			'settings' => 'email_label',
		)
	));
	$wp_customize->add_setting('email', array('default' => ''));
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'email',
		array(
			'type' => 'text',
			'section' => 'contact',
			'label' => __('Dental email'),
			'description' => __('Change dental email here'),
			'settings' => 'email',
		)
	));
	
	$wp_customize->add_setting('emailfooter', array('default' => ''));
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'emailfooter',
		array(
			'type' => 'text',
			'section' => 'contact',
			'label' => __('Dental email Footer'),
			'description' => __('Change dental email footer here'),
			'settings' => 'emailfooter',
		)
	));

	$wp_customize->add_setting('booking_label', array('default' => ''));
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'booking_label',
		array(
			'type' => 'text',
			'section' => 'contact',
			'label' => __('Booking label'),
			'settings' => 'booking_label',
		)
	));
	$wp_customize->add_setting('booking', array('default' => ''));
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'booking',
		array(
			'type' => 'textarea',
			'section' => 'contact',
			'label' => __('Booking description'),
			'settings' => 'booking',
		)
	));

	$wp_customize->add_setting('open-hour', array('default' => ''));
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'open-hour',
		array(
			'type' => 'textarea',
			'section' => 'contact',
			'label' => __('Dental open-hour'),
			'description' => __('Change dental open hour here'),
			'settings' => 'open-hour',
		)
	));

	// Additional phone number
	$wp_customize->add_setting('phone_number_consultation', array('default' => ''));
	$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'phone_number_consultation',array(
			'type' => 'text',
			'section' => 'contact',
			'label' => __('Additional phone number consultation'),
			'description' => __('Change phone number consultation'),
			'settings' => 'phone_number_consultation',
		)
	));

	$wp_customize->add_setting('phone_number_booking', array('default' => ''));
	$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'phone_number_booking',array(
			'type' => 'text',
			'section' => 'contact',
			'label' => __('Additional phone number booking'),
			'description' => __('Change phone number booking'),
			'settings' => 'phone_number_booking',
		)
	));
}
add_action('customize_register', 'm_customize_contact');

// AJAX LOADING
add_action('wp_ajax_loadmore', 'get_post_loadmore');
add_action('wp_ajax_nopriv_loadmore', 'get_post_loadmore');

function get_post_loadmore()
{
	$offset = isset($_POST['offset']) ? (int) $_POST['offset'] : 0;
	$cat = isset($_POST['cat']) ? (int) $_POST['cat'] : 0;
	$query = isset($_POST['query']) ? $_POST['query'] : null;
	$getposts = new WP_query();
	if ($cat != 0) {
		$getposts->query('post_status=publish&showposts=3&offset=' . $offset . '&cat=' . $cat);
	} else if ($query !== null) {
		$getposts->query('post_status=publish&showposts=3&offset=' . $offset . '&post_type=post&s=' . $query);
	}

	global $wp_query;
	$wp_query->in_the_loop = true;
	while ($getposts->have_posts()) : $getposts->the_post(); ?>

			<div class="news-item display-grid">
				<div class="col-md-6 left-side">
					<a href="<?php the_permalink() ?>">
						<?php the_post_thumbnail('large'); ?>
					</a>
				</div>
				<div class="col-md-6 right-side">
					<div class="header">
						<div class="category-row">
							<span>
								<?php global $post;
								$term_list = wp_get_post_terms($post->ID, 'category', ['fields' => 'all']);
								foreach ($term_list as $term) {
									if (get_post_meta($post->ID, '_yoast_wpseo_primary_category', true) == $term->term_id) {
										$primaryCat = $term;
										echo '<a href="' . get_category_link($primaryCat) . '" class="main-cat">';
										echo $term->name;
										echo '</a>';
									}
								}
								?>
								</a>
								<?php foreach ($term_list as $term) {
									if ($term->term_id !== $primaryCat->term_id) {
										echo '<a href="' . get_category_link($term) . '" class="sub-cat">';
										echo $term->name;
										echo '</a>';
									}
								} ?>
								</a>
							</span>

						</div>
						<h5><a href="<?php the_permalink() ?>"><?php echo wp_trim_words(get_the_title(), 20); ?></a></h5>
						<hr class="line-left">
						<div class="sub-title">
							<span class="date"><?php echo get_the_date(); ?></span> <span class="comment"><a href="#">0</a></span>
						</div>
					</div>
					<div class="content">
						<p>
							<?php echo wp_trim_words(get_the_excerpt(), 35); ?>
						</p>
					</div>
					<p class="author">
						<a href="#"><?php echo get_the_author(); ?></a>
					</p>
					<div class="icon-wrap">
						<a href="#"><i class="fab fa-facebook-f fa-lg"></i></a>
						<a href="#"><i class="fab fa-youtube fa-lg"></i></a>
						<a href="#"><i class="fab fa-instagram fa-lg"></i></a>
						<a href="#"><i class="fab fa-google-plus-g fa-lg"></i></a>
					</div>
				</div>
			</div>
			<hr class="line-item mobile-appear">
	<?php endwhile;
	wp_reset_postdata();
	die();
}

function _get_all_image_sizes()
{
	global $_wp_additional_image_sizes;

	$default_image_sizes = get_intermediate_image_sizes();

	foreach ($default_image_sizes as $size) {
		$image_sizes[$size]['width'] = intval(get_option("{$size}_size_w"));
		$image_sizes[$size]['height'] = intval(get_option("{$size}_size_h"));
		$image_sizes[$size]['crop'] = get_option("{$size}_crop") ? get_option("{$size}_crop") : false;
	}

	if (isset($_wp_additional_image_sizes) && count($_wp_additional_image_sizes)) {
		$image_sizes = array_merge($image_sizes, $_wp_additional_image_sizes);
	}

	return $image_sizes;
}


// breadcrumb page 

function m_breadcrumb_page()
{
	echo '<ul>';
	global $post;
	$parent = $post->post_parent;
	if ($post->post_parent) :
		echo 	'<li><a href="' . get_permalink($parent) . '"><i class="fa fa-tags" aria-hidden="true"></i>' . get_the_title($parent) . '</a></li>';
	endif;

	echo '<li>' . get_the_title($post->ID) . '</li>';
	echo '</ul>';
}

add_theme_support('yoast-seo-breadcrumbs');

// Additional phone number

// function m_additional_phone_number ($wp_customize) {
// 	$wp_customize->add_section(
// 		'additional_phone',
// 		array(
// 			'title' => 'Additional Phone Number',
// 			'description' => 'Additional Phone Number',
// 			'priority' => 40
// 		)
// 	);


	
// }

// add_action('customize_register', 'm_additional_phone_number');
