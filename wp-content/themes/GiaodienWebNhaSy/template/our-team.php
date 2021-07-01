<?php

/**
 * Template Name: our team template
 */
get_header();
?>

<div class="about-us-page">
    <div class="bg-gray">
        <div class="container">
            <section class="doctor employee-intro">
                <h1 class="heading">
                    <?php
                    if (have_rows('title_our_team')) :;
                        while (have_rows('title_our_team')) : the_row();
                        echo get_sub_field('title_our_team_left'); 
                        echo ' <span class="bold">' . get_sub_field('title_our_team_right') . '</span>';
                        ?>
                        <?php endwhile;
                    else :
                    // no rows found
                    endif;
                    ?>
                </h1>

                <div class="row">
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
                                <hr>
                                <p>
                                    <?php echo $dentist_history; ?>
                                </p>
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
        </div>
    </div>

</div>

<?php get_footer(); ?>