UPDATE wp_options SET option_value = 'Get in touch' WHERE option_name = 'options_title_c';
UPDATE wp_options SET option_value = 'Reach out to us and we''ll get back to you shortly.' WHERE option_name = 'options_subtitle_c';
UPDATE wp_postmeta SET meta_value = '<div class="popup__contact-fields-row">
<p class="popup__contact-field"><span class="popup__contact-field-head"><span class="popup__contact-field-label">Name</span><span class="popup__contact-field-hint">Your name</span></span>[text* your-name class:popup__contact-input autocomplete:name]</p>
<p class="popup__contact-field"><span class="popup__contact-field-head"><span class="popup__contact-field-label">Email</span><span class="popup__contact-field-hint">you@email.com</span></span>[email* your-email class:popup__contact-input autocomplete:email]</p>
<p class="popup__contact-field"><span class="popup__contact-field-head"><span class="popup__contact-field-label">Phone</span><span class="popup__contact-field-hint">(000) 000-0000</span></span>[tel your-phone class:popup__contact-input autocomplete:tel]</p>
</div>
<p class="popup__contact-field popup__contact-field--message"><span class="popup__contact-field-head"><span class="popup__contact-field-label">Message</span><span class="popup__contact-field-hint">Write your message</span></span>[textarea your-message class:popup__contact-input]</p>
<div class="popup__contact-footer">
<div class="popup__contact-consent">
<p class="agree">[acceptance agree use_label_element] I agree to be contacted by Residence Collective via call, email, and text.</p>
<p class="privacy">*By providing your email address, you agree to our privacy policy.</p>
</div>
<p class="popup__contact-submit">[submit "Submit"]</p>
</div>
' WHERE post_id = 7 AND meta_key = '_form';
UPDATE wp_posts SET post_content = '<div class="popup__contact-fields-row">
<p class="popup__contact-field"><span class="popup__contact-field-head"><span class="popup__contact-field-label">Name</span><span class="popup__contact-field-hint">Your name</span></span>[text* your-name class:popup__contact-input autocomplete:name]</p>
<p class="popup__contact-field"><span class="popup__contact-field-head"><span class="popup__contact-field-label">Email</span><span class="popup__contact-field-hint">you@email.com</span></span>[email* your-email class:popup__contact-input autocomplete:email]</p>
<p class="popup__contact-field"><span class="popup__contact-field-head"><span class="popup__contact-field-label">Phone</span><span class="popup__contact-field-hint">(000) 000-0000</span></span>[tel your-phone class:popup__contact-input autocomplete:tel]</p>
</div>
<p class="popup__contact-field popup__contact-field--message"><span class="popup__contact-field-head"><span class="popup__contact-field-label">Message</span><span class="popup__contact-field-hint">Write your message</span></span>[textarea your-message class:popup__contact-input]</p>
<div class="popup__contact-footer">
<div class="popup__contact-consent">
<p class="agree">[acceptance agree use_label_element] I agree to be contacted by Residence Collective via call, email, and text.</p>
<p class="privacy">*By providing your email address, you agree to our privacy policy.</p>
</div>
<p class="popup__contact-submit">[submit "Submit"]</p>
</div>
' WHERE ID = 7;
