<?php

namespace App\Controller;

class LoveController extends Controller
{
    public function index()
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

        header("Pragma: no-cache");
        header("Cache-Control: no-cache");
        view('love/index', [
            'data'  => $data,
            'count' => $count,
        ]);
    }

    public function say()
    {
        $effect = DB('resources')->where('type', '1')->select('id, name');
        $bg = DB('resources')->where('type', '2')->select('id, name');

        view('love/say', [
            'effect' => $effect,
            'bg'     => $bg,
        ]);
    }

    public function show($id)
    {
        $count = DB('explains')->where('hash', $id)->count();
        if ($count <= 0) {
            return redirect('/');
        }

        $explain = DB('explains')->where('hash', $id)->fetch();
        $explain['img'] = $this->pic($explain['qq']);
        $explain['ctime'] = format_date($explain['created_time']);

        $comment = DB('comments')->where('explain_id', $explain['id'])->order('created_time asc');
        $new_comment = [];
        foreach ($comment as $item) {
            $new_comment[$item['pid']][] = [
                'id'         => $item['id'],
                'explain_id' => $item['explain_id'],
                'pid'        => $item['pid'],
                'name'       => $item['name'],
                'content'    => $item['content'],
                'qq'         => $this->pic($item['qq']),
                'sex'        => $item['sex'],
                'ip'         => $item['ip'],
                'ctime'      => format_date($item['created_time']),
            ];
        }
        $tree = createTree($new_comment, [['id' => null]]);
        $comment = $tree[0];
        unset($tree, $new_comment);

        header("Pragma: no-cache");
        header("Cache-Control: no-cache");
        view('love/show', [
            'title'   => $explain['user_from'] . '想对' . $explain['user_to'] . '说',
            'explain' => $explain,
            'comment' => $comment,
        ]);
    }
}