<?php

namespace App\Controller;

class LikeController extends Controller
{
    public function add($id)
    {
        $explain = DB('explains')->where('hash', $id)->select('id')->fetch();
        $likes = DB('likes')->where('explain_id', $explain['id']);
        if (count($likes) <= 0) {
            return $this->json('点赞失败', [], 110);
        }
        unset($explain);

        $like = $likes->fetch();
        $id = $like['id'];
        $total = $like['total'] + 1;
        $result = DB('likes')->where('id', $id)->update(['total' => $total]);
        if (is_numeric($result)) {
            $this->json('点赞成功', ['total' => $total]);
        } else {
            $this->json('点赞失败', [], 110);
        }
    }

    public function get($id)
    {
        $explain = DB('explains')->where('hash', $id)->select('id')->fetch();
        $likes = DB('likes')->where('explain_id', $explain['id']);
        if (count($likes) <= 0) {
            return $this->json('获取失败', [], 110);
        }
        unset($explain);

        $like = $likes->fetch();
        $this->json('获取成功', ['total' => $like['total']]);
    }
}