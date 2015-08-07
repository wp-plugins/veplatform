<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

include_once plugin_dir_path(__FILE__) . 'class-veplatform-api.php';

class Ve_API extends Ve_Platform_API
{
    protected $requestEcommerce = 'WooCommerce/';

    protected function loadConfig()
    {
        $config = get_option('ve_platform', array());
        $this->config['tag'] = array_key_exists('ve_tag', $config)? $config['ve_tag'] : $this->config['tag'];
        $this->config['pixel'] = array_key_exists('ve_pixel', $config)? $config['ve_pixel'] : $this->config['pixel'];
        $this->config['token'] = array_key_exists('ve_token', $config)? $config['ve_token'] : $this->config['token'];
        $this->config['products'] = array_key_exists('ve_products', $config)? $config['ve_products'] : $this->config['products'];
    }

    protected function saveJourney($journey)
    {
        $config = array(
            've_tag' => $journey->URLTag,
            've_pixel' => $journey->URLPixel,
            've_token' => $journey->Token
        );
        $this->saveConfig($config);
        return true;
    }

    protected function saveProducts($products)
    {
        $veplatformoptions = get_option('ve_platform');
        $veplatformoptions['ve_products'] = $products;
        $this->saveConfig($veplatformoptions);
        return true;
    }

    protected function saveConfig($config)
    {
        update_option('ve_platform', $config);
    }

    protected function deleteConfig()
    {
        delete_option('ve_platform');
    }

    protected function setParams()
    {
        global $wp_version, $woocommerce;
        $domain = preg_replace("(^https?:\/\/)", "", get_site_url());
        $default_country = explode(':', get_option('woocommerce_default_country', ''));
        $country = $default_country[0];
        $this->requestParams = array(
            'domain' => $domain,
            'language' => get_option('WPLANG', 'en'),
            'email' => get_option('admin_email'),
            'phone' => null,
            'merchant' => get_option('blogname'),
            'country' => $country,
            'currency' => get_option('woocommerce_currency'),
            'version' => 'wp:' . $wp_version . ';woo:' . $woocommerce->version
        );
    }
}
