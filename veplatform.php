<?php
/**
 * Plugin Name: Ve Platform
 * Plugin URI: http://www.veinteractive.com
 * Description: Instantly increase your sales by adding the VePlatform's integrated remarketing and re-engagement apps that convert customers who abandon your site.
 * Version: 15.1.4
 * Author: Ve Interactive
 * Author URI: http://www.veinteractive.com
 * License: GPL2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Check if WooCommerce is active
 **/
if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    return;
}

define( '_VEPLATFORM_MINIMUM_WP_VERSION_', '4.0' );
define( '_VEPLATFORM_PLUGIN_URL_', plugin_dir_url( __FILE__ ) );
define( '_VEPLATFORM_PLUGIN_DIR_', plugin_dir_path( __FILE__ ) );
define( '_VEPLATFORM_PLUGIN_HTTP_URL_', esc_url( add_query_arg( array( 'page' => 'veplatform-plugin-settings' ), admin_url( 'admin.php' ) ) ) );

require_once( _VEPLATFORM_PLUGIN_DIR_ . '/classes/class-api.php' );

if ( is_admin() ) {

    add_action( 'plugins_loaded', 'veplatform_load_textdomain' );
    register_activation_hook( __FILE__, 'veplatform_plugin_activation' );
    register_uninstall_hook( __FILE__, 'veplatform_plugin_uninstall' );
    add_action( 'activated_plugin', 'veplatform_plugin_activated' );
    add_action( 'deactivated_plugin', 'veplatform_plugin_deactivated' );
    add_action( 'admin_menu', 'veplatform_plugin_menu' );
    $plugin = plugin_basename(__FILE__);
    add_filter( 'plugin_action_links_' . $plugin, 'veplatform_plugin_settings_link' );

} else {
    add_action( 'wp_footer', 'veplatform_add_tag' );
    add_action( 'woocommerce_thankyou', 'veplatform_add_pixel' );
}

function veplatform_load_textdomain() {
    $locale = apply_filters( 'plugin_locale', get_locale(), 'veplatform' );
    if (file_exists(__DIR__ . '/languages/' . $locale . '.mo')) {
        load_textdomain( 'veplatform', __DIR__ . '/languages/' . $locale . '.mo' );
    } else {
        load_textdomain( 'veplatform', __DIR__ . '/languages/en_US.mo' );
    }
}

function veplatform_plugin_menu() {
    add_submenu_page( 'woocommerce', 'Ve Platform', 'Ve Platform', 'administrator', 'veplatform-plugin-settings', 'veplatform_plugin_settings_page' );
}

function veplatform_plugin_settings_link($links) {
    if ( array_key_exists( 'edit', $links ) ) {
        unset( $links['edit'] );
    }
    $settings_link = '<a href="' . _VEPLATFORM_PLUGIN_HTTP_URL_ . '">Settings</a>';
    array_unshift( $links, $settings_link );
    return $links;
}

function veplatform_plugin_settings_page() {

    wp_enqueue_style( 'veplatform_admin_styles_ve_veplatform_admin', _VEPLATFORM_PLUGIN_URL_ . 'assets/css/ve_veplatform_admin.css', array());
    wp_enqueue_script( 'veplatform_admin_js_app', _VEPLATFORM_PLUGIN_URL_ . 'assets/js/app.js', array());
    wp_enqueue_script( 'veplatform_admin_js_admin', _VEPLATFORM_PLUGIN_URL_ . 'assets/js/libs/ve_veplatform_admin.js', array());

    $thank_you = $show_error = false;
    $template = 've-platform';
    $api = new Ve_API();
    if ( $api->isInstalled() === false) {
        veplatform_log('Call webservice to install merchant', 'INFO');
        if ($api->installModule() === false) {
            veplatform_log('Error in webservice when installing merchant', 'ERROR');
            $template = 've-error';
        } else {
            veplatform_log('Merchant has been properly installed in webservice', 'INFO');
        }
    } elseif ( isset( $_POST['ve-confirm-btn'] ) && isset( $_POST['product'] )) {
        veplatform_log('Saving products', 'INFO');
        if ($api->activateProducts( $_POST['product'] ) === true) {
            veplatform_log('Products have been properly saved in webservice', 'OK');
            $template = 've-platform-thank-you';
        } else {
            veplatform_log('Error in webservice when saving products', 'ERROR');
            $template = 've-error';
        }
    }

    include( _VEPLATFORM_PLUGIN_DIR_ . '/templates/admin/' . $template . '.php');
}

function veplatform_plugin_activation() {
    global $wp_version;
    if ( version_compare( $wp_version, _VEPLATFORM_MINIMUM_WP_VERSION_, '<' ) ) {
        deactivate_plugins( basename( __FILE__ ) );
        $error = '<p>The <strong>Ve Platform</strong> plugin requires WordPress version ' . _VEPLATFORM_MINIMUM_WP_VERSION_ . ' or greater.</p>';
        wp_die($error, 'Plugin Activation Error', array( 'response' => 200, 'back_link' => true ) );
    }
    $api = new Ve_API();
    if ($api->isInstalled() === false) {
        veplatform_log('Call webservice to install merchant', 'INFO');
        if ($api->installModule() === true) {
            veplatform_log('Merchant has been properly installed in webservice', 'INFO');
        } else {
            veplatform_log('Error in webservice when installing merchant', 'ERROR');
        }
    }
}

function veplatform_plugin_activated() {
    veplatform_log('Module has been activated', 'INFO');
    exit( wp_redirect( _VEPLATFORM_PLUGIN_HTTP_URL_ ) );
}

function veplatform_plugin_deactivated() {
    veplatform_log('Module has been deactivated', 'INFO');
}

function veplatform_plugin_uninstall() {
    $api = new Ve_API();
    $api->uninstallModule();
}

function veplatform_add_tag() {
    $api = new Ve_API();
    include( _VEPLATFORM_PLUGIN_DIR_ . '/templates/frontend/ve-tag.php');
}

function veplatform_add_pixel() {
    $api = new Ve_API();
    include( _VEPLATFORM_PLUGIN_DIR_ . '/templates/frontend/ve-pixel.php');
}

function veplatform_log($message, $level)
{
    $file = __DIR__ . '/veplatform.log';
    if (is_writable($file) || (!file_exists($file) && is_writable(__DIR__)))
    {
        $formatted_message = '*' . $level . '* ' . "\t" . date('Y/m/d - H:i:s') . ': ' . $message . "\r\n";
        file_put_contents($file, $formatted_message, FILE_APPEND);
    }
}