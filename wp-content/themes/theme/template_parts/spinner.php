<?php $url = get_sub_field('url'); ?>
<section class="spinner">
    <?php if ($url) { ?>
        <iframe src="<?php echo $url ?>" frameborder="0" width="100%" height="100%"></iframe>
    <?php } ?>
</section>