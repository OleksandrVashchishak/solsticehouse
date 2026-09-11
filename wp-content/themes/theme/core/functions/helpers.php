<?php


function my_browser_body_class($classes)
{
    global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone, $is_edge;
    if ($is_lynx)
        $classes[] = 'lynx';
    elseif ($is_edge)
        $classes[] = 'edge';
    elseif ($is_gecko)
        $classes[] = 'gecko';
    elseif ($is_opera)
        $classes[] = 'opera';
    elseif ($is_NS4)
        $classes[] = 'ns4';
    elseif ($is_safari)
        $classes[] = 'safari';
    elseif ($is_chrome)
        $classes[] = 'chrome';
    elseif ($is_IE) {
        $classes[] = 'ie';
        if (preg_match('/MSIE ([0-9]+)([a-zA-Z0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $browser_version))
            $classes[] = 'ie' . $browser_version[1];
    } else
        $classes[] = 'unknown';
    if ($is_iphone)
        $classes[] = 'iphone';
    if (stristr($_SERVER['HTTP_USER_AGENT'], "mac")) {
        $classes[] = 'osx';
    } elseif (stristr($_SERVER['HTTP_USER_AGENT'], "linux")) {
        $classes[] = 'linux';
    } elseif (stristr($_SERVER['HTTP_USER_AGENT'], "windows")) {
        $classes[] = 'windows';
    }
    return $classes;
}

add_filter('body_class', 'my_browser_body_class');


function remove_weird_characters($content)
{
    $content = preg_replace('/\x03/', '', $content);
    return $content;
}

add_filter('the_content', 'remove_weird_characters');
add_filter('the_title', 'remove_weird_characters');


function acf_remove_weird_characters($value, $post_id = 0, $field = array())
{
    if (isset($field['type']) && ($field['type'] == 'repeater' || $field['type'] == 'flexible_content')) {
        // abort if it's a repeater
        return $value;
    }
    if (!is_array($value)) {
        $value = preg_replace('/\x03/', '', $value);
        return $value;
    }
    $return = array();
    foreach ($value as $index => $data) {
        $return[$index] = acf_remove_weird_characters($data);
    }
    return $return;
}

add_filter('acf/update_value', 'acf_remove_weird_characters', 10, 3);

function get_total_from_repeater_field($repeater, $repeater_field, $post_id)
{
    $arr_helper = array();

    while (have_rows($repeater, $post_id)) :
        the_row();

        if (get_sub_field($repeater_field)) {
            $arr_helper[] = get_sub_field($repeater_field);
        }

    endwhile;

    return array_sum($arr_helper);
}

function get_lowest_value_from_repeater_field($repeater, $repeater_field, $post_id)
{
    $arr_helper = array();

    while (have_rows($repeater, $post_id)) :
        the_row();
        if (get_sub_field($repeater_field)) {
            $arr_helper[] = get_sub_field($repeater_field);
        }

    endwhile;

    return min($arr_helper);
}

function get_highest_value_from_repeater_field($repeater, $repeater_field, $post_id)
{
    $arr_helper = array();

    while (have_rows($repeater, $post_id)) :
        the_row();
        if (get_sub_field($repeater_field)) {
            $arr_helper[] = get_sub_field($repeater_field);
        }

    endwhile;

    return max($arr_helper);
}
//acf local sync field
add_filter('acf/settings/save_json', 'my_acf_json_save_point');

function my_acf_json_save_point($path)
{
    $path = get_stylesheet_directory() . '/acf-json';
    return $path;
}

add_filter('acf/settings/load_json', 'my_acf_json_load_point');

function my_acf_json_load_point($paths)
{
    unset($paths[0]);
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
}

add_action('after_setup_theme', 'theme_register_thumbnails');
function theme_register_thumbnails()
{
    add_theme_support('post-thumbnails', array('communities', 'page', 'post', 'villas'));
}

function get_formated_range($startDate, $endDate)
{
    $start = new DateTime($startDate);
    $end = new DateTime($endDate);

    $monthNamesUkrainian = [
        'January' => 'січня',
        'February' => 'лютого',
        'March' => 'березня',
        'April' => 'квітня',
        'May' => 'травня',
        'June' => 'червня',
        'July' => 'липня',
        'August' => 'серпня',
        'September' => 'вересня',
        'October' => 'жовтня',
        'November' => 'листопада',
        'December' => 'грудня'
    ];

    $monthNamesRussian = [
        'January' => 'января',
        'February' => 'февраля',
        'March' => 'марта',
        'April' => 'апреля',
        'May' => 'мая',
        'June' => 'июня',
        'July' => 'июля',
        'August' => 'августа',
        'September' => 'сентября',
        'October' => 'октября',
        'November' => 'ноября',
        'December' => 'декабря'
    ];

    $locale = get_locale();

    $monthNames = ($locale === 'ru_RU') ? $monthNamesRussian : $monthNamesUkrainian;

    $formattedStart = $start->format('j') . ' ' . $monthNames[$start->format('F')];
    $formattedEnd = $end->format('j') . ' ' . $monthNames[$end->format('F')];

    return $locale === 'ru_RU' ? "$formattedStart – $formattedEnd" : "$formattedStart – $formattedEnd";
}

function get_day_range($startDate, $endDate)
{
    $start = new DateTime($startDate);
    $end = new DateTime($endDate);
    $interval = $start->diff($end);
    $days = $interval->days + 1;

    return get_locale() === 'ru_RU' ? " ($days дней)" : " ($days днів)";
}

function get_formated_start($startDate)
{
    $start = new DateTime($startDate);

    $monthNamesUkrainian = [
        'January' => 'січня',
        'February' => 'лютого',
        'March' => 'березня',
        'April' => 'квітня',
        'May' => 'травня',
        'June' => 'червня',
        'July' => 'липня',
        'August' => 'серпня',
        'September' => 'вересня',
        'October' => 'жовтня',
        'November' => 'листопада',
        'December' => 'грудня'
    ];

    $monthNamesRussian = [
        'January' => 'января',
        'February' => 'февраля',
        'March' => 'марта',
        'April' => 'апреля',
        'May' => 'мая',
        'June' => 'июня',
        'July' => 'июля',
        'August' => 'августа',
        'September' => 'сентября',
        'October' => 'октября',
        'November' => 'ноября',
        'December' => 'декабря'
    ];

    $locale = get_locale();
    $monthNames = ($locale === 'ru_RU') ? $monthNamesRussian : $monthNamesUkrainian;

    $formattedStart = $start->format('j') . ' ' . $monthNames[$start->format('F')];
    $result = $locale === 'ru_RU' ? $formattedStart : $formattedStart;

    return $result;
}
