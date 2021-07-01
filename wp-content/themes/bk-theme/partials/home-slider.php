<div class="slider-homepage" id="slider-homepage">
    <?php
    $rows = get_field('slider');
    if ($rows) : foreach ($rows as $row) :
            $image = $row['image'];
            $description = $row['description'];
            $url = $row['url'];
            $originalSliderImageID = 23;
            ?>
            <div class="slider-item-wrap">
                <a href="<?php echo $url ?>" class="wrap-slider-homepage">
                    <?php echo wp_get_attachment_image($image, '2048x2048'); ?>
                </a>
                <div class="wow animate__animated animate__fadeInLeft animate__delay-1s">
                    <?php echo wpautop($row['description']); ?>
                </div>
            </div>
        <?php endforeach;
        else : ?>
        <div class="slider-item-wrap">
            <a href="#"><?php echo wp_get_attachment_image($originalSliderImageID, '2048x2048'); ?></a>
            <div class="wow animate__animated animate__fadeInLeft animate__delay-1s">
                <span>We are</span>
                <span>changing life</span>
                <span>The team at Nha Viet Dental is passionate about changing lives through restoring oral health
                    and creating stunning natural smiles.</span>
            </div>
        </div>
    <?php endif; ?>

</div>