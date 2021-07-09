<?php

/**
 * Template Name: Homepage
 */
get_header();
?>

<?php get_template_part('partials/home', 'slider'); ?>

<section class="home-page">
    <div class="wrap-ss-primary">
        <section class="goodpoint">
            <div class="container">
                <div class="wow animate__animated animate__lightSpeedInLeft">
                    <?php $headerQuality = get_field('quality_header');
                    echo $headerQuality;
                    ?>
                </div>


                <div class="row">
                    <?php
                    if (have_rows('quality')) :;
                        while (have_rows('quality')) : the_row();
                            $quantity_img = get_sub_field('image');
                            $quantity_title = get_sub_field('title');
                            $quantity_description = get_sub_field('description');
                            $quantity_url = get_sub_field('url');
                            ?>
                            <div class="item-goodpoint col-md-3 wow animate__animated animate__zoomIn animate__delay-1s">
                                <img src="<?php echo $quantity_img['url'] ?>" alt="">
                                <div>
                                    <h5><?php echo $quantity_title; ?></h5>
                                    <hr>
                                    <p><?php echo $quantity_description; ?></p>
                                </div>
                                <div class="link-goodpoint">
                                    <?php
                                            if ($quantity_url) :
                                                $url_link_all = $quantity_url['url'];
                                                $name_link_all = $quantity_url['title'];
                                                ?>
                                        <a class="btn-readmore" href="<?php echo esc_url($url_link_all) ?>">
                                            <?php echo esc_html($name_link_all) ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                    <?php endwhile;
                    else :
                    // no rows found
                    endif;
                    ?>
                </div>
            </div>
        </section>

        <section class="boss-intro">
            <div class="container row">
                <div class="avatar col-md-4 wow animate__animated animate__fadeInLeft">
                    <?php $bossAvatar = get_field('boss_image');
                    echo $bossAvatar ? wp_get_attachment_image($bossAvatar, 'large') : '<img src="' . get_bloginfo('template_directory') . '/images/home-intro-img-min.png" alt="BOSS">';
                    ?>
                </div>
                <div class="introduction-content col-md-8 wow animate__animated animate__fadeInRight animate__delay-1s">
                    <?php $bossHeader =  get_field('boss_title');
                    echo $bossHeader ? $bossHeader : '';
                    ?>
                    <p>
                        <?php $bossDescription =  get_field('boss_description');
                        echo $bossDescription ? $bossDescription : '';
                        ?>
                    </p>
                    <?php
                    if (have_rows('boss_nps')) :;
                        while (have_rows('boss_nps')) : the_row();
                            $boss_name = get_sub_field('name');
                            $boss_position = get_sub_field('position');
                            $boss_signature = get_sub_field('signature');
                            $boss_url = get_sub_field('url');
                            ?>
                            <a href="<?php echo  esc_url($boss_url['url']) ?>" class="readmore"><?php echo esc_html($boss_url['title']) ?></a>
                            <div class="signature">
                                <div class="name">
                                    <span>
                                        <?php
                                                echo $boss_name ? $boss_name : '';
                                                ?>
                                    </span><br>
                                    <span><?php echo $boss_position ?></span>
                                </div>
                                <div class="image">
                                    <img src="<?php echo $boss_signature['url'] ?>" alt="">
                                </div>
                            </div>
                    <?php endwhile;
                    else :
                    // no rows found
                    endif;
                    ?>
                </div>
            </div>

        </section>
    </div>
    <section class="employee-intro">
        <div class="row container">
            <?php
            if (have_rows('dentist')) :;
                while (have_rows('dentist')) : the_row();
                    $dentist_avt = get_sub_field('avatar');
                    $dentist_name = get_sub_field('name');
                    $dentist_history = get_sub_field('history');
                    $dentist_url = get_sub_field('url');
                    ?>
                    <div class="employee-item col-md-4 wow animate__animated animate__zoomIn animate__delay-1s">
                        <img src="<?php echo $dentist_avt['url'] ?>" alt="dentist">
                        <div class="employee-information">
                            <h5>
                                <a href="<?php echo esc_url($dentist_url['url']); ?>"><?php echo $dentist_name; ?></a>
                            </h5>
                        </div>
                        <div class="link-employee">
                            <a href="<?php echo esc_url($dentist_url['url']); ?>" class="btn-readmore"><?php echo esc_html($dentist_url['title']); ?></a>
                        </div>
                    </div>

            <?php endwhile;
            else :
            // no rows found
            endif;
            ?>
        </div>
    </section>

    <section class="service">
        <div class="container">
            <h5 class="">
                <?php $headerService = get_field('header');
                echo $headerService;
                ?>
            </h5>
            <hr class="line-left ">
            <div class="display-grid">
                <div class="col-md-8 wow animate__animated animate__fadeInLeft">
                    <?php $titleService = get_field('title');
                    echo $titleService;
                    ?>

                    <p class="description">
                        <?php $descriptionService = get_field('description');
                        echo $descriptionService;
                        ?>
                    </p>
                </div>
                <div class="col-md-4 wow animate__animated animate__fadeInRight animate__delay-1s">
                    <div class="consult-box">
                        <span>
                            <?php $consultboxHeader = get_field('consult-box-header');
                            echo $consultboxHeader
                            ?>
                        </span>
                        <hr class="line-left">
                        <?php $consultboxContent = get_field('consult-box-content');
                        echo $consultboxContent;
                        ?>

                        <?php $link_lienhe = get_field('link_contact_lienhe');
                        if ($link_lienhe) : ?>
                            <a href="<?php echo esc_url($link_lienhe['url']) ?>"><?php echo esc_html($link_lienhe['title']) ?></a>
                        <?php
                        endif;
                        ?>
                    </div>
                </div>
                <div class="list-service row">
                    <?php
                    $rows = get_field('service');
                    if ($rows) : foreach ($rows as $row) :
                            $name = $row['name'];
                            $description = $row['description'];
                            $url = $row['url'];
                            $image = $row['image'];
                            ?>

                            <div class="item col-md-4 wow animate__animated animate__zoomIn animate__delay-1s">
                                <a href="<?php echo $url; ?>">
                                    <?php echo wp_get_attachment_image($image, 'medium'); ?>
                                </a>
                                <div class="info">
                                    <p>
                                        <a href="<?php echo $url; ?>"><?php echo $name; ?></a>
                                    </p>
                                    <hr class="line-middle">
                                    <p class="description">
                                        <?php echo $description; ?>
                                    </p>
                                </div>
                            </div>

                    <?php endforeach;
                    endif; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="notification">
        <div class="container">
            <h5><?php echo get_field('notification_title_top') ?></h5>
            <hr class="line-left">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="black-title">
                        <?php $notificationHeader = get_field('notification-header');
                        if (!empty($notificationHeader))
                            echo $notificationHeader;
                        ?>
                    </h3>
                    <p>
                        <?php $notificationDesc = get_field('notification-description');
                        if (!empty($notificationDesc))
                            echo $notificationDesc;
                        ?>
                    </p>
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
        <div class="right-img">
            <img src="<?php bloginfo('template_directory'); ?>/images/home-notification-img-min.png" alt="">
        </div>
    </section>

    <section class="patients-testimonial">
        <div class="container">
            <?php $testHeader = get_field('testimonial_header');
            if (!empty($testHeader)) {
                echo $testHeader;
            }
            ?>

            <div class="display-grid">
                <?php
                $count = 1;
                $rows = get_field('testimonial_video_content');
                if ($rows) : foreach ($rows as $row) :
                        $image = $row['image'];
                        $id = $row['youtube_id'];
                        $bottom = $row['bottom'];
                        ?>

                        <div class="col-md-6 <?php echo $count % 2 !== 0 ? 'wow animate__animated animate__fadeInLeft' : 'wow animate__animated animate__fadeInRight' ?>">
                            <div class="video-wrapper">
                                <?php echo wp_get_attachment_image($image, 'large', false, ['data-id' => $id]); ?>
                            </div>
                            <div>
                                <?php echo $bottom; ?>
                            </div>
                        </div>

                <?php $count++;
                    endforeach;
                endif; ?>

            </div>
        </div>
    </section>

    <section class="update">
        <div class="container">
            <h2 class="first-title">
                <?php $updateHeader = get_field('update-header');
                if (!empty($updateHeader))
                    echo $updateHeader;
                ?>
            </h2>
            <div class="display-grid">
                <div class="col-md-8 description">
                    <?php $updateDescription = get_field('update-description');
                    if (!empty($updateDescription))
                        echo $updateDescription;
                    ?>
                </div>
                <div class="col-md-4 view-all">
                    <?php $link_view_all_news = get_field('link_view_all_news');

                    if ($link_view_all_news) : ?>
                        <a href="<?php echo esc_url($link_view_all_news['url']) ?>" class=""><?php echo esc_html($link_view_all_news['title']) ?></a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="list-news-update row">
                <?php $getposts = new WP_query();
                $getposts->query('post_status=publish&showposts=3&post_type=post&cat=3');
                ?>
                <?php global $wp_query;
                $wp_query->in_the_loop = true; ?>
                <?php while ($getposts->have_posts()) : $getposts->the_post(); ?>
                    <div class="col-md-4 wow animate__animated animate__zoomIn">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('large'); ?>
                        </a>
                        <p></p>
                        <div class="info">
                            <div class="content">
                                <h5>
                                    <a href="<?php the_permalink() ?>"><?php echo wp_trim_words(get_the_title(), 10); ?></a>
                                </h5>
                                <p>
                                    <?php echo wp_trim_words(get_the_excerpt()); ?>
                                </p>
                                <span class="plus"><i class="fas fa-plus fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                <?php endwhile;
                wp_reset_postdata(); ?>

            </div>
        </div>
    </section>

</section>

<?php get_footer(); ?>