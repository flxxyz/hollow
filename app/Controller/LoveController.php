<?php

namespace App\Controller;

class LoveController extends Controller
{
    public function say()
    {
        $key = $this->config['key'];
        $token = md5(time() . $key);
        view('love/say');
    }
}