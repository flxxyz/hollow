<?php

namespace App\Controller;

use Col\Common\Hash;

class UserController extends Controller
{
    public function profile()
    {
        $title = session()->get('name');
        view('user/profile', [
            'title' => $title,
        ]);
    }

    public function login()
    {
        view('user/login');
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
}