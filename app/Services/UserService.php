<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2019/12/11
 * Time: 上午 06:33
 */

namespace App\Services;

use App\User as UserEloquent;
use Hash;


class UserService
{

    public function register($postData)
    {
        $postData['password'] = bcrypt($postData['password']);
        return UserEloquent::create($postData);
    }

    public function login($postData)
    {
        $user = UserEloquent::find($postData['account']);
        if ($user) {
            if (Hash::check($postData['password'], $user->password)) {
                return $user;
            }
            return '密碼錯誤';
        }
        return '無此帳號請去註冊';
    }

}