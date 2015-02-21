<?php

function wpam_google_recaptcha_admin_interface() {
    echo '<div class="wrap">';
    echo '<div id="poststuff"><div id="post-body">';

    echo '<h2>Affiliates Manager and Google reCAPTCHA</h2>';

    if (isset($_POST['wpam_google_recaptcha_save_settings'])) {
        update_option('wpam_google_recaptcha_site_key', $_REQUEST['wpam_google_recaptcha_site_key']);
        update_option('wpam_google_recaptcha_secret_key', $_REQUEST['wpam_google_recaptcha_secret_key']);
        echo '<div id="message" class="updated fade">';
        echo '<p>MailPoet Settings Saved!</p>';
        echo '</div>';
    }
    ?>

    <p style="background: #fff6d5; border: 1px solid #d1b655; color: #3f2502; margin: 10px 0;  padding: 5px 5px 5px 10px;">
        Read the <a href="https://wpaffiliatemanager.com/affiliates-manager-google-recaptcha-integration/" target="_blank">usage documentation</a> to learn how to use the Google reCAPTCHA addon
    </p>

    <form action="" method="POST">

        <div class="postbox">
            <h3><label for="title">Google reCAPTCHA Settings</label></h3>
            <div class="inside">
                <table class="form-table">
                    
                    <tr valign="top"><td width="25%" align="left">
                            Site Key
                        </td><td align="left">
                            <input name="wpam_google_recaptcha_site_key" type="text" size="60" value="<?php echo get_option('wpam_google_recaptcha_site_key'); ?>"/>                   
                            <p class="description">The site key for the reCAPTCHA API</p>
                        </td>
                    </tr>
                    
                    <tr valign="top"><td width="25%" align="left">
                            Secret Key
                        </td><td align="left">
                            <input name="wpam_google_recaptcha_secret_key" type="text" size="60" value="<?php echo get_option('wpam_google_recaptcha_secret_key'); ?>"/>                   
                            <p class="description">The secret key for the reCAPTCHA API</p>
                        </td>
                    </tr>
                    
                </table>
            </div></div>
        <input type="submit" name="wpam_google_recaptcha_save_settings" value="Save" class="button-primary" />

    </form>


    <?php
    echo '</div></div>'; //end of poststuff and post-body
    echo '</div>'; //end of wrap 
}
