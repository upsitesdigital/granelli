<?php
/*
Plugin Name: Contact Form 7 Captcha Pro
Description: Add No CAPTCHA reCAPTCHA to Contact Form 7 using [cf7sr-simple-recaptcha] shortcode
Version: 0.0.1
Author: 247wd
*/

function cf7sr_pro_activation() {
    deactivate_plugins('contact-form-7-simple-recaptcha/contact-form-7-simple-recaptcha.php');
}
register_activation_hook(__FILE__, 'cf7sr_pro_activation');

$cf7sr_key = get_option('cf7sr_key');
$cf7sr_secret = get_option('cf7sr_secret');
if (!empty($cf7sr_key) && !empty($cf7sr_secret) && !is_admin()) {
    function enqueue_cf7sr_script_pro() {
        global $cf7sr;
        if (!$cf7sr) {
            return;
        }
        $languages = array(
            'ar' => 'Arabic', 'af' => 'Afrikaans', 'am' => 'Amharic', 'hy' => 'Armenian', 'az' => 'Azerbaijani',
            'eu' => 'Basque', 'bn' => 'Bengali', 'bg' => 'Bulgarian', 'ca' => 'Catalan', 'zh-HK' => 'Chinese (Hong Kong)',
            'zh-CN' => 'Chinese (Simplified)', 'zh-TW' => 'Chinese (Traditional)', 'hr' => 'Croatian', 'cs' => 'Czech',
            'da' => 'Danish', 'nl' => 'Dutch', 'en-GB' => 'English (UK)', 'en' => 'English (US)', 'et' => 'Estonian',
            'fil' => 'Filipino', 'fi' => 'Finnish', 'fr' => 'French', 'fr-CA' => 'French (Canadian)', 'gl' => 'Galician',
            'ka' => 'Georgian', 'de' => 'German', 'de-AT' => 'German (Austria)', 'de-CH' => 'German (Switzerland)',
            'el' => 'Greek', 'gu' => 'Gujarati', 'iw' => 'Hebrew', 'hi' => 'Hindi', 'hu' => 'Hungarain', 'is' => 'Icelandic',
            'id' => 'Indonesian', 'it' => 'Italian', 'ja' => 'Japanese', 'kn' => 'Kannada', 'ko' => 'Korean', 'lo' => 'Laothian',
            'lv' => 'Latvian', 'lt' => 'Lithuanian', 'ms' => 'Malay', 'ml' => 'Malayalam', 'mr' => 'Marathi', 'mn' => 'Mongolian',
            'no' => 'Norwegian', 'fa' => 'Persian', 'pl' => 'Polish', 'pt' => 'Portuguese', 'pt-BR' => 'Portuguese (Brazil)',
            'pt-PT' => 'Portuguese (Portugal)', 'ro' => 'Romanian', 'ru' => 'Russian', 'sr' => 'Serbian', 'si' => 'Sinhalese',
            'sk' => 'Slovak', 'sl' => 'Slovenian', 'es' => 'Spanish', 'es-419' => 'Spanish (Latin America)', 'sw' => 'Swahili',
            'sv' => 'Swedish', 'ta' => 'Tamil', 'te' => 'Telugu', 'th' => 'Thai', 'tr' => 'Turkish', 'uk' => 'Ukrainian',
            'ur' => 'Urdu', 'vi' => 'Vietnamese', 'zu' => 'Zulu'
        );
        $cf7sr_script_url = 'https://www.google.com/recaptcha/api.js?onload=cf7srLoadCallback&render=explicit';
        $language = get_option('cf7sr_language');
        if (in_array($language, array('Wpml', 'Polylang')) && defined('ICL_LANGUAGE_CODE')) {
            $language = ICL_LANGUAGE_CODE;
        } elseif('Polylang' == $language && function_exists('pll_current_language')) {
            $language = pll_current_language();
        }
        if (! empty($language) && ! empty($languages[$language])) {
            $cf7sr_script_url .= '&hl=' . $language;
        }
        $cf7sr_key = get_option('cf7sr_key');
        ?>
        <script type="text/javascript">
            var widgetIds = [];
            var cf7srLoadCallback = function() {
                var cf7srWidgets = document.querySelectorAll('.cf7sr-g-recaptcha');
                for (var i = 0; i < cf7srWidgets.length; ++i) {
                    var cf7srWidget = cf7srWidgets[i];
                    var widgetId = grecaptcha.render(cf7srWidget.id, {
                        'sitekey' : <?php echo wp_json_encode($cf7sr_key); ?>
                    });
                    widgetIds.push(widgetId);
                }
            };
            (function($) {
                $('.wpcf7').on('wpcf7invalid wpcf7mailsent invalid.wpcf7 mailsent.wpcf7', function() {
                    for (var i = 0; i < widgetIds.length; i++) {
                        grecaptcha.reset(widgetIds[i]);
                    }
                });
            })(jQuery);
        </script>
        <script src="<?php echo esc_url($cf7sr_script_url); ?>" async defer></script>
        <?php
    }
    add_action('wp_footer', 'enqueue_cf7sr_script_pro');

    function cf7sr_wpcf7_form_elements_pro($form) {
        $form = do_shortcode($form);
        return $form;
    }
    add_filter('wpcf7_form_elements', 'cf7sr_wpcf7_form_elements_pro');

    function cf7sr_shortcode_pro($atts) {
        global $cf7sr;
        $cf7sr = true;
        $cf7sr_key = get_option('cf7sr_key');
        $cf7sr_theme = ! empty($atts['theme']) && 'dark' == $atts['theme'] ? 'dark' : 'light';
        $cf7sr_type = ! empty($atts['type']) && 'audio' == $atts['type'] ? 'audio' : 'image';
        $cf7sr_size = ! empty($atts['size']) && 'compact' == $atts['size'] ? 'compact' : 'normal';
        return '<div id="cf7sr-' . uniqid() . '" class="cf7sr-g-recaptcha" data-theme="' . $cf7sr_theme . '" data-type="'
            . $cf7sr_type . '" data-size="' . $cf7sr_size . '" data-sitekey="' . $cf7sr_key
            . '"></div><span class="wpcf7-form-control-wrap cf7sr-recaptcha" data-name="cf7sr-recaptcha"><input type="hidden" name="cf7sr-recaptcha" value="" class="wpcf7-form-control"></span>';
    }
    add_shortcode('cf7sr-simple-recaptcha', 'cf7sr_shortcode_pro');

    function cf7sr_verify_recaptcha_pro($result) {
        if (! class_exists('WPCF7_Submission')) {
            return $result;
        }

        $_wpcf7 = ! empty($_POST['_wpcf7']) ? absint($_POST['_wpcf7']) : 0;
        if (empty($_wpcf7)) {
            return $result;
        }

        $submission = WPCF7_Submission::get_instance();
        $data = $submission->get_posted_data();

        $cf7_text = do_shortcode( '[contact-form-7 id="' . $_wpcf7 . '"]' );
        $cf7sr_key = get_option( 'cf7sr_key' );
        if (false === strpos($cf7_text, $cf7sr_key)) {
            return $result;
        }

        $message = get_option('cf7sr_message');
        if (empty($message)) {
            $message = 'Invalid captcha';
        }

        if (empty($data['g-recaptcha-response'])) {
            $result->invalidate(array('type' => 'captcha', 'name' => 'cf7sr-recaptcha'), $message);
            return $result;
        }

        $cf7sr_secret = get_option('cf7sr_secret');
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $cf7sr_secret . '&response=' . $data['g-recaptcha-response'];
        $request = wp_remote_get($url);
        $body = wp_remote_retrieve_body($request);
        $response = json_decode($body);
        if (!(isset ($response->success) && 1 == $response->success)) {
            $result->invalidate(array('type' => 'captcha', 'name' => 'cf7sr-recaptcha'), $message);
        }

        return $result;
    }
    add_filter('wpcf7_validate', 'cf7sr_verify_recaptcha_pro', 20, 2);
}

if (is_admin()) {
    function cf7sr_add_action_links_pro($links) {
        $mylinks = array(
            '<a href="' . admin_url( 'options-general.php?page=cf7sr_edit_pro' ) . '">Settings</a>',
        );
        return array_merge( $links, $mylinks );
    }
    add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'cf7sr_add_action_links_pro', 10, 2 );

    function cf7sr_adminhtml_pro() {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }
        if (! class_exists('WPCF7_Submission')) {
            echo '<p>To use <strong>Contact Form 7 Captcha</strong> please update <strong>Contact Form 7</strong> plugin as current version is not supported.</p>';
            return;
        }
        $languages = array(
            'Wpml' => 'WPML', 'Polylang' => 'POLYLANG', 'ar' => 'Arabic', 'af' => 'Afrikaans', 'am' => 'Amharic', 'hy' => 'Armenian',
            'az' => 'Azerbaijani', 'eu' => 'Basque', 'bn' => 'Bengali', 'bg' => 'Bulgarian', 'ca' => 'Catalan', 'zh-HK' => 'Chinese (Hong Kong)',
            'zh-CN' => 'Chinese (Simplified)', 'zh-TW' => 'Chinese (Traditional)', 'hr' => 'Croatian', 'cs' => 'Czech',
            'da' => 'Danish', 'nl' => 'Dutch', 'en-GB' => 'English (UK)', 'en' => 'English (US)', 'et' => 'Estonian',
            'fil' => 'Filipino', 'fi' => 'Finnish', 'fr' => 'French', 'fr-CA' => 'French (Canadian)', 'gl' => 'Galician',
            'ka' => 'Georgian', 'de' => 'German', 'de-AT' => 'German (Austria)', 'de-CH' => 'German (Switzerland)',
            'el' => 'Greek', 'gu' => 'Gujarati', 'iw' => 'Hebrew', 'hi' => 'Hindi', 'hu' => 'Hungarain', 'is' => 'Icelandic',
            'id' => 'Indonesian', 'it' => 'Italian', 'ja' => 'Japanese', 'kn' => 'Kannada', 'ko' => 'Korean', 'lo' => 'Laothian',
            'lv' => 'Latvian', 'lt' => 'Lithuanian', 'ms' => 'Malay', 'ml' => 'Malayalam', 'mr' => 'Marathi', 'mn' => 'Mongolian',
            'no' => 'Norwegian', 'fa' => 'Persian', 'pl' => 'Polish', 'pt' => 'Portuguese', 'pt-BR' => 'Portuguese (Brazil)',
            'pt-PT' => 'Portuguese (Portugal)', 'ro' => 'Romanian', 'ru' => 'Russian', 'sr' => 'Serbian', 'si' => 'Sinhalese',
            'sk' => 'Slovak', 'sl' => 'Slovenian', 'es' => 'Spanish', 'es-419' => 'Spanish (Latin America)', 'sw' => 'Swahili',
            'sv' => 'Swedish', 'ta' => 'Tamil', 'te' => 'Telugu', 'th' => 'Thai', 'tr' => 'Turkish', 'uk' => 'Ukrainian',
            'ur' => 'Urdu', 'vi' => 'Vietnamese', 'zu' => 'Zulu'
        );
        if (
            ! empty ($_POST['update'])
            && ! empty($_POST['cf7sr_nonce'])
            && wp_verify_nonce($_POST['cf7sr_nonce'],'cf7sr_update_settings' )
        ) {
            $cf7sr_key = !empty ($_POST['cf7sr_key']) ? sanitize_text_field($_POST['cf7sr_key']) : '';
            update_option('cf7sr_key', $cf7sr_key);

            $cf7sr_secret = !empty ($_POST['cf7sr_secret']) ? sanitize_text_field($_POST['cf7sr_secret']) : '';
            update_option('cf7sr_secret', $cf7sr_secret);

            $cf7sr_message = !empty ($_POST['cf7sr_message']) ? sanitize_text_field($_POST['cf7sr_message']) : '';
            update_option('cf7sr_message', $cf7sr_message);

            $cf7sr_language = !empty ($_POST['cf7sr_language']) ? sanitize_text_field($_POST['cf7sr_language']) : '';
            update_option('cf7sr_language', $cf7sr_language);

            $updated = 1;
        } else {
            $cf7sr_key = get_option('cf7sr_key');
            $cf7sr_secret = get_option('cf7sr_secret');
            $cf7sr_message = get_option('cf7sr_message');
            $cf7sr_language = get_option('cf7sr_language');
        }
        ?>
        <div class="cf7sr-wrap" style="font-size: 15px; background: #fff; border: 1px solid #e5e5e5; margin-top: 20px; padding: 0 20px 20px; margin-right: 20px;">
            <h2>
                Captcha Settings
                <a style="text-decoration: none" target="_blank" href="https://www.paypal.me/cf7captcha">
                    <img style="vertical-align:middle;display:inline-block;width:100px;margin-left:5px;" src="<?php echo plugin_dir_url( __FILE__ ); ?>donate.png" alt="Donate">
                </a>
            </h2>
            This plugin implements "I'm not a robot" checkbox.<br><br>
            To add Recaptcha to CF7 form, add <strong>[cf7sr-simple-recaptcha]</strong> in your form ( preferable above submit button )<br><br>
            Default size of captcha is "normal". For "compact" size, use <strong>[cf7sr-simple-recaptcha size="compact"]</strong><br>
            Default color theme of captcha is "light". For "dark" theme, use <strong>[cf7sr-simple-recaptcha theme="dark"]</strong><br>
            Default type of captcha is "image". For "audio" type, use <strong>[cf7sr-simple-recaptcha type="audio"]</strong><br><br>
            <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
                <input type="hidden" value="1" name="update">
                <?php wp_nonce_field( 'cf7sr_update_settings', 'cf7sr_nonce' ); ?>
                <ul>
                    <li><input type="text" style="width: 370px;" value="<?php echo esc_attr($cf7sr_key); ?>" name="cf7sr_key"> Site key</li>
                    <li><input type="text" style="width: 370px;" value="<?php echo esc_attr($cf7sr_secret); ?>" name="cf7sr_secret"> Secret key</li>
                    <li><input type="text" style="width: 370px;" value="<?php echo esc_attr($cf7sr_message); ?>" name="cf7sr_message"> Invalid captcha error message</li>
                    <li>
                        <select name="cf7sr_language" style="width: 100px;">
                            <option value=""></option>
                            <?php foreach ($languages as $key => $label) { ?>
                                <option value="<?php echo $key; ?>" <?php if ($key == $cf7sr_language) { echo 'selected'; } ?>><?php echo $label; ?></option>
                            <?php } ?>
                        </select>
                        Force Captcha to render in a specific language. Choose WPML or POLYLANG to render same language as WPML or POLYLANG plugins. Google auto-detects if unspecified.
                    </li>
                </ul>
                <input type="submit" class="button-primary" value="Save Settings">
            </form>
            <?php if (!empty($updated)): ?>
                <p>Settings were updated successfully!</p>
            <?php endif; ?><br><br>
            You can generate Site key and Secret key <strong><a target="_blank" href="https://www.google.com/recaptcha/admin">here</a></strong>, once generated, paste them below for this plugin to work.<br>
            <strong style="color:red">Choose reCAPTCHA v2 -> Checkbox</strong><br>
            <a target="_blank" href="https://www.google.com/recaptcha/admin"><img src="<?php echo plugin_dir_url( __FILE__ ); ?>captcha.jpg" width="400" alt="captcha" /></a>
        </div>
        <?php
    }

    function cf7sr_addmenu_pro() {
        add_submenu_page (
            'options-general.php',
            'CF7 Captcha Pro',
            'CF7 Captcha Pro',
            'manage_options',
            'cf7sr_edit_pro',
            'cf7sr_adminhtml_pro'
        );
    }
    add_action('admin_menu', 'cf7sr_addmenu_pro');
}
