<?php

/**
 * Created by PhpStorm.
 * User: Shtoo
 * Date: 18.03.2017
 * Time: 17:01
 */

class Router
{

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var string
     */
    protected $controller;

    /**
     * @var string
     */
    protected $action;

    /**
     * @var array
     */
    protected $params;

    /**
     * @var string
     */
    protected $route;

    /**
     * @var string
     */
    protected $method_prefix;

    /**
     * @var string
     */
    protected $language;

    /**
     * @return mixed
     */
    public function getUri()
    {

        return $this->uri;
    }

    /**
     * @return mixed
     */
    public function getController()
    {

        return $this->controller;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {

        return $this->action;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {

        return $this->params;
    }

    /**
     * Router constructor.
     * @param $uri
     */


    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @return mixed
     */
    public function getMethodPrefix()
    {
        return $this->method_prefix;
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Router constructor.
     * @param $uri
     */
    public function __construct($uri)
    {
        $this->uri = urldecode(trim($uri, '/'));//Очищаем строку от слешей(trim),urldecode - декодирует URL-кодированную строку

        //Get defaults
        $routes = Config::get('routes');
        $this->method_prefix = isset($routes[$this->route]) ? $routes[$this->route] : '';
        $this->route = Config::get('default_route');
        $this->language = Config::get('default_language');
        $this->controller = Config::get('default_controller');
        $this->action = Config::get('default_action');

        //массив строк
        $uri_parts = explode('?', $this->uri);//уберем ?  из запроса

        //Get path like /lng/controller/action/param1/param2/....../..../
        $path = $uri_parts[0];

//        //массив
//        (
//        [0] => controller
//        [1] => action
//        [2] => param1
//        [3] => param2
        $path_parts = explode('/', $path);

//        echo "<pre>";
//        print_r($path_parts);

        //Проверим что масив не пустой
        if (count($path_parts)) {
            //Get Route of language at first element;
            if (in_array(strtolower(current($path_parts)), array_keys($routes))) {
                $this->route = strtolower(current($path_parts));
//                echo "<pre>";
//                echo "router->";
//                $hhh=$this->getRoute();
//                print_r($hhh);
//                echo "<pre>";
                $this->method_prefix = isset($routes[$this->route]) ? $routes[$this->route] : '';
//               $ghj = $this->getMethodPrefix();
//                echo "methodprefix->";
//                print_r($ghj);
//                echo "<pre>";
                //Сдвинем массив на 1 єлемент
                array_shift($path_parts);
                //               echo "array_shift";
//                print_r($path_parts);
//                echo "<pre>";
            } elseif (in_array(strtolower(current($path_parts)), Config::get('languages'))) {
                $this->language = strtolower(current($path_parts));
                array_shift($path_parts);
            }
            //Get controller
            if (current($path_parts)) {
                $this->controller = strtolower(current($path_parts));
                array_shift($path_parts);
            }
            //Get action
            if (current($path_parts)) {
                $this->action = strtolower(current($path_parts));
                array_shift($path_parts);
            }
            //Get params - all the rest
            $this->params = $path_parts;


        }
    }
}


