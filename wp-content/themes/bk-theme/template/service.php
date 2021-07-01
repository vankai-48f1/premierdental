<?php

/**
 * Template Name: Service template
 */
get_header();
?>

<div class="container">
    <section class="page-services-group main-content">
        <div class="header-area">
            <h5>
                <?php $headerService = get_field('header_text');
                echo $headerService;
                ?>
            </h5>
            <hr class="line-middle">
            <span class="h-title">
                <?php $titleService = get_field('title');
                echo $titleService;
                ?>
            </span>

            <p class="description">
                <?php $descriptionService = get_field('description');
                echo $descriptionService;
                ?>
            </p>
        </div>
        <div class="display-grid">
            <?php
            $args = array(
                'post_type'      => 'page',
                'posts_per_page' => -1,
                'post_parent'    => $post->ID,
                'order'          => 'ASC',
                'orderby'        => 'date'
            );


            $parent = new WP_Query($args);

            if ($parent->have_posts()) : ?>

                <?php while ($parent->have_posts()) : $parent->the_post(); ?>

                    <div class="col-md-4 service-page-item">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail(array(390,260)) ?>
                        </a>
                        <div class="inner_description">
                            <a href="<?php the_permalink(); ?>">
                                <h5 class="title-with-isearch"><?php the_title(); ?></h5>

                                <hr class="line-middle">
                                <p>
                                    <?php $description = get_field('description');
                                    
                                    echo $description ? $description : wp_trim_words(get_the_excerpt(),30); ?>
                                </p>
                            </a>
                            
                            <span></span>
                        </div>
                        
                        <div class="title">
                            <h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                        </div>
                    </div>

                <?php endwhile; ?>

            <?php endif;
            wp_reset_postdata(); ?>

        </div>

    </section>
</div>

<?php get_footer(); ?>