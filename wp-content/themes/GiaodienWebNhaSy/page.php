<?php get_header(); ?>

<?php get_template_part('partials/header', 'img'); ?>



<section class="page-contact main-content">

    <div class="container display-grid">

        <article class="col-md-8" id="content">

            <?php if (have_posts()) : ?>

                <?php while (have_posts()) : the_post(); ?>
                    <div class="mbreadcrum-row">
                        <?php
                        m_breadcrumb_page()
                        ?>
                    </div>
                    <?php
                    global $post;
                    if ($post->post_content != null) :
                        the_content();
                    ?>
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
                    <?php
                    else :
                        the_content();
                    endif;
                    ?>

                <?php endwhile; ?>

            <?php endif; ?>

        </article>



        <?php get_sidebar();  ?>



    </div>

</section>



<?php get_footer(); ?>