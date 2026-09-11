UPDATE wp_postmeta SET meta_value = '<div class="popup__contact-fields-row">
<p class="popup__contact-field"><span class="popup__contact-field-label">Name</span>[text* your-name class:popup__contact-input placeholder "Your name" autocomplete:name]</p>
<p class="popup__contact-field"><span class="popup__contact-field-label">Email</span>[email* your-email class:popup__contact-input placeholder "you@email.com" autocomplete:email]</p>
<p class="popup__contact-field"><span class="popup__contact-field-label">Phone</span>[tel your-phone class:popup__contact-input placeholder "(000) 000-0000" autocomplete:tel]</p>
</div>
<p class="popup__contact-field popup__contact-field--message"><span class="popup__contact-field-label">Message</span>[textarea your-message class:popup__contact-input placeholder "Write your message" rows:1]</p>
<div class="popup__contact-footer">
<div class="popup__contact-consent">
<span class="popup__contact-consent-check">[acceptance agree]</span>
<div class="popup__contact-consent-copy">
<p class="popup__contact-consent-main">I agree to be contacted by Residence Collective via call, email, and text.</p>
<p class="privacy">*By providing your email address, you agree to our privacy policy.</p>
</div>
</div>
<p class="popup__contact-submit">[submit "Submit"]</p>
</div>
' WHERE post_id = 62 AND meta_key = '_form';
