<?php

namespace App\Controller;

use Col\Common\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        header("Pragma: no-cache");
        header("Cache-Control: no-cache");
        echo '';
    }

    public function profile()
    {
        if (!$this->is_login()) {
            return redirect('/user/login');
        }

        $name = session()->get('name');
        $group = session()->get('group');

        switch ($group) {
            case self::USER_VISITOR['name']:
                $explains = DB('explains')->where('username', $name)->select('user_from, user_to, content, qq, phone, effect, bg, anonymous, hide, created_time')->order('created_time desc');
                break;
            case self::USER_CONTRIBUTOR['name']:
                break;
            case self::USER_ADMINISTRATOR['name']:
                $explains = DB('explains')->order('created_time desc');
                break;
            default:
                return redirect('/user/login');
                break;
        }

        view('user/profile', [
            'title'    => $name,
            'explains' => $explains,
        ]);
    }

    public function login()
    {
        if ($this->is_login()) {
            return redirect('/user/profile');
        }

        view('user/login');
    }

    public function logout()
    {
        if ($this->is_login()) {
            session_unset();
            session()->reset(1);
        }

        sleep(1);  // 敲尼玛，强行+1s
        redirect('/user/login');
    }

    public static function register($username, $group)
    {
        $count = DB('users')->where('username', $username)->count();
        if ($count >= 1) {
            return false;
        }

        $now = time();
        $passwd = Hash::make('12345678');
        $data = [
            'username'     => $username,
            'password'     => $passwd,
            'ip'           => get_client_ip(),
            'logged_time'  => $now,
            'created_time' => $now,
            'updated_time' => $now,
            'faction'      => $group,
        ];
        DB('users')->insert($data);
        return true;
    }

    private function is_login()
    {
        return session()->get('is_login') ? true : false;
    }
}