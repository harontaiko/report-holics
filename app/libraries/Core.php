<?php

/**
 * App Core Class
 * Create url & Loads core controller
 * Url format /controller/method/params
 * @author: harontaiko
 * @site : www.chuonialumni.co.ke
 */

class Core
{
    protected $currentController = 'Users';
    protected $currentMethod = 'index';
    protected $params = [];

    /**
     * Method __construct
     *
     * @return void
     */
    public function __construct()
    {
        //print_r($this->getUrl());
        $url = $this->getUrl();

        // Look in controllers for first value
        if (isset($url[0])) {
            if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
                // If exists, set as controller

                $this->currentController = ucwords($url[0]);

                // Unset 0 Index
                unset($url[0]);
            } else {
                //throw 404 not found
                http_response_code(404);
                include('../app/404.php');
                die();
            }
        }


        // Require the controller
        require '../app/controllers/' . $this->currentController . '.php';

        // Instantiate controller class
        $this->currentController = new $this->currentController;

        //check for second part of url
        if (isset($url[1])) {
            //check to see if method exists in controller
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];

                //unset
                unset($url[1]);
            }
        }


        //get params
        $this->params = $url ? array_values($url) : [];

        //call a claaback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    /**
     * Method getUrl
     *
     * @return void
     */
    public function getUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            return $url;
        }
    }
}