<?php

/**
 * Base controller
 * Loads the models and views
 * @author: harontaiko
 * @site : www.chuonialumni.co.ke
 */

class Controller
{
    /**
     * Method model
     *
     * @param $model $model [explicite description]
     *
     * @return void
     */
    public function model($model)
    {
        //require model file
        require('../app/models/' . $model . '.php');

        //instanciate
        return new $model;
    }

    public function view($view, $data = [])
    {
        //check for view file
        if (file_exists('../app/views/' . $view . '.php')) {
            require('../app/views/' . $view . '.php');
        } else {
            //throw 404 not found
            http_response_code(404);
            include('../app/404.php');
            die();
        }
    }
}