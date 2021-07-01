<section class="header-img">
    <?php $headerImage = get_field('header_image');
    $catID = get_query_var('cat');
    $tag = get_queried_object();
    ?>
    <!-- < ?php echo $headerImage ? wp_get_attachment_image($headerImage, array(1024, 1024)) : '<img src="' . get_bloginfo('url') . '/wp-content/uploads/2020/10/page-headline-08.jpg" alt="">'; ?> -->
    <div class="container">
        <div class="page-info">
            <!-- < ?php
            if (is_page()) : ?>
                <span class="title">< ?php echo get_the_title(); ?></span>
                < ?php elseif (is_single()) :

                $categories = get_the_category();
                $len = 0;
                foreach ($categories as $category) : $len++;
                ?>
                    <span class="title">< ?php echo $category->name ?></span>
            < ?php if ($len == 1) break;
                endforeach;
            endif; ?>

            <span class="title">
                < ?php echo is_category() ? get_cat_name($catID) : '' ?>
                < ?php echo is_search() ? 'SEARCH' : '' ?>
                < ?php echo (is_archive() && !is_category() && !is_tag()) ? 'ARCHIVE' : '' ?>
                < ?php echo is_tag() ? $tag->name : '' ?>
            </span>
            <hr class="line-left">
            <div class="subTitle">
                < ?php if (is_single() || is_page()) {
                    $subTitle = get_field('subtitle');
                    echo $subTitle ? $subTitle : '';
                }
                ?>
                < ?php echo is_category() ? category_description($catID) : '' ?>
                < ?php echo (is_archive() && !is_category() && !is_tag()) ? get_the_archive_title() : '' ?>
                < ?php echo is_search() ? 'keyword: \'' . get_search_query() . '\'' : '' ?>
                < ?php echo is_tag() ? $tag->description : '' ?>
            </div> -->
        </div>
    </div>
</section>