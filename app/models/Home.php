<?php

namespace App\Models;

use App\Lib\Registry;
use App\Lib\Traits\CssAdd;

class Home
{
    use CssAdd;

    public array $data = [];

    public function __construct()
    {
        // add css for head in template
        $this->data['css'] = $this->cssAdd('public'.DS.'css');

        $this->data['nav'] = Registry::get('nav');

        if (null !== \App\Lib\Registry::get('page_db_data')) {
            $this->data['page_db_data'] = \App\Lib\Registry::get('page_db_data');
        } else {
            $this->dbQuery();
        }
    }

    protected function dbQuery()
    {
        $this->data['page_db_data'] = [
                ['page_alias' => 'home',
                'page_title' => 'Phone dictionary',
                'page_meta_description' => 'Phone dictionary main',
                'page_robots' => 'INDEX, FOLLOW',
                'page_h1' => 'Phone dictionary',
                ]];
        \App\Lib\Registry::set('page_db_data', $this->data['page_db_data']);
    }

    public function get_data($path = [])
    {
        // Get data from json file with contacts data
        $jsonData = getContentOrCreateFile(APPROOT.DS.'phone_dictionary'.DS.'dictionary.json');
        $dataArray = json_decode($jsonData, true);
        if (!empty($dataArray)) {
            $this->data['page_db_data'][0]['page_content'] = $dataArray;
        } else {
            $this->data['page_db_data'][0]['page_content'] = '<p class="pad">Dictionary is empty.</p>';
        }

        return $this->data;
    }

    public function notFound404()
    {
        $this->get_data();
        $this->data['page_db_data'][0]['page_title'] = 'Page not found';
        $this->data['page_db_data'][0]['page_h1'] = '404 Not Found';
        $this->data['page_db_data'][0]['page_content'] = 'The page you requested was not found.';

        return $this->data;
    }
}
