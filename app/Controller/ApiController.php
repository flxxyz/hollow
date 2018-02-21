<?php

namespace App\Controller;

class ApiController extends Controller
{
    public function say()
    {
        $ip = get_client_ip();
        // ip限制

        $body = $this->post();

        if (!$body['phone']) {
            $body['phone'] = null;
        }

        if (!$body['qq']) {
            $body['qq'] = null;
        }

        if (!$body['effect'] || $body['effect'] <= 0) {
            $body['effect'] = '0';
        }

        if (!$body['bg'] || $body['bg'] <= 0) {
            $body['bg'] = '0';
        }

        $now = time();
        $hash_str = hash('crc32', $body['from'] . $this->config['key'] . $now . mt_rand(0, 1000) . $body['to']);
        $body['hash'] = $hash_str;
        $body['ip'] = $ip;
        $body['created_time'] = $now;

        $body['user_from'] = $body['from'];
        unset($body['from']);
        $body['user_to'] = $body['to'];
        unset($body['to']);

        $result = DB('explains')->insert($body);
        DB('likes')->insert([
            'explain_id' => $result['id'],
        ]);
        $hash = $result['hash'];
        $data = [
            'id'      => $hash,
            'url'     => $this->config['url'] . 's/' . $hash,
            'manager' => '',
        ];
        $this->json('发布成功！', $data);
    }

    public function comment()
    {
        $ip = get_client_ip();
        // ip限制

        $body = $this->post();

        $explain = DB('explains')->where('hash', $body['id'])->select('id');
        if (count($explain) <= 0) {
            $this->json('传递错误的参数', '', 100);
        }
        unset($body['id']);
        $explain = $explain->fetch();
        $body['explain_id'] = $explain['id'];

        if (!$body['qq']) {
            $body['qq'] = null;
        }

        if (!$body['pid'] || $body['pid'] <= 0) {
            $body['pid'] = null;
        }

        $body['name'] = $body['from'];
        unset($body['from']);

        $now = time();
        $body['ip'] = $ip;
        $body['created_time'] = $now;

        DB('comments')->insert($body);

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
        $comment = $tree[0]['children'];
        unset($item, $tree, $new_comment);

        $data = <<<EOT
<h3 class="margin-bottom">评论列表</h3>
EOT;
        foreach ($comment as $item) {
            switch ($item['sex']) {
                case 0:
                    $sex_color = 'text-venus';
                    $sex_icon = 'fa-venus';
                    break;
                case 1:
                    $sex_color = 'text-mars';
                    $sex_icon = 'fa-mars';
                    break;
                default:
                    $sex_color = 'text-transgender';
                    $sex_icon = 'fa-transgender';
                    break;
            }

            $children = '';
            if (isset($item['children']) && count($item['children']) > 0) {
                $children .= '<hr class="border-small border-bottom"><ul>';
                foreach ($item['children'] as $k => $v) {
                    switch ($v['sex']) {
                        case 0:
                            $sex_color_item = 'text-venus';
                            $sex_icon_item = 'fa-venus';
                            break;
                        case 1:
                            $sex_color_item = 'text-mars';
                            $sex_icon_item = 'fa-mars';
                            break;
                        default:
                            $sex_color_item = 'text-transgender';
                            $sex_icon_item = 'fa-transgender';
                            break;
                    }
                    $border = ($k != (count($item['children']) - 1)) ? 'border-small border-bottom' : '';
                    $children .= <<<EOT
<li id="comment-{$v['id']}" class="c-XN-li {$border}">
    <a href="#comment-{$v['id']}" class="author {$sex_color_item}">
        <img class="radius-circle" src="{$v['qq']}" title=""/><span class="name">{$v['name']}</span>
    </a>
    <span class="icon is-small" style=""><i class="fas {$sex_icon_item}" aria-hidden="true"></i></span>
    <p class="content">{$v['content']}</p>
    <div class="foot">
        <span class="time">{$v['ctime']}</span>
        <span class="reply" data-id="{$item['id']}" data-reply="{$v['id']}">回复</span>
    </div>
</li>
EOT;
                }
                $children .= '</ul>';
            }

            $data .= <<<EOT
<li id="comment-{$item['id']}" class="c-XN-li border-small border-bottom">
    <a href="#comment-{$item['id']}" class="author {$sex_color}">
        <img class="radius-circle" src="{$item['qq']}" title=""/>{$item['name']}
    </a>
    <span class="icon is-small" style=""><i class="fas {$sex_icon}" aria-hidden="true"></i></span>
    <p class="content">{$item['content']}</p>
    <div class="foot">
        <span class="time">{$item['ctime']}</span>
        <span class="reply" data-id="{$item['id']}">回复</span>
    </div>
    {$children}
</li>
EOT;
        }

        $this->json('评论成功', $data);
    }

    private function post()
    {
        $request = $this->request();
        if ($request->method == 'GET') {
            $this->json('error', '', 100);
        }

        $body = $request->body;
        foreach ($body as $key => $value) {
            $body[$key] = $this->clear_sql(htmlspecialchars(strip_tags($value)));
        }

        return $body;
    }

    private function clear_sql($str)
    {
        $str = str_replace(" and ", "", $str);
        $str = str_replace(" or ", "", $str);
        $str = str_replace("execute", "", $str);
        $str = str_replace("update ", "", $str);
        $str = str_replace("count(", "", $str);
        $str = str_replace("chr ", "", $str);
        $str = str_replace("mid ", "", $str);
        $str = str_replace("master ", "", $str);
        $str = str_replace("truncate ", "", $str);
        $str = str_replace("char ", "", $str);
        $str = str_replace("declare ", "", $str);
        $str = str_replace("select ", "", $str);
        $str = str_replace("create ", "", $str);
        $str = str_replace("delete ", "", $str);
        $str = str_replace("insert ", "", $str);
        $str = str_replace("alert(", "", $str);
        $str = str_replace("drop ", "", $str);
        $str = str_replace(" from ", "", $str);
        $str = str_replace("console.", "", $str);
        //        $str = str_replace("'", "", $str);
        //        $str = str_replace('"', "", $str);
        $str = str_replace("=", "", $str);
        $str = str_replace("/", "", $str);
        $str = str_replace("\\", "", $str);
        $str = str_replace("&nbsp;", "", $str);
        $str = str_replace("&quot;", "", $str);
        $str = str_replace("&quot;", "", $str);
//        $str = str_replace("(", "（", $str);
//        $str = str_replace(")", "）", $str);
//        $str = str_replace(",", "，", $str);
//        $str = str_replace(";", "；", $str);
        return $str;
    }
}