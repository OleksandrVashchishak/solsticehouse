<?php
/**
 * One-time split: restore PDF form (id 7) and create Get in touch CF7 form.
 * Run: php inc/setup-contact-forms.php
 */

$wpLoad = dirname(__DIR__, 4) . '/wp-load.php';
if (!file_exists($wpLoad)) {
    fwrite(STDERR, "wp-load.php not found\n");
    exit(1);
}

require $wpLoad;

$pdfForm = file_get_contents(__DIR__ . '/contact-form-pdf.txt');
$touchForm = file_get_contents(__DIR__ . '/contact-form-figma.txt');

if (!$pdfForm || !$touchForm) {
    fwrite(STDERR, "Form template files missing\n");
    exit(1);
}

$pdfId = 7;
update_post_meta($pdfId, '_form', trim($pdfForm));

$touchPost = get_page_by_title('Contact form get in touch', OBJECT, 'wpcf7_contact_form');
if (!$touchPost) {
    $touchId = wp_insert_post([
        'post_title' => 'Contact form get in touch',
        'post_name' => 'contact-form-get-in-touch',
        'post_type' => 'wpcf7_contact_form',
        'post_status' => 'publish',
    ], true);

    if (is_wp_error($touchId)) {
        fwrite(STDERR, $touchId->get_error_message() . "\n");
        exit(1);
    }

    $mail = get_post_meta($pdfId, '_mail', true);
    if (is_array($mail)) {
        $mail['body'] = "From: [your-name];\nEmail: [your-email];\nTel: [your-phone];\nMessage: [your-message];\n\n-- \nThis is a notification that a contact form was submitted on your website ([_site_title] [_site_url]).";
        update_post_meta($touchId, '_mail', $mail);
    }

    update_post_meta($touchId, '_mail_2', get_post_meta($pdfId, '_mail_2', true));
    update_post_meta($touchId, '_messages', get_post_meta($pdfId, '_messages', true));
    update_post_meta($touchId, '_locale', 'en_US');
} else {
    $touchId = $touchPost->ID;
}

update_post_meta($touchId, '_form', trim($touchForm));

if (function_exists('wpcf7_contact_form')) {
    $contact = wpcf7_contact_form($touchId);
    if ($contact) {
        $properties = $contact->get_properties();
        $properties['form'] = trim($touchForm);
        $contact->set_properties($properties);
        $contact->save();
    }

    $contactPdf = wpcf7_contact_form($pdfId);
    if ($contactPdf) {
        $properties = $contactPdf->get_properties();
        $properties['form'] = trim($pdfForm);
        $contactPdf->set_properties($properties);
        $contactPdf->save();
    }
}

$touchShortcode = '[contact-form-7 id="' . $touchId . '" title="Contact form get in touch"]';
update_field('form_c', $touchShortcode, 'option');

echo "PDF form restored on post {$pdfId}\n";
echo "Get in touch form on post {$touchId}\n";
echo "form_c => {$touchShortcode}\n";
