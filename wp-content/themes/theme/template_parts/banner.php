<?php
if (!isset($_GET['masterplan'])):
    $logo = get_sub_field('logo');
    $button = get_sub_field('button');
    $video = get_sub_field('video');
    $need_video = get_sub_field('need_video');
    $image = get_sub_field('image');
    ?>
    <section class="banner <?php echo $need_video ? 'need_video' : '' ?>">
        <?php if ($video && $need_video) { ?>
            <video src="<?php echo $video ?>" class="banner__video" autoplay muted playsinline loop></video>
        <?php } ?>
        <?php if ($image) { ?>
            <img src="<?php echo $image; ?>" class="banner__image" alt="logo">
        <?php } ?>
        <div class="banner__container">
            <div class="banner__wrapper">
                    <?php if ($logo) { ?>
                        <img src="<?php echo $logo; ?>" class="banner__logo" alt="logo">
                    <?php } ?>
                <?php if ($button) { ?>
                    <a href="#" class="banner__button"><?php echo $button ?></a>
                <?php } ?>
            </div>
        </div>
    </section>
<?php endif; ?>