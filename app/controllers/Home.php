<?php

namespace App\Controllers;

use App\Lib\Registry;

class Home
{
    protected $param = [];
    protected $model;
    protected $view;

    public function __construct()
    {
        $this->view = new \App\Lib\View();
    }

    public function index($path = [])
    {
        $arr = explode('\\', static::class);
        $class = array_pop($arr);
        $full_name_class = '\App\Models\\'.$class;
        if (class_exists($full_name_class)) {
            $this->model = new $full_name_class($class);
            if (!empty($path[0])) {
                if (method_exists($this->model, $path[0])) {
                    $method = $path[0];
                    $nav = Registry::get('nav');
                    array_push($nav, array_shift($path));
                    Registry::set('nav', $nav);
                    // $data = ($this->model)->$method($path);
                    $data = array_merge($this->model->get_data($path), $this->model->$method($path));
                } else {
                    header('HTTP/1.0 404 Not Found');
                    $data = $this->model->get_data($path);
                    $data['page_db_data'][0]['page_title'] = 'Страница не найдена (Page not found)';
                    $data['page_db_data'][0]['page_content'] = 'Страница, которую Вы запросили, не найдена.';
                }
            } else {
                $data = $this->model->get_data($path);
            }
        }
        $this->view->generate(APPROOT.DS.'view/'.$class.'.php', $data);
        // $this->view->generate(APPROOT.DS.'view/'.$data['page_db_data'][0]['page_alias'].'.php', $data);
    }

    public function pageNotFound()
    {
        header('HTTP/1.0 404 Not Found');
        $model = new \App\Models\Home('pages', 'Home');
        $data = $model->notFound404();
        $this->view->generate(APPROOT.DS.'view/Home.php', $data);
    }
}
