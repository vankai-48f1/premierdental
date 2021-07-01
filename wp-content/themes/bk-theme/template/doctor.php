<?php

/**
 * Template Name: doctor template
 */
get_header();
?>

<div class="doctor-page container display-grid">
    <figure class="col-md-6">
        <?php the_post_thumbnail('large'); ?>
    </figure>
    <main class="col-md-6">
        <h1 class="text-center"><?php the_title(); ?></h1>
        <?php the_content(); ?>

        <p>Read more:</p>

        <?php
        $currentID = get_the_ID();
        $query = new WP_Query(array(
            'post__not_in' => array($currentID),
            'post_type' => 'page' ,
            'post_status' => 'publish',
            'meta_key' => '_wp_page_template',
            'meta_value' => 'template/doctor.php',
            'posts_per_page' => -1
        ));

        if ( $query->have_posts() ) : ?>
            <ul>
                <?php while ($query->have_posts()) : $query->the_post(); ?>
                    <li><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></li>
                <?php endwhile; // end of the loop. 
                ?>
            </ul>
        <?php endif; ?>

    </main>
</div>

<?php get_footer(); ?>