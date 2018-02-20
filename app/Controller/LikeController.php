<?php

namespace App\Controller;

class LikeController extends Controller
{
    public function add($id)
    {
        $explain = DB('explains')->where('hash', $id)->select('id')->fetch();
        $likes = DB('likes')->where('explain_id', $explain['id'])->select('id, total');
        if (count($likes) < 1) {
            return $this->json('点赞失败', [], 110);
        }

        $like = $likes->fetch();
        $id = $like['id'];
        $total = $like['total'] + 1;
        $likes->where('id', $id)->update(['total' => $total]);
        $this->json('点赞成功', ['total' => $likes[$id]['total']]);
    }

    public function get($id)
    {
        $explain = DB('explains')->where('hash', $id)->select('id')->fetch();
        $likes = DB('likes')->where('explain_id', $explain['id'])->select('id, total');
        if (count($likes) < 1) {
            return $this->json('获取失败', [], 110);
        }

        $like = $likes->fetch();
        $this->json('获取成功', ['total' => $like['total']]);
    }
}