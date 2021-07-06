<?php

/**
 * Template Name: Contact template
 */
get_header();
?>

<?php get_template_part('partials/header', 'img'); ?>

<div class="container">
    <section class="page main-content contact-current">
        <div class="display-grid">
            <div class="col-md-9 header-area">
                <h5>
                    <?php $headerService = get_field('header_text');
                    echo $headerService;
                    ?>
                </h5>
                <hr class="line-left">
                <span class="title">
                    <?php $titleContact = get_field('title');
                    echo $titleContact;
                    ?>
                </span>

                <p class="description">
                    <?php $descriptionContact = get_field('description');
                    echo $descriptionContact;
                    ?>
                </p>
            </div>
        </div>
        <div class="booking-form">
            <div class="display-grid map-form-row">
                <div class="col-md-6">
                    <div class="location-map">
                        <?php
                        echo get_field('map_iframe');
                        ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <?php echo do_shortcode(' [contact-form-7 id="366" title="Contact page - contact form"] '); ?>
                </div>
            </div>
        </div>


        <hr class='contact-line-top'>

        <section class="display-grid text-center contact-guide">
            <div class="col-md-3">
                <span class="consultation-icon">
                    <i class="fas fa-map-marker-alt fa-5x"></i>
                </span>
                <p><?php echo get_theme_mod('address_label'); ?></p>
                <p>
                    <?php echo get_theme_mod('address'); ?>
                </p>
            </div>
            <div class="col-md-3">
                <span class="consultation-icon">
                    <i class="fas fa-phone"></i>
                </span>
                <p><?php echo get_theme_mod('phone_label'); ?></p>
                <p>
                    <?php $phone = get_theme_mod('phone');
                    $phone_2 = get_theme_mod('phone_2'); ?>
                    <a href="tel:<?php echo $phone ?>"><?php echo $phone ?></a><br>
                    <a href="tel:<?php echo $phone_2 ?>"><?php echo $phone_2 ?></a>
                </p>
            </div>
            <div class="col-md-3">
                <a href="mailto:<?php echo get_theme_mod('email'); ?>" class="consultation-icon">
                    <span style='
                        background-image: url("data:image/svg+xml;base64,PHN2ZyBoZWlnaHQ9JzMwMHB4JyB3aWR0aD0nMzAwcHgnICBmaWxsPSIjMzQ1MDczIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiBzdHJva2Utd2lkdGg9IjAuNTAxIiBzdHJva2UtbGluZWpvaW49ImJldmVsIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiIHZlcnNpb249IjEuMSIgb3ZlcmZsb3c9InZpc2libGUiIHZpZXdCb3g9IjAgMCA3NSA3NSIgeD0iMHB4IiB5PSIwcHgiPjxnIGZpbGw9Im5vbmUiIHN0cm9rZT0iYmxhY2siIGZvbnQtZmFtaWx5PSJUaW1lcyBOZXcgUm9tYW4iIGZvbnQtc2l6ZT0iMTYiIHRyYW5zZm9ybT0ic2NhbGUoMSAtMSkiPjxnIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAgLTc1KSI+PGc+PHBhdGggZD0iTSAxOC42MiwyNC40IEMgMTguMjQ2LDI0LjU3MyAxNy44NzQsMjQuNzUgMTcuNTAxLDI0LjkzMSBMIDExLjk2NywyNC45MzEgQyA5Ljc1LDI0LjkzMSA3Ljk1LDI2LjczMSA3Ljk1LDI4Ljk0OCBMIDcuOTUsMzcuMTQ1IEMgNy45NSwzOS4yNTEgOS41NzUsNDAuOTgxIDExLjYzOSw0MS4xNDkgQyAxNC4zMjIsNTUuMzIgMjQuODg0LDY0LjE3NyAzNy41NDIsNjQuMTc3IEMgNTAuMjAxLDY0LjE3NyA2MC43NjQsNTUuMzE3IDYzLjQ0NSw0MS4xNCBDIDY1LjQ2OCw0MC45MzQgNjcuMDUsMzkuMjIyIDY3LjA1LDM3LjE0NSBMIDY3LjA1LDI4Ljk0OCBDIDY3LjA1LDI2LjczMSA2NS4yNSwyNC45MzEgNjMuMDMzLDI0LjkzMSBMIDU2Ljg2NiwyNC45MzEgQyA1Ni44MDUsMjQuOTMxIDU2Ljc0NSwyNC45MzIgNTYuNjg2LDI0LjkzNCBDIDUzLjMwMywxNi41OTcgNDUuOTk5LDEwLjgyMyAzNy41NDIsMTAuODIzIEMgMjkuMjYzLDEwLjgyMyAyMi4wOTIsMTYuMzUxIDE4LjYyLDI0LjQgWiBNIDU2Ljc5NywzNS4yNzcgQyA1Ni43OTcsMzYuNjI5IDU2LjY5MywzNy45MjkgNTYuNDk0LDM5LjE3MiBDIDUzLjQ3NCw0MC4zMzUgNTAuODYsNDIuMDQzIDQ5LjE2MSw0NC45NjUgQyA0OC44Nyw0My4zMTIgNDcuNTMxLDQyLjA3OCA0NS43NDIsNDEuMDIzIEMgNDUuMzM5LDQyLjcwMiA0NC42MjEsNDQuMzA0IDQzLjAwOSw0NS42ODMgQyA0MS40NDEsNDMuMTc0IDM5LjYzMyw0MC43NjEgMzYuNTE0LDM4Ljg3MiBDIDM2LjA5OCw0MC41MyAzNS4yNSw0Mi4xODkgMzMuNjQ4LDQzLjg0NyBDIDI5LjM2NSw0MC42NjEgMjQuMzM1LDM4LjU0MSAxOC40MDMsMzcuNzExIEMgMTguMzI3LDM2LjkyIDE4LjI4OCwzNi4xMDggMTguMjg4LDM1LjI3NyBDIDE4LjI4OCwzMi41MjMgMTguNzE3LDI5Ljg4NiAxOS41MDIsMjcuNDUgQyAyMy42NDcsMjUuNDkxIDI3LjY2MiwyNC4wOTggMzIuNTIzLDIzLjcyOCBDIDMzLjQsMjQuNTYzIDM0LjkyOSwyNS4xMTcgMzYuNjY4LDI1LjExNyBDIDM5LjM4NywyNS4xMTcgNDEuNTk0LDIzLjc2MyA0MS41OTQsMjIuMDk0IEMgNDEuNTk0LDIwLjQyNiAzOS4zODcsMTkuMDcxIDM2LjY2OCwxOS4wNzEgQyAzNC44MzgsMTkuMDcxIDMzLjIzOSwxOS42ODQgMzIuMzg5LDIwLjU5NCBDIDI4LjI2OCwyMC44OTYgMjQuNzE4LDIxLjg2NiAyMS4zMjQsMjMuMjI3IEMgMjQuNzQ4LDE3LjAyOSAzMC43MzQsMTIuOTIxIDM3LjU0MiwxMi45MjEgQyA0OC4xNywxMi45MjEgNTYuNzk3LDIyLjkzNiA1Ni43OTcsMzUuMjc3IFogTSAyNi43NjUsMzMuNjkgQyAyNi43NjUsMzUuMjMgMjguMDE2LDM2LjQ4MiAyOS41NTcsMzYuNDgyIEMgMzEuMDk5LDM2LjQ4MiAzMi4zNSwzNS4yMyAzMi4zNSwzMy42OSBDIDMyLjM1LDMyLjE0OSAzMS4wOTksMzAuODk4IDI5LjU1NywzMC44OTggQyAyOC4wMTYsMzAuODk4IDI2Ljc2NSwzMi4xNDkgMjYuNzY1LDMzLjY5IFogTSA0Mi41MTYsMzMuNjkgQyA0Mi41MTYsMzUuMjMgNDMuNzY3LDM2LjQ4MiA0NS4zMDksMzYuNDgyIEMgNDYuODUsMzYuNDgyIDQ4LjEwMSwzNS4yMyA0OC4xMDEsMzMuNjkgQyA0OC4xMDEsMzIuMTQ5IDQ2Ljg1LDMwLjg5OCA0NS4zMDksMzAuODk4IEMgNDMuNzY3LDMwLjg5OCA0Mi41MTYsMzIuMTQ5IDQyLjUxNiwzMy42OSBaIE0gMzcuNTM5LDU4LjkyNyBDIDQ3LjYwNSw1OC45MjcgNTYuMDQyLDUyLjEyNCA1OC4yMjQsNDEuMTYyIEwgNjAuMTM0LDQxLjE2MiBDIDU3LjU1NCw1My42ODcgNDguMzgzLDYxLjM3MyAzNy41NDIsNjEuMzczIEMgMjYuNjk5LDYxLjM3MyAxNy41MjcsNTMuNjg3IDE0Ljk0OCw0MS4xNjIgTCAxNi44NTQsNDEuMTYyIEMgMTkuMDM1LDUyLjEyNCAyNy40NzQsNTguOTI3IDM3LjUzOSw1OC45MjcgWiIgZmlsbD0iIzM0NTA3MyIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2Utd2lkdGg9IjAuNDQ4IiBzdHJva2U9Im5vbmUiIG1hcmtlci1zdGFydD0ibm9uZSIgbWFya2VyLWVuZD0ibm9uZSIgc3Ryb2tlLW1pdGVybGltaXQ9Ijc5Ljg0MDMxOTM2MTI3NzUiPjwvcGF0aD48L2c+PC9nPjwvZz48L3N2Zz4=");
                        '>
                    </span>
                </a>
                <p><?php echo get_theme_mod('email_label'); ?></p>
                <a href="tel:<?php echo get_theme_mod('phone_number_consultation'); ?>"><?php echo get_theme_mod('phone_number_consultation'); ?>
                </a>
                <br>
                <a href="mailto:<?php echo get_theme_mod('email');   ?>">
                    <?php echo get_theme_mod('email');   ?>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?php echo get_permalink(615) ?>" class="consultation-icon">
                    <i class="far fa-calendar fa-5x" aria-hidden="true"></i>
                </a>

                <p><?php echo get_theme_mod('booking_label'); ?></p>
                <p>
                    <a href="tel:<?php echo get_theme_mod('phone_number_booking'); ?>"><?php echo get_theme_mod('phone_number_booking'); ?>
                    </a>
                    <br>
                    <a href="<?php echo get_permalink(615) ?>">
                        <?php echo get_theme_mod('booking'); ?>
                    </a>
                </p>
            </div>
        </section>
    </section>
</div>
<?php
$link_fb = get_theme_mod('Link_fb');
$link_yt = get_theme_mod('Link_yt');
$link_ins = get_theme_mod('Link_ins');
$link_ggplus = get_theme_mod('Link_ggplus');
?>
<section class="follow-us">
    <div class="container text-center">
        <h2><?php echo get_theme_mod('Follow_us_title'); ?></h2>
        <hr class="line-middle">
        <p><?php echo get_theme_mod('Follow_us_description'); ?></p>
        <div class="icon-wrap">
            <a href="<?php echo $link_fb ?>"><i class="fab fa-facebook-f fa-2x"></i></a>
            <a href="<?php echo $link_yt ?>"><i class="fab fa-youtube fa-2x"></i></a>
            <a href="<?php echo $link_ins ?>"><i class="fab fa-instagram fa-2x"></i></a>
            <a href="<?php echo $link_ggplus ?>"><i class="fab fa-google-plus-g fa-2x"></i></a>
        </div>
    </div>
</section>

<?php get_footer(); ?>