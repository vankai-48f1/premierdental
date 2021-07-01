<?php get_header(); ?>
<?php get_template_part('partials/header', 'img'); ?>

<section class="main-content">
    <div class="container display-grid">
        <article class="col-md-8" id="content">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <div class="news-item display-grid">
                        <div class="col-md-6 left-side">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('large'); ?>
                            </a>
                        </div>

                        <div class="col-md-6 right-side">
                            <div class="header">
                                <div class="category-row">
                                    <span>
                                        <?php
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
                <?php endwhile; ?>

            <?php else : ?>
                <h3 class="no-result">Sr, there is no update that match your search input</h3>
            <?php endif; ?>
        </article>

        <?php get_sidebar();  ?>

    </div>
</section>

<input class="url-admin" value="<?php echo admin_url('admin-ajax.php'); ?>"></input>
<input class="default-post-load" value="<?php echo get_option('posts_per_page'); ?>"></input>


<input class="search-query" value="<?php echo get_search_query(); ?>"></input>


<?php get_footer(); ?>