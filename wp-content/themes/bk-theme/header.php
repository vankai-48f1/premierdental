<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- JQUERY -->
    <script src="<?php bloginfo('template_directory'); ?>/js/jquery-3.5.1.min.js"></script>

    <!-- MY CSS -->
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/style.css">

    <!-- SLIDER(SLICK LIBRARY) -->
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/slick.css" />
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/slick-theme.css" />

    <!-- ICON AWESOME -->
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/all.min.css">
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/font-awesome.css">

    <!-- ANIMATION -->
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/animate.min.css">

    <?php wp_head(); ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-198272900-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-198272900-1');
    </script>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-59B7DC8');</script>
    <!-- End Google Tag Manager -->
    <!-- Facebook Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '308275564104924');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=308275564104924&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Facebook Pixel Code -->


</head>

<body>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-59B7DC8"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    <section class="main-body">

        <a class='btn-top'></a>
        <?php $phone = get_theme_mod('phone');
        $phone_2 = get_theme_mod('phone_2'); ?>
        <div class="phone-group">
            <div class="phonering-alo-ph-circle"></div>
            <div class="phonering-alo-ph-circle-fill"></div>
            <?php if ($phone) : ?>
                <a href="tel:<?php echo $phone ?>" class='btn-phone'></a>
            <?php endif; ?>
        </div>

        <header>
            <div class="float-infomation">
                <div class="container row">
                    <span class="site-name mobile-disappear"><?php bloginfo('name'); ?></span>
                    <span class="phone mobile-disappear">
                        <i class="fas fa-phone fa-lg"></i>

                        <?php if ($phone) :
                        ?>
                            <a href="tel:<?php echo $phone  ?>">
                                <?php echo $phone ?>
                            </a>
                        <?php endif;
                        if ($phone_2) : ?>
                            &ensp;or&ensp;
                            <a href="tel:<?php echo $phone_2 ?>">
                                <?php echo $phone_2 ?>
                            </a>
                        <?php endif; ?>
                    </span>
                    <span class="address mobile-disappear">
                        <i class="fa fa-map-pin" aria-hidden="true"></i>&ensp;
                        <?php $address = get_theme_mod('address');
                        echo $address   ?>
                    </span>
                    <span class="language">
                        <i class="fas fa-search fa-2x menu-btn-search-js"></i>
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'language',
                                'container' => false,
                                'menu_class'      => 'trans-language',
                            )
                        );
                        ?>
                    </span>
                </div>
            </div>

            <div class="float-menu">
                <div class="container row">

                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'primary-menu',
                            'container' => 'nav',
                            'depth'  => 3,
                            'container_class' => 'main-nav mobile-disappear primary-menu-left',
                        )
                    );
                    ?>

                    <div class="language-mb">
                        <!-- <span class="icon-globe"><i class="fa fa-globe" aria-hidden="true"></i></span> -->
                    
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'language',
                                'container' => false,
                                'menu_class'      => 'trans-language',
                            )
                        );
                        ?>
                    </div>

                    <div class="logo">
                        <?php $logo = get_theme_mod('logo-img');
                        $logoID = attachment_url_to_postid($logo);
                        if (!empty($logo)) : ?>

                            <a href="<?php echo home_url(); ?>">
                                <?php echo wp_get_attachment_image($logoID, 'large', false, array('alt' => 'LOGO')); ?>
                            </a>

                        <?php endif; ?>
                    </div>

                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'primary-menu-right',
                            'container' => 'nav',
                            'depth'  => 3,
                            'container_class' => 'main-nav mobile-disappear primary-menu-right',
                        )
                    );
                    ?>

                    <div class="icon-wrap">
                        <i class="fa fa-bars menu-btn-js mobile-appear"></i>
                    </div>
                </div>
            </div>

        </header>