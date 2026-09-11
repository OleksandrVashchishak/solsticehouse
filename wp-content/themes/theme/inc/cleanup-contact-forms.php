<?php
/**
 * Cleanup CF7 junk + re-save working forms.
 * Run: php inc/cleanup-contact-forms.php
 */

require dirname(__DIR__, 4) . '/wp-load.php';

$pdfForm = trim(file_get_contents(__DIR__ . '/contact-form-pdf.txt'));
$touchForm = trim(file_get_contents(__DIR__ . '/contact-form-figma.txt'));

$keepIds = [];

// PDF form (id 7)
$pdfId = 7;
$pdf = wpcf7_contact_form($pdfId);
if ($pdf) {
    $props = $pdf->get_properties();
    $props['form'] = $pdfForm;
    $pdf->set_properties($props);
    $pdf->save();
    $keepIds[] = $pdfId;
    echo "PDF form OK (#{$pdfId})\n";
}

// Get in touch form
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
        $mail['body'] = "From: [your-name];\nEmail: [your-email];\nTel: [your-phone];\nMessage: [your-message];\n\n-- \nContact form submission on ([_site_title] [_site_url]).";
        update_post_meta($touchId, '_mail', $mail);
    }
    update_post_meta($touchId, '_mail_2', get_post_meta($pdfId, '_mail_2', true));
    update_post_meta($touchId, '_messages', get_post_meta($pdfId, '_messages', true));
    update_post_meta($touchId, '_locale', 'en_US');
} else {
    $touchId = (int) $touchPost->ID;
}

$touch = wpcf7_contact_form($touchId);
if ($touch) {
    $props = $touch->get_properties();
    $props['form'] = $touchForm;
    $touch->set_properties($props);
    $touch->save();
    $keepIds[] = $touchId;
    echo "Get in touch OK (#{$touchId})\n";
}

update_field('form_c', '[contact-form-7 id="' . $touchId . '" title="Contact form get in touch"]', 'option');
update_field('form_c_second', '[contact-form-7 id="' . $pdfId . '" title="Contact form_pdf"]', 'option');

// Delete junk Untitled CF7 forms
$junk = get_posts([
    'post_type' => 'wpcf7_contact_form',
    'post_status' => 'any',
    'numberposts' => -1,
    'exclude' => $keepIds,
]);

$deleted = 0;
foreach ($junk as $post) {
    wp_delete_post($post->ID, true);
    $deleted++;
    echo "Deleted #{$post->ID} {$post->post_title}\n";
}

echo "Deleted {$deleted} junk forms\n";
echo "Remaining: " . implode(', ', $keepIds) . "\n";

// Verify textarea parses
$contact = wpcf7_contact_form($touchId);
$formHtml = $contact ? $contact->replace_all_form_tags() : '';
if (strpos($formHtml, '<textarea') !== false) {
    echo "Textarea renders OK\n";
} else {
    echo "WARNING: textarea still broken\n";
    echo substr($formHtml, 0, 500) . "\n";
}
