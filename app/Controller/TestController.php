<?php
/**
 * 测试添加数据库控制器
 */
namespace App\Controller;

class TestController extends Controller
{
    public function add()
    {
        $name = [
            '特效',
            '背景',
        ];
        $r = DB('resources');
        $i = mt_rand(1, 2);
        $data = [
            'type'         => $i,
            'name'         => $name[$i-1] . mt_rand(1, 999),
            'value'        => '',
            'created_time' => time(),
        ];
        $r->insert($data);

        $this->json('ok', $r->insert_id());
    }
}