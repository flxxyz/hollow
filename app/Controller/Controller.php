<?php

namespace App\Controller;

use Col\Controller as BaseController;

require_once APP_DIR . 'function.php';

class Controller extends BaseController
{
    public $id;

    public $config;

    public function __construct()
    {
        $this->id = session_id();
        $this->config = config('config');

        session()->reset();
    }

    public function json(string $msg = '', $result = [], int $code = 200)
    {
        $data = [
            'message' => $msg,
            'code'    => $code,
        ];

        if ($code === 200) {
            $data['data'] = $result;
        }else {
            $data['data'] = [];
        }

        header("Access-Control-Allow-Origin: {$this->config['url']}");
        header('Content-type: application/json;charset=utf-8');
        exit(json($data));
    }
}