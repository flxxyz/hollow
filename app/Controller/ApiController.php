<?php

namespace App\Controller;

class ApiController extends Controller
{
    public function say()
    {
        $request = $this->request();
        if ($request->method == 'GET') {
            $this->json('error', '', 100);
        }

        $ip = get_client_ip();
        // ip限制

        $body = $request->body;
        foreach ($body as $key => $value) {
            $body[$key] = $this->clear_sql(htmlspecialchars(strip_tags($value)));
        }

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
            'explain_id' => $result->insert_id(),
        ]);
        $hash = $result['hash'];
        $data = [
            'id'      => $hash,
            'url'     => $this->config['url'] . 's/' . $hash,
            'manager' => '',
        ];
        $this->json('发布成功！', $data);
    }

    private function clear_sql($str)
    {
        $str = str_replace("and", "", $str);
        $str = str_replace("execute", "", $str);
        $str = str_replace("update", "", $str);
        $str = str_replace("count", "", $str);
        $str = str_replace("chr", "", $str);
        $str = str_replace("mid", "", $str);
        $str = str_replace("master", "", $str);
        $str = str_replace("truncate", "", $str);
        $str = str_replace("char", "", $str);
        $str = str_replace("declare", "", $str);
        $str = str_replace("select", "", $str);
        $str = str_replace("create", "", $str);
        $str = str_replace("delete", "", $str);
        $str = str_replace("insert", "", $str);
        $str = str_replace("alert", "", $str);
        $str = str_replace("drop", "", $str);
        $str = str_replace("console", "", $str);
        $str = str_replace("log", "", $str);
        $str = str_replace("'", "", $str);
        $str = str_replace('"', "", $str);
        $str = str_replace("or", "", $str);
        $str = str_replace("=", "", $str);
        $str = str_replace("/", "", $str);
        $str = str_replace("\\", "", $str);
        $str = str_replace(" ", "", $str);
        $str = str_replace("&nbsp;", "", $str);
        $str = str_replace("&quot;", "", $str);
        $str = str_replace("&quot;", "", $str);
        $str = str_replace("(", "（", $str);
        $str = str_replace(")", "）", $str);
        $str = str_replace(",", "，", $str);
        $str = str_replace(";", "；", $str);
        return $str;
    }
}