<?php
function best_shop_woocommerce_support()
{
    add_theme_support('woocommerce');
    load_theme_textdomain('bluenest', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'best_shop_woocommerce_support');

add_image_size('full_hd', 1920, 1080);
add_image_size('gallery_1440', 1440, 9999, false);

/**
 * Best image URL for popups: prefer width ≤ $max_width to avoid loading originals.
 */
function theme_popup_image_src($image, $max_width = 1440)
{
    if (empty($image)) {
        return '';
    }

    $id = 0;
    if (is_numeric($image)) {
        $id = (int) $image;
    } elseif (is_array($image)) {
        $id = (int) ($image['ID'] ?? $image['id'] ?? 0);
    }

    if ($id) {
        $meta = wp_get_attachment_metadata($id);
        $candidates = [];

        if (!empty($meta['sizes']) && is_array($meta['sizes'])) {
            foreach ($meta['sizes'] as $size_name => $data) {
                $w = (int) ($data['width'] ?? 0);
                if ($w <= 0) {
                    continue;
                }
                $url = wp_get_attachment_image_url($id, $size_name);
                if ($url) {
                    $candidates[$w] = $url;
                }
            }
        }

        if ($candidates) {
            ksort($candidates, SORT_NUMERIC);
            $best = '';
            foreach ($candidates as $w => $url) {
                if ($w <= $max_width) {
                    $best = $url;
                }
            }
            if ($best) {
                return $best;
            }
            return reset($candidates);
        }

        $sized = wp_get_attachment_image_url($id, 'gallery_1440');
        if ($sized) {
            return $sized;
        }
    }

    if (is_array($image)) {
        if (!empty($image['sizes']) && is_array($image['sizes'])) {
            $by_width = [];
            foreach ($image['sizes'] as $key => $val) {
                if (!is_string($val)) {
                    continue;
                }
                if (strpos($key, '-width') !== false || strpos($key, '-height') !== false) {
                    continue;
                }
                if (strpos($val, 'http') !== 0) {
                    continue;
                }
                $w = (int) ($image['sizes'][$key . '-width'] ?? 0);
                if ($w > 0) {
                    $by_width[$w] = $val;
                }
            }
            if ($by_width) {
                ksort($by_width, SORT_NUMERIC);
                $best = '';
                foreach ($by_width as $w => $url) {
                    if ($w <= $max_width) {
                        $best = $url;
                    }
                }
                if ($best) {
                    return $best;
                }
                return reset($by_width);
            }
            if (!empty($image['sizes']['large'])) {
                return $image['sizes']['large'];
            }
        }
        return $image['url'] ?? '';
    }

    return '';
}

add_action('wp_enqueue_scripts', function () {
    if (is_admin())
        return; // don't dequeue on the backend
    wp_deregister_script('jquery');
    wp_register_script('jquery', get_stylesheet_directory_uri() . '/src/js/vendor/jquery.min.js', array(), null, false);
    wp_enqueue_script('jquery');
});

add_filter('script_loader_tag', 'add_async_defer_to_google_maps', 10, 3);
function add_async_defer_to_google_maps($tag, $handle, $src)
{
    if ($handle === 'google-maps') {
        return '<script src="' . esc_url($src) . '" async defer></script>';
    }
    return $tag;
}


function global_scripts()
{
    wp_enqueue_style('main-style', get_stylesheet_directory_uri() . '/build/main.css', array(), filemtime(get_stylesheet_directory() . '/build/main.css'));
    wp_enqueue_style('theme-style', get_stylesheet_uri(), array('main-style'), filemtime(get_stylesheet_directory() . '/style.css'));
    wp_enqueue_script('bundle', get_template_directory_uri() . '/build/bundle.js', array('jquery'));
    wp_localize_script(
        'bundle',
        'myajax',
        array(
            'url' => admin_url('admin-ajax.php'),
        )
    );
}

add_action('wp_enqueue_scripts', 'global_scripts');


function remove_head_scripts()
{
    remove_action('wp_head', 'wp_print_scripts');
    remove_action('wp_head', 'wp_print_head_scripts', 9);
    remove_action('wp_head', 'wp_enqueue_scripts', 1);
    remove_action('wp_head', 'wp_print_styles', 99);
    remove_action('wp_head', 'wp_enqueue_style', 99);


    add_action('wp_footer', 'wp_print_scripts', 5);
    add_action('wp_footer', 'wp_enqueue_scripts', 5);
    add_action('wp_footer', 'wp_print_head_scripts', 5);
    add_action('wp_head', 'wp_print_styles', 30);
    add_action('wp_head', 'wp_enqueue_style', 30);
}

add_action('wp_enqueue_scripts', 'remove_head_scripts');


show_admin_bar(false);


add_theme_support('menus');

// SVG support
function cc_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');


// ACF Options page
if (function_exists('acf_add_options_page')) {
    acf_add_options_page();
}

/**
 * Ensure Header menu has Gallery / Floorplan items for popup modals.
 */
add_filter('wp_nav_menu_items', function ($items, $args) {
    $is_header = false;
    if (!empty($args->menu) && (string) $args->menu === 'Header') {
        $is_header = true;
    }
    if (!empty($args->menu_class) && strpos($args->menu_class, 'header__popup-menu') !== false) {
        $is_header = true;
    }
    if (!$is_header) {
        return $items;
    }

    $extras = [
        [
            'id' => function_exists('get_field') ? (get_field('id_g', 'options') ?: 'gallery') : 'gallery',
            'label' => 'Gallery',
            'class' => 'menu-item-gallery',
        ],
        [
            'id' => function_exists('get_field') ? (get_field('id_fp', 'options') ?: 'floorplan') : 'floorplan',
            'label' => 'Floorplan',
            'class' => 'menu-item-floorplan',
        ],
    ];

    foreach ($extras as $extra) {
        $hash = '#' . ltrim($extra['id'], '#');
        $label = $extra['label'];
        if (strpos($items, $hash) !== false || stripos($items, '>' . $label . '<') !== false) {
            continue;
        }
        $items .= '<li class="menu-item menu-item-type-custom menu-item-object-custom ' . esc_attr($extra['class']) . '">'
            . '<a href="' . esc_attr($hash) . '">' . esc_html($label) . '</a>'
            . '</li>';
    }

    return $items;
}, 20, 2);


function remove_menus()
{
    remove_menu_page('edit-comments.php'); //Comments

}
add_action('admin_menu', 'remove_menus');


add_action('after_setup_theme', 'wpse_theme_setup');
function wpse_theme_setup()
{
    add_theme_support('title-tag');
}

require_once(__DIR__ . '/core/core.php');

