<?php

namespace App\Controller;

use Col\Common\Hash;

/**
 * 提供主要api类
 * Class ApiController
 * @package App\Controller
 */
class ApiController extends Controller
{
    /**
     * 发布表白api
     */
    public function say()
    {
        $ip = get_client_ip();
        // ip限制

        $body = $this->post();

        /**
         * // 暂时关闭phone字段
         * if (!$body['phone']) {
         * $body['phone'] = null;
         * }
         */

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

        /**
         * 处理可能有相同hash情况
         */
        if(DB('explains')->where('hash', $body['hash'])->count() > 0) {
            $hash_str = hash('crc32', $body['from'] . $this->config['key'] . $now . mt_rand(1001, 9999) . $body['to']);
            $body['hash'] = $hash_str;
        }

        /**
         * 添加表白项
         */
        $result = DB('explains')->insert($body);

        /**
         * 添加当前点赞记录
         */
        DB('likes')->insert([
            'explain_id' => $result['id'],
        ]);
        if (!is_null($body['qq'])) {
            // 写入游客账户
            UserController::register($body['qq'], UserController::USER_VISITOR['name']);
        }

        $hash = $result['hash'];
        $data = [
            'id'      => $hash,  // 表白唯一id
            'url'     => $this->config['url'] . 's/' . $hash,  // 表白链接
            'manager' => '',  // 预留
        ];
        $this->json('发布成功！', $data);
    }

    /**
     * 发布评论api
     */
    public function comment()
    {
        $ip = get_client_ip();
        // ip限制

        $body = $this->post();

        /**
         * 判断id有效
         */
        $count = DB('explains')->where('hash', $body['id'])->count();
        if ($count <= 0) {
            $this->json('传递错误的参数', '', 100);
        }

        /**
         * 取出当前表白
         */
        $explain = DB('explains')->where('hash', $body['id'])->select('id')->fetch();
        $body['explain_id'] = $explain['id'];
        unset($body['id']);

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

        /**
         * 写入评论
         */
        DB('comments')->insert($body);

        /**
         * 取出评论树
         */
        $comment = DB('comments')->where('explain_id', $explain['id'])->order('created_time asc');
        $new_comment = [];
        foreach ($comment as $item) {
            /**
             * 构造新评论表
             */
            $new_comment[$item['pid']][] = [
                'id'         => $item['id'],
                'explain_id' => $item['explain_id'],
                'pid'        => $item['pid'],
                'name'       => $item['name'],
                'content'    => $item['content'],
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
        /**
         * 父子评论
         */
        foreach ($comment as $item) {
            /**
             * 父评论性别
             */
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

            /**
             * 取子评论
             */
            $children = '';
            if (isset($item['children']) && count($item['children']) > 0) {
                $children .= '<hr class="border-small border-bottom"><ul>';
                foreach ($item['children'] as $k => $v) {
                    /**
                     * 子评论性别
                     */
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
                    /**
                     * 最后一条子评论不输出下横线
                     */
                    $border = ($k != (count($item['children']) - 1)) ? 'border-small border-bottom' : '';
                    /**
                     * 构造子评论结构
                     */
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
                    unset($sex_color_item, $sex_icon_item, $border);
                }
                $children .= '</ul>';
            }

            /**
             * 构造父评论结构
             */
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
            unset($sex_color, $sex_icon, $children, $item);
        }

        $this->json('评论成功', $data);
    }

    /**
     * 登录api
     */
    public function login()
    {
        $body = $this->post();

        $username = $body['username'];
        $password = $body['password'];

        /**
         * 验证账户存在
         */
        $users = DB('users');
        if ($users->where('username', $username)->count() <= 0) {
            if ($users->where('phone', $username)->count() <= 0) {
                $this->json('对不起，账户不存在', '', 100);
            } else {
                $user = $users->where('phone', $username)->fetch();
            }
        } else {
            $user = $users->where('username', $username)->fetch();
        }
        unset($users);

        /**
         * 验证密码正确
         */
        if (!Hash::check($password, $user['password'])) {
            $this->json('对不起，密码不正确', '', 100);
        }

        /**
         * 设置登录相关信息
         */
        session()->set(['is_login' => 1]);
        session()->set(['id' => $user['uid']]);
        session()->set(['name' => $user['username']]);

        /**
         * 更新登录时间
         */
        $result = DB('users')->where('username', $username)->update(['logged_time' => time()]);
        if (is_numeric($result)) {
            $this->json('登陆成功', [
                'url' => "/user/profile",
            ]);
        } else {
            $this->json('登陆失败', '', 500);
        }
    }

    /**
     * 通用post
     * @return array
     */
    private function post()
    {
        $request = $this->request();
        if ($request->method == 'GET') {
            $this->json('error', '', 100);
        }

        $body = $request->body;
        foreach ($body as $key => $value) {
            // 剔除sql关键字,html标签
            $body[$key] = $this->clear_sql(htmlspecialchars(strip_tags($value)));
        }

        return $body;
    }

    /**
     * 清洗字符串
     * @param $str
     * @return mixed
     */
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