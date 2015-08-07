<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * VePlatformAPI requests
 */
abstract class Ve_Platform_API
{
    protected $requestDomain = 'http://veconnect.veinteractive.com/API/';
    protected $requestEcommerce = 'EcommerceIdentifier/';
    protected $requestInstall = 'Install';
    protected $requestUninstall = 'Uninstall';
    protected $requestProducts = 'ActivateProducts';
    protected $requestTimeout = 15;
    protected $veProducts = array(
        'vecontact' => 1,
        'veprompt' => 2,
        'veassist' => 3,
        'veads' => 5
    );
    protected $requestParams = array();
    protected $config = array(
        'tag' => null,
        'pixel' => null,
        'token' => null,
        'products' => array()
    );

    public function __construct()
    {
        $this->setParams();
        $this->loadConfig();
    }

    abstract protected function setParams();
    abstract protected function loadConfig();
    abstract protected function saveJourney($journey);
    abstract protected function saveProducts($products);
    abstract protected function deleteConfig();

    /**
     * @return boolean
     */
    protected function getToken()
    {
        $token = $this->getConfigOption('token');
        return $token;
    }

    /**
     * @param string $option
     * @param boolean $reload (default: false)
     * @return string
     */
    public function getConfigOption($option, $reload = false)
    {
        if ($reload === true) {
            $this->loadConfig();
        }
        $value = array_key_exists($option, $this->config)? $this->config[$option] : null;
        return $value;
    }

    /**
     * @return boolean
     */
    public function isInstalled()
    {
        foreach (array('tag', 'pixel', 'token') as $name) {
            if ($this->config[$name] === null) {
                return false;
            }
        }
        return true;
    }

    /**
     * @return boolean
     */
    public function showLogin()
    {
        $response = $this->isInstalled() && count($this->config['products']) > 0;
        return $response;
    }

    /**
     * @param string $product
     * @return boolean
     */
    public function isProductActive($product)
    {
        $response = array_key_exists($product, $this->veProducts) &&
            in_array($this->veProducts[$product], $this->config['products']);
        return $response;
    }

    /**
     * @return boolean
     */
    public function installModule()
    {
        $params = $this->requestParams;
        $response = $this->getRequest($this->requestInstall, $params);
        if ($response) {
            $journey = json_decode($response);
            if (isset($journey->URLPixel) && isset($journey->URLTag) && isset($journey->Token)) {
                $journey->URLPixel = $this->cleanUrl($journey->URLPixel);
                $journey->URLTag = $this->cleanUrl($journey->URLTag);
                return $this->saveJourney($journey);
            }
        }
        return false;
    }

    /**
     * @param string $url
     * @return string
     */
    protected function cleanUrl($url)
    {
        $cleanUrl = preg_replace("(^https?:)", "", $url);
        return $cleanUrl;
    }

    /**
     * @return boolean
     */
    public function uninstallModule()
    {
        $params = $this->requestParams;
        $params['token'] = $this->getToken();
        $this->deleteConfig();
        $response = $this->getRequest($this->requestUninstall, $params);
        if ($response) {
            return json_decode($response);
        }
        return false;
    }

    /**
     * @param array $productsForm
     * @return boolean
     */
    public function activateProducts($productsForm)
    {
        $products = array();
        foreach ($productsForm as $product) {
            if (array_key_exists($product, $this->veProducts)) {
                $products[] = $this->veProducts[$product];
            }
        }
        if (count($products) === 0) {
            return true;
        }
        $params = $this->requestParams;
        $params['token'] = $this->getToken();
        $params['taskId'] = 1;
        $params['appCodes'] = implode('|', $products);
        $response = $this->getRequest($this->requestProducts, $params);
        if ($response) {
            $response = json_decode($response);
            if ($response === true) {
                $oldProducts = $this->getConfigOption('products');
                $productsToSave = array_merge($oldProducts, $products);
                $productsToSave = array_unique($productsToSave);
                sort($productsToSave);
                return $this->saveProducts($productsToSave);
            }
        }
        return false;
    }

    /**
     * @param string $requestAction
     * @param array $params
     * @return mixed
     */
    protected function getRequest($requestAction, $params)
    {
        $url = esc_url($this->requestDomain . $this->requestEcommerce . $requestAction);
        $options = array(
            'method' => 'POST',
            'timeout' => $this->requestTimeout,
            'body' => $params
        );
        $response = wp_remote_post($url, $options);
        if (!is_wp_error($response) && is_array($response) && array_key_exists('body', $response)) {
            return $response['body'];
        }
        return false;
    }
}
