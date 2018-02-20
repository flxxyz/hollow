<?php

namespace App\Controller;

class LoveController extends Controller
{
    public function index()
    {
        $explain = DB('explains')->order('ctime desc')->select('id as eid, user_from, user_to, content, qq, anonymous, hide, hash, created_time as ctime');
        $data = $explain;
        for ($i = 0; $i < count($data); $i++) {
            if (0) {
                $data[$i]['content'] = '**************';
            } else {
                $content = $data[$i]['content'];
                if (mb_strlen($content) > 21) {
                    $content = msubstr($data[$i]['content'], 0, 21);
                }
                $data[$i]['content'] = $content;
            }

            $likes = DB('likes');
            $like = $likes->where('explain_id', $data[$i]['eid'])->fetch();
            $total = $like['total'] ?? 0;
            $data[$i]['total'] = $total;
            $data[$i]['qq'] = $data[$i]['qq'] ?? '1547755744';
            $data[$i]['img'] = $this->config['url'] . 'pic/' . bit($data[$i]['qq']);
            $data[$i]['ctime'] = format_date($data[$i]['ctime']);
        }

        $count = $explain->count();
        view('love/index', [
            'data'  => $data,
            'count' => $count,
        ]);
    }

    public function say()
    {
        $key = $this->config['key'];
        $token = md5(time() . $key);
        $effect = get_array(DB('resources')->where('type', '1')->select('id, name'));
        $bg = get_array(DB('resources')->where('type', '2')->select('id, name'));
        view('love/say', [
            'effect' => $effect,
            'bg'     => $bg,
        ]);
    }

    public function show($id)
    {
        $explain = DB('explains')->where('hash', $id);
        if (count($explain) < 1) {
            return redirect('/');
        }

        $explain = $explain->select('id, user_from, user_to, content, qq, anonymous, hide, hash, created_time as ctime')->fetch();
        $explain['qq'] = $explain['qq'] ?? '1547755744';
        $explain['img'] = $this->config['url'] . 'pic/' . bit($explain['qq']);
        $explain['ctime'] = format_date($explain['ctime']);

        $comment = DB('comments')->where('explain_id', $explain['id'])->order('created_time asc');
        $new_comment = [];
        foreach ($comment as $item) {
            $new_comment[$item['pid']][] = [
                'id'         => $item['id'],
                'explain_id' => $item['explain_id'],
                'pid'        => $item['pid'],
                'name'       => $item['name'],
                'content'       => $item['content'],
                'qq'         => $this->config['url'] . 'pic/' . bit($item['qq'] ?? '1547755744'),
                'sex'        => $item['sex'],
                'ip'         => $item['ip'],
                'ctime'      => format_date($item['created_time']),
            ];
        }
        $tree = createTree($new_comment, [['id' => null]]);
        $comment = $tree[0];
        unset($tree, $new_comment);
//        echo '<pre>';
//        exit(print_r($comment));
        view('love/show', [
            'title'   => $explain['user_from'] . '想对' . $explain['user_to'] . '说',
            'explain' => $explain,
            'comment' => $comment,
        ]);
    }
}