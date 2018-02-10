<?php

namespace App\Controller;

use Col\Controller as BaseController;

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

    public function json(string $msg = '', int $code = 200, $result = [])
    {
        $data = [
            'message' => $msg,
            'code'    => $code,
        ];

        if ($code === 200) {
            $data['data'] = $result;
        }

        exit(json($data));
    }
}