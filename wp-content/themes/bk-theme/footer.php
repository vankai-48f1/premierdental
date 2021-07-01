<footer>
    <section class="container">
        <div class="display-grid slogan-bar">
            <div class="logo col-md-3">
                <?php $logo = get_theme_mod('logo-img');
                $logoID = attachment_url_to_postid($logo);
                ?>
                <a href="<?php echo home_url(); ?>">
                    <?php echo wp_get_attachment_image($logoID, 'medium', false, array('alt' => 'LOGO-FOOTER')); ?>
                </a>
            </div>
            <div class="text col-md-6">
                <p>
                    <?php $slogan = get_theme_mod('ft_slogan');

                    if ($slogan) : ?>
                        <img class="img-slogan" src="<?php echo $slogan; ?>" alt="slogan">
                    <?php endif; ?>
                </p>
            </div>
            <?php
            $link_fb = get_theme_mod('Link_fb');
            $link_yt = get_theme_mod('Link_yt');
            $link_ins = get_theme_mod('Link_ins');
            $link_ggplus = get_theme_mod('Link_ggplus');
            ?>
            <div class="icon-wrap col-md-3">
                <a href="<?php echo $link_fb ?>"><i class="fab fa-facebook-f fa-lg"></i></a>
                <a href="<?php echo $link_yt ?>"><i class="fab fa-youtube fa-lg"></i></a>
                <a href="<?php echo $link_ins ?>"><i class="fab fa-instagram fa-lg"></i></a>
                <a href="<?php echo $link_ggplus ?>"><i class="fab fa-google-plus-g fa-lg"></i></a>
            </div>
        </div>
    </section>
    <?php $phone = get_theme_mod('phone');
    $phone_2 = get_theme_mod('phone_2');
    $email = get_theme_mod('email');
    $emailfooter = get_theme_mod('emailfooter');
    $address = get_theme_mod('address');
    $openHourSection = get_theme_mod('open-hour');

    ?>

    <section class="dental-info">
        <section class="container row">
            <div class="col-md-5 contact">
                <h3><?php bloginfo('name'); ?></h3>
                <ul class="ct-address-ft">
                    <li class="phone-number">
                        <span><i class="fas fa-phone-alt"></i></span>
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
                    </li>
                    <li class="ft-email">
                        <span><i class="far fa-envelope fa-lg"></i></span>
                        <a href="mailto: <?php echo $emailfooter ?>">
                            <?php echo $emailfooter ?>
                        </a>
                    </li>
                    <li class="ft-address">
                        <span><i class="fa fa-map-pin" aria-hidden="true"></i></span>
                        <?php echo $address ?>
                    </li>
                </ul>
            </div>
            <div class="col-md-7 open-hour">
                <h3>Opening hours</h3>
                <pre><?php echo $openHourSection; ?></pre>
            </div>
        </section>
    </section>

    <section class="copyright">
        <div class="container">
            <p>
                <?php $copyright = get_theme_mod('copyright-line');
                echo $copyright; ?>
            </p>
        </div>
    </section>
</footer>
</section>


<section id="mobile-menu" class="mobile-menu">
    <section class="nav">
        <span class="menu-btn-close-js"><i class="fas fa-times text-danger"></i></span>
        <h2>NAVIGATION</h2>
        <div class="icon-wrap">
            <a href="<?php echo $link_fb ?>"><i class="fab fa-facebook-f fa-lg"></i></a>
            <a href="<?php echo $link_yt ?>"><i class="fab fa-youtube fa-lg"></i></a>
            <a href="<?php echo $link_ins ?>"><i class="fab fa-instagram fa-lg"></i></a>
            <a href="<?php echo $link_ggplus ?>"><i class="fab fa-google-plus-g fa-lg"></i></a>
        </div>

        <?php
        wp_nav_menu(
            array(
                'theme_location' => 'primary-menu',
                'container' => 'nav',
            )
        );
        wp_nav_menu(
            array(
                'theme_location' => 'primary-menu-right',
                'container' => 'nav',
            )
        );
        ?>
    </section>

    <section class="search">
        <h2>SEARCH</h2>
        <div class="icon-wrap">
            <a href="<?php echo $link_fb ?>"><i class="fab fa-facebook-f fa-lg"></i></a>
            <a href="<?php echo $link_yt ?>"><i class="fab fa-youtube fa-lg"></i></a>
            <a href="<?php echo $link_ins ?>"><i class="fab fa-instagram fa-lg"></i></a>
            <a href="<?php echo $link_ggplus ?>"><i class="fab fa-google-plus-g fa-lg"></i></a>
        </div>
        <div class="search-group">

            <form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url(home_url('/')); ?>">
                <input type="text" value="<?php get_search_query() ?>" name="s" id="s" class="search-input" />
                <input type="hidden" name="post_type" value="post" />
                <i class="fas fa-search icon"></i>
            </form>

        </div>
    </section>
</section>

<div id="site-overlay" class="site-overlay">
    <div class="video-container">
        <!-- ADD YOUTUBE IFRAME HERE -->
    </div>
</div>

<?php wp_footer(); ?>
<!-- SLIDER(SLICK LIBRARY) -->
<script type="text/javascript" src="<?php bloginfo('template_directory') ?>/js/slick.min.js"></script>

<!-- ANIMATION -->
<script src="<?php bloginfo('template_directory') ?>/js/wow.min.js"></script>
<script>
    new WOW().init();
</script>

<script type="text/javascript" src="<?php bloginfo('template_directory') ?>/js/main.js"></script>

<!-- Messenger Chat plugin Code -->
<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            xfbml: true,
            version: 'v10.0'
        });
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>

<!-- Your Chat plugin code -->
<div class="fb-customerchat" attribution="biz_inbox" page_id="439170229876451">
</div>

</div>
</body>

</html>