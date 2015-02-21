<?php
/**
 * Plugin Name: Affiliates Manager Google reCAPTCHA Integration
 * Plugin URI: https://wpaffiliatemanager.com/affiliates-manager-google-recaptcha-integration/
 * Description: This Addon allows you to add Google reCAPTCHA to your affiliate registration form
 * Version: 1.0
 * Author: wp.insider
 * Author URI: https://wpaffiliatemanager.com
 * Requires at least: 3.0
 */

if (!defined('ABSPATH')){
    exit;
}

if (!class_exists('AFFMGR_GOOGLE_RECAPTCHA_ADDON')) {

    class AFFMGR_GOOGLE_RECAPTCHA_ADDON {

        var $version = '1.0';
        var $db_version = '1.0';
        var $plugin_url;
        var $plugin_path;

        function __construct() {
            $this->define_constants();
            $this->includes();
            $this->loader_operations();
            //Handle any db install and upgrade task
            add_action('init', array($this, 'plugin_init'), 0);
            add_action('wpam_after_main_admin_menu', array($this, 'google_recaptcha_do_admin_menu'));
            add_filter('wpam_before_registration_submit_button', array($this, 'add_google_recaptcha_code'));
            add_filter('wpam_validate_registration_form_submission', array($this, 'validate_google_recaptcha_code'), 10, 2);
        }

        function define_constants() {
            define('AFFMGR_GOOGLE_RECAPTCHA_ADDON_VERSION', $this->version);
            define('AFFMGR_GOOGLE_RECAPTCHA_ADDON_URL', $this->plugin_url());
            define('AFFMGR_GOOGLE_RECAPTCHA_ADDON_PATH', $this->plugin_path());
        }

        function includes() {
            include_once('affmgr-recaptcha-settings.php');
        }

        function loader_operations() {
            //add_action('plugins_loaded', array(&$this, 'plugins_loaded_handler')); //plugins loaded hook		
        }

        function plugin_init() {//Gets run with WP Init is fired
        }

        function google_recaptcha_do_admin_menu($menu_parent_slug) {
            add_submenu_page($menu_parent_slug, __("Google reCAPTCHA", 'wpam'), __("Google reCAPTCHA", 'wpam'), 'manage_options', 'wpam-google-recaptcha', 'wpam_google_recaptcha_admin_interface');
        }

        function plugin_url() {
            if ($this->plugin_url)
                return $this->plugin_url;
            return $this->plugin_url = plugins_url(basename(plugin_dir_path(__FILE__)), basename(__FILE__));
        }

        function plugin_path() {
            if ($this->plugin_path)
                return $this->plugin_path;
            return $this->plugin_path = untrailingslashit(plugin_dir_path(__FILE__));
        }
        
        function add_google_recaptcha_code($output){
            require_once('recaptchalib.php');
            $siteKey = get_option('wpam_google_recaptcha_site_key');
            //$output = recaptcha_get_html($publickey);
            $output .= '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
            $output .= '<div class="wpam_g_captcha">';
            $output .= '<div class="g-recaptcha" data-sitekey="'.$siteKey.'"></div>';
            $output .= '</div>';
            return $output;
        }
        
        function validate_google_recaptcha_code($output, $request){          
            $output = 'error';          
            // Was there a reCAPTCHA response?
            if(isset($request["g-recaptcha-response"])) { //recaptcha option was checked
                require_once('recaptchalib.php');
                $secret = get_option('wpam_google_recaptcha_secret_key');
                $reCaptcha = new ReCaptcha($secret);
                $resp = $reCaptcha->verifyResponse(
                    $_SERVER["REMOTE_ADDR"],
                    $request["g-recaptcha-response"]
                );
                if ($resp != null && $resp->success) {  //valid reCAPTCHA response
                    $output = '';
                }
            }
            return $output;
        }

    }

    //End of plugin class
}//End of class not exists check

$GLOBALS['AFFMGR_GOOGLE_RECAPTCHA_ADDON'] = new AFFMGR_GOOGLE_RECAPTCHA_ADDON();
