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
            'name'         => $name[$i - 1] . mt_rand(1, 999),
            'value'        => '',
            'created_time' => time(),
        ];
        $r->insert($data);

        $this->json('ok', $r->insert_id());
    }

    public function db()
    {
        $explain = DB('explains')->order('created_time desc');
        $count = $explain->count();
        $data = [];
        foreach ($explain as $id => $item) {
            $content = $item['content'];
            if (0) {
                $content = '**************';
            } else {
                if (mb_strlen($content) > 21)
                    $content = msubstr($item['content'], 0, 21);
            }

            $like = DB('likes')->where('explain_id', $item['id'])->fetch();
            $item['total'] = $like['total'];
            $item['img'] = $this->pic($item['qq']);
            $item['ctime'] = format_date($item['created_time']);
            $item['content'] = $content;
            $data[] = $item;
        }
        unset($explain, $item);

        $this->json('', [
            'data'  => $data,
            'count' => $count,
        ]);
    }
}