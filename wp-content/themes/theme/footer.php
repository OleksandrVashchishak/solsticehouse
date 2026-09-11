</div>

<?php $lofo_phrase = get_field('lofo_phrase', 'options') ?>
<?php $privacy = get_field('privacy', 'options') ?>
<?php $terms = get_field('terms', 'options') ?>
<?php $copyright = get_field('copyright', 'options') ?>
<footer class="footer">
    <div class="footer__container container">
        <div class="footer__wrapper">
            <div class="footer__main">
                <div class="footer__info">
                    <?php if (get_field('logo_footer', 'options')) { ?>
                        <a class="footer__logo" href="<?php echo home_url() ?>">
                            <img src="<?php echo wp_get_attachment_image_url(get_field('logo_footer', 'options'), 'full_hd'); ?>"
                                alt="logo">
                        </a>
                    <?php } ?>
                    <?php if ($lofo_phrase) { ?>
                        <p class="footer__phrase"><?php echo $lofo_phrase ?></p>
                    <?php } ?>
                </div>
                <div class="footer__menus">
                    <?php
                    wp_nav_menu(
                        array(
                            'menu' => 'Footer 1',
                            'container' => '',
                            'menu_class' => 'footer__menu'
                        )
                    ); ?>

                </div>
            </div>
            <?php if (get_field('social', 'options')) { ?>
                <div class="footer__socials">
                    <?php while (have_rows('social', 'options')):
                        the_row(); ?>
                        <a href="<?php the_sub_field('url') ?>"><img src="<?php the_sub_field('icon') ?>" alt="icon"></a>
                    <?php endwhile; ?>
                </div>
            <?php } ?>
            <div class="footer__bottom">
                <div class="footer__copy"><?php echo $copyright ?></div>
                <div class="footer__links">
                    <?php if ($privacy) { ?>
                        <a href="<?php echo $privacy['url'] ?>"><?php echo $privacy['title'] ?></a>
                    <?php } ?>
                    <?php if ($terms) { ?>
                        <a href="<?php echo $terms['url'] ?>"><?php echo $terms['title'] ?></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</footer>


<!-- ////////////////////////////// -->

<?php $explore = get_field('explore', 'options') ?>
<?php $price_and_plan = get_field('price_and_plan', 'options') ?>
  <?php $contact = get_field('contact', 'options') ?>

<div class="footer__buttons">
    <a href="<?php echo $contact['url'] ?>" class="header__contact"><?php echo $contact['title'] ?></a>
    <a href="<?php echo $price_and_plan['url'] ?>" class="footer__price footer__btn">
        <?php echo $price_and_plan['title'] ?>
    </a>
    <a href="<?php echo $explore['url'] ?>" class="footer__explore footer__btn tours-link">
        <?php echo $explore['title'] ?>
    </a>
</div>

<?php $title_c = get_field('title_c', 'options') ?: 'Get in touch'; ?>
<?php $subtitle_c = get_field('subtitle_c', 'options') ?: 'Reach out to us and we\'ll get back to you shortly.'; ?>
<?php $form_c = get_field('form_c', 'options') ?>
<?php $id_c = get_field('id_c', 'options') ?>
<?php $thanks_title = get_field('thanks_title', 'options') ?>
<?php $thanks_text = get_field('thanks_text', 'options') ?>
<?php
$contact_team = get_field('contact_team', 'options');
if (!$contact_team) {
    $contact_team = [
        [
            'photo' => get_template_directory_uri() . '/images/contact/charles-yin.png',
            'name' => 'Charles Yin',
            'phone' => '212-518-6649',
            'email' => 'charlie@residence-collective.com',
        ],
        [
            'photo' => get_template_directory_uri() . '/images/contact/lisa-goldman.png',
            'name' => 'Lisa Goldman',
            'phone' => '480-980-9850',
            'email' => 'lisa@residence-collective.com',
        ],
    ];
}
?>

<div class="popup__contact" id="<?php echo $id_c ?>">
    <div class="popup__contact-wrapper">
        <button type="button" class="popup__contact-close">close</button>

        <div class="popup__contact-head">
            <?php if ($title_c) { ?>
                <h3 class="popup__contact-title"><?php echo esc_html($title_c); ?></h3>
            <?php } ?>
            <?php if ($subtitle_c) { ?>
                <p class="popup__contact-subtitle"><?php echo esc_html($subtitle_c); ?></p>
            <?php } ?>
        </div>

        <?php if ($contact_team) { ?>
            <div class="popup__contact-team">
                <?php foreach ($contact_team as $person) {
                    $photo = is_array($person['photo'] ?? null)
                        ? ($person['photo']['url'] ?? '')
                        : ($person['photo'] ?? '');
                    ?>
                    <div class="popup__contact-person">
                        <?php if ($photo) { ?>
                            <img class="popup__contact-photo" src="<?php echo esc_url($photo); ?>" alt="<?php echo esc_attr($person['name'] ?? ''); ?>">
                        <?php } ?>
                        <div class="popup__contact-person-info">
                            <?php if (!empty($person['name'])) { ?>
                                <p class="popup__contact-person-name"><?php echo esc_html($person['name']); ?></p>
                            <?php } ?>
                            <?php if (!empty($person['phone'])) { ?>
                                <p class="popup__contact-person-phone"><?php echo esc_html($person['phone']); ?></p>
                            <?php } ?>
                            <?php if (!empty($person['email'])) { ?>
                                <p class="popup__contact-person-email"><?php echo esc_html($person['email']); ?></p>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>

        <div class="popup__contact-form-section">
            <p class="popup__contact-form-label">Send a message</p>
            <?php if ($form_c) { ?>
                <div class="popup__contact-form">
                    <?php echo do_shortcode($form_c); ?>
                </div>
            <?php } ?>
        </div>

        <div class="popup__thanks">
            <?php if ($thanks_title) { ?>
                <h3 class="title"><?php echo $thanks_title ?></h3>
            <?php } ?>
            <?php if ($thanks_text) { ?>
                <div class="text"><?php echo $thanks_text ?></div>
            <?php } ?>
        </div>
    </div>
</div>

<?php $title_c_second = get_field('title_c_second', 'options') ?>
<?php $subtitle_c_second = get_field('subtitle_c_second', 'options') ?>
<?php $form_c_second = get_field('form_c_second', 'options') ?>
<?php $id_c_second = get_field('id_c_second', 'options') ?>
<?php $thanks_text_second = get_field('thanks_text_second ', 'options') ?>
<div class="popup__contact second" id="<?php echo $id_c_second ?>">
    <div class="popup__contact-wrapper">
        <div class="popup__contact-close">Close</div>
        <div class="popup__contact-inner">
            <?php if ($title_c_second) { ?>
                <h3 class="popup__contact-title"><?php echo $title_c_second ?></h3>
            <?php } ?>
            <div class="popup__contact-main">
                <?php if ($subtitle_c_second) { ?>
                    <div class="popup__contact-subtitle">
                        <?php echo $subtitle_c_second ?>
                    </div>
                <?php } ?>
                <?php if ($form_c_second) { ?>
                    <div class="popup__contact-form">
                        <?php echo do_shortcode($form_c_second); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="popup__thanks">
            <?php if ($thanks_title) { ?>
                <h3 class="title"><?php echo $thanks_title ?></h3>
            <?php } ?>
            <?php if ($thanks_text_second) { ?>
                <div class="text"><?php echo $thanks_text_second ?></div>
            <?php } ?>
        </div>
    </div>
</div>

<?php $video = get_field('video', 'options') ?>
<?php $prev = get_field('prev', 'options') ?>
<?php $id_v = get_field('id_v', 'options') ?>

<div class="popup__simple video" id="<?php echo $id_v ?>">
    <div class="popup__simple-wrapper">
        <div class="popup__simple-close"></div>
        <?php if ($video) { ?>
            <video src="<?php echo $video ?>" class="popup__simple-video"></video>
            <div class="popup__simple-play"></div>
        <?php } ?>
        <?php if ($prev) { ?>
            <img src="<?php echo $prev; ?>" class="popup__simple-prev" alt="prev image">
        <?php } ?>
    </div>
</div>

<?php $pdf = get_field('pdf', 'options') ?>
<?php $id_p = get_field('id_p', 'options') ?>

<div class="popup__simple pdf" id="<?php echo $id_p ?>">
    <div class="popup__simple-wrapper">
        <div class="popup__simple-close"></div>
        <?php if ($pdf): ?>
            <iframe src="<?php echo $pdf ?>" class="popup__simple-pdf" width="100%" height="100%" style="border:none;"
                loading="lazy"></iframe>
        <?php endif; ?>
    </div>
</div>

<?php $map = get_field('map', 'options') ?>
<?php $id_m = get_field('id_m', 'options') ?>

<div class="popup__simple map" id="<?php echo $id_m ?>">
    <div class="popup__simple-wrapper">
        <div class="popup__simple-close"></div>
        <?php if ($map): ?>
            <?php echo $map ?>
        <?php endif; ?>
    </div>
</div>


<?php $tour = get_field('tour', 'options') ?>
<?php $id_tour = get_field('id_tour', 'options') ?>
<div class="popup__simple tour" id="<?php echo $id_tour ?>">
    <div class="popup__simple-wrapper">
        <div class="popup__simple-close"></div>
        <?php if ($tour): ?>
            <iframe src="" data-url="<?php echo $tour ?>" class="popup__simple-pdf popup__simple-tour" width="100%"
                height="100%" style="border:none;" loading="lazy"></iframe>
        <?php endif; ?>
    </div>
</div>

<?php
$gallery = get_field('gallery', 'options');
$id_g = get_field('id_g', 'options') ?: 'gallery';
$gallery_first_src = !empty($gallery[0]) ? theme_popup_image_src($gallery[0], 1440) : '';
?>
<div class="popup__simple gallery" id="<?php echo esc_attr($id_g); ?>">
    <div class="popup__simple-wrapper popup__gallery">
        <button type="button" class="popup__simple-close" aria-label="Close"></button>
        <?php if (!empty($gallery) && $gallery_first_src) : ?>
            <button type="button" class="popup__gallery-nav popup__gallery-prev" aria-label="Previous image"></button>
            <button type="button" class="popup__gallery-nav popup__gallery-next" aria-label="Next image"></button>

            <div class="popup__gallery-stage">
                <img
                    class="popup__gallery-img"
                    src="<?php echo esc_url($gallery_first_src); ?>"
                    alt="<?php echo esc_attr($gallery[0]['alt'] ?: $gallery[0]['title'] ?: ''); ?>"
                    data-index="0"
                    width="1440"
                >
            </div>

            <div class="popup__gallery-meta">
                <span class="popup__gallery-counter">
                    <span class="popup__gallery-current">1</span> / <?php echo count($gallery); ?>
                </span>
            </div>

            <div class="popup__gallery-thumbs" role="list">
                <?php foreach ($gallery as $i => $img) :
                    $thumb = !empty($img['sizes']['medium']) ? $img['sizes']['medium'] : $img['url'];
                    $src = theme_popup_image_src($img, 1440);
                    $alt = $img['alt'] ?: ($img['title'] ?: '');
                    ?>
                    <button
                        type="button"
                        class="popup__gallery-thumb<?php echo $i === 0 ? ' is-active' : ''; ?>"
                        data-index="<?php echo (int) $i; ?>"
                        data-full="<?php echo esc_url($src); ?>"
                        data-alt="<?php echo esc_attr($alt); ?>"
                        aria-label="<?php echo esc_attr($alt ?: ('Image ' . ($i + 1))); ?>"
                    >
                        <img src="<?php echo esc_url($thumb); ?>" alt="" loading="lazy">
                    </button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
$floorplan = get_field('floorplan', 'options');
$id_fp = get_field('id_fp', 'options') ?: 'floorplan';
$floorplan_first_src = !empty($floorplan[0]) ? theme_popup_image_src($floorplan[0], 1440) : '';
?>
<div class="popup__simple floorplan" id="<?php echo esc_attr($id_fp); ?>">
    <div class="popup__simple-wrapper popup__gallery">
        <button type="button" class="popup__simple-close" aria-label="Close"></button>
        <?php if (!empty($floorplan) && $floorplan_first_src) : ?>
            <button type="button" class="popup__gallery-nav popup__gallery-prev" aria-label="Previous image"></button>
            <button type="button" class="popup__gallery-nav popup__gallery-next" aria-label="Next image"></button>

            <div class="popup__gallery-stage">
                <img
                    class="popup__gallery-img"
                    src="<?php echo esc_url($floorplan_first_src); ?>"
                    alt="<?php echo esc_attr($floorplan[0]['alt'] ?: ($floorplan[0]['title'] ?: 'Floorplan')); ?>"
                    data-index="0"
                    width="1440"
                >
            </div>

            <div class="popup__gallery-meta">
                <span class="popup__gallery-counter">
                    <span class="popup__gallery-current">1</span> / <?php echo count($floorplan); ?>
                </span>
            </div>

            <div class="popup__gallery-thumbs" role="list">
                <?php foreach ($floorplan as $i => $img) :
                    $thumb = !empty($img['sizes']['medium']) ? $img['sizes']['medium'] : $img['url'];
                    $src = theme_popup_image_src($img, 1440);
                    $alt = $img['alt'] ?: ($img['title'] ?: 'Floorplan');
                    ?>
                    <button
                        type="button"
                        class="popup__gallery-thumb<?php echo $i === 0 ? ' is-active' : ''; ?>"
                        data-index="<?php echo (int) $i; ?>"
                        data-full="<?php echo esc_url($src); ?>"
                        data-alt="<?php echo esc_attr($alt); ?>"
                        aria-label="<?php echo esc_attr($alt ?: ('Floorplan ' . ($i + 1))); ?>"
                    >
                        <img src="<?php echo esc_url($thumb); ?>" alt="" loading="lazy">
                    </button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

</div>

<?php wp_footer(); ?>

</body>

</html>