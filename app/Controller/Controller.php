<?php

namespace App\Controller;

use Col\Controller as BaseController;

require_once APP_DIR . 'function.php';

class Controller extends BaseController
{
    /**
     * 用户组常量
     * USER_ADMINISTRATOR 管理员
     * USER_CONTRIBUTOR   审核员
     * USER_VISITOR       游客
     */
    const USER_ADMINISTRATOR = [
        'level' => 0,
        'name'  => 'administrator',
    ];

    const USER_CONTRIBUTOR = [
        'level' => 1,
        'name'  => 'contributor',
    ];

    const USER_VISITOR = [
        'level' => 2,
        'name'  => 'visitor',
    ];

    /**
     * 通用变量
     * $id      唯一的session id
     * $config  通用配置
     */
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
        } else {
            $data['data'] = [];
        }

        header("Pragma: no-cache");
        header("Cache-Control: no-cache");
        header("Access-Control-Allow-Origin: {$this->config['url']}");
        header('Content-type: application/json;charset=utf-8');
        exit(json($data));
    }

    /**
     * 输出头像
     * @param $qq
     * @return string
     */
    protected function pic($qq) {
        return is_null($qq == '' ? null : $qq) ? ($this->config['random_avatar'] ? ImgController::identicon() : '/img/default.png') : $this->config['url'] . 'pic/' . bit($qq ?? '1547755744');
    }
}