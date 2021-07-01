<?php

/**
 * Template Name: letter-to-customer template
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
</div>

<?php get_footer(); ?>