<?php get_header(); ?>
<?php get_template_part('partials/header', 'img'); ?>

<section class="single main-content">
    <div class="container display-grid">
        <article class="col-md-8" id="content">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>

                    <div class="news-item display-grid">
                        <div class="header col-12">
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
                            <h5><?php echo get_the_title(); ?></h5>
                            <hr class="line-left">
                            <div class="sub-title">
                                <span class="date"><?php echo get_the_date(); ?></span>
                                <span class="author"> <a href="#"><?php echo get_the_author(); ?></a></span>
                                <span class="comment"><a href="#">0</a></span>
                            </div>
                        </div>

                        <div class="col-12 img-block">
                            <!-- < ?php the_post_thumbnail('large'); ?> -->
                        </div>

                        <div class="col-12">
                            <div class="content">
                                <?php the_content(); ?>
                            </div>
                            <div class="display-flex bottom">
                                <div class="tagcloud">
                                    <?php the_tags('', ' ') ?>
                                </div>
                                <div class="icon-wrap">
                                    <a href="#"><i class="fab fa-facebook-f fa-lg"></i></a>
                                    <a href="#"><i class="fab fa-youtube fa-lg"></i></a>
                                    <a href="#"><i class="fab fa-instagram fa-lg"></i></a>
                                    <a href="#"><i class="fab fa-google-plus-g fa-lg"></i></a>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="btn-contact-us">
                        <?php dynamic_sidebar('link_contact') ?>
                    </div>
                    <!-- POPUP CONTACT FORM -->
                    <div class="popup-booking-form">
                        <div class="popup-section">
                            <a href="#" class="closer-popup"><i class="fa fa-times" aria-hidden="true"></i></a>
                            <?php echo do_shortcode(' [contact-form-7 id="366" title="Contact page - contact form"] '); ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </article>

        <?php get_sidebar(); ?>

    </div>
</section>

<?php get_footer(); ?>