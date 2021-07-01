<?php

/**
 * Template Name: about-us template
 */
get_header();
?>

<div class="about-us-page">
    <div class="bg-white">
        <div class="container">
            <section class="row letter-to-customer">
                <div class="col-md-8 info">
                    <?php
                    $bossHeader =  get_field('boss_title');
                    echo $bossHeader ? $bossHeader : '';
                    ?>

                    <div class="padding-left">

                        <?php
                        $bossDescription =  get_field('boss_description');
                        echo $bossDescription ? $bossDescription : '';
                        ?>

                        <div class="signature">
                            <div class="name">
                                <span>
                                    <?php $bossInfo =  get_field('boss_nps');
                                    echo $bossInfo['name'] ? $bossInfo['name'] : '';
                                    ?>
                                </span><br>
                                <span><?php echo $bossInfo['position'] ?></span>
                            </div>
                            <div class="image">
                                <?php $signature = $bossInfo['signature'];
                                echo $signature ? wp_get_attachment_image($signature, 'medium') : '';
                                ?>
                            </div>
                        </div>

                        <br><br><br>

                    </div>

                </div>
                <div class="col-md-4 image-right">
                    <div class="position-right-bot">
                        <?php $bossAvatar = get_field('boss_image');
                        echo $bossAvatar ? wp_get_attachment_image($bossAvatar, 'large') : '<img src="' . get_bloginfo('template_directory') . '/images/home-intro-img-min.png" alt="BOSS">';
                        ?>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="bg-gray">
        <div class="container">
            <section class="doctor employee-intro">
                <h1 class="heading">
                    <?php $header = get_field('doctor_section_header');
                    echo $header ? $header : 'Our <span class="bold">Doctor</span>';
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



    <div class="bg-white">
        <div class="container">
            <section class="differences">
                <h1 class="heading">
                    <?php $header = get_field('different_section_header');
                    echo $header ? $header : 'ĐIỀU LÀM NÊN SỰ KHÁC BIỆT <br> <span class="bold">CỦA CHÚNG TÔI</span>';
                    ?>
                </h1>

                <div class="row content list-service">
                    <?php
                    $rows = get_field('different_section_info');
                    $count = 1;
                    if ($rows) : foreach ($rows as $row) :
                            $icon = $row['icon'];
                            $title = $row['title'];
                            $desc = $row['description'];
                            if ($count <= 3) :
                    ?>

                                <div class="item col-md-4">
                                    <?php echo wp_get_attachment_image($icon, 'medium'); ?>
                                    <div class="info">
                                        <p>
                                            <?php echo $title; ?>
                                        </p>
                                        <hr class="line-middle">
                                        <p class="description">
                                            <?php echo $desc; ?>
                                        </p>
                                    </div>
                                </div>
                            <?php else :  ?>
                                <div class="item col-md-4 sect<?php echo $count; ?>">
                                    <?php echo wp_get_attachment_image($icon, 'medium'); ?>
                                    <div class="info">
                                        <p>
                                            <?php echo $title; ?>
                                        </p>
                                        <hr class="line-middle">
                                        <p class="description">
                                            <?php echo $desc; ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php $count++; ?>
                    <?php endforeach;
                    endif; ?>

                </div>

                <p class="quote">
                    <?php //$quote = get_field('different_section_quote');
                    // echo $quote;
                    ?>
                    <a class="btn-readmore" href="#">Liên hệ tư vấn</a>

                </p>
            </section>
        </div>
    </div>

</div>

<?php get_footer(); ?>