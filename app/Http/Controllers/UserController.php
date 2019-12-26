<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;

class UserController extends Controller
{

    public function __construct()
    {
        $this->userService = new UserService();
    }

    //region 註冊
    public function register(Request $request)
    {
        $postData = $request->all();
        $objValidator = Validator::make(
            $postData,
            [
                'account' => [
                    'required',
                    'between:6,20',
                    'regex:/^(([a-z]+[0-9]+)|([0-9]+[a-z]+))[a-z0-9]*$/i',
                    'unique:users'
                ],
                'password' => [
                    'required',
                    'between:6,20',
                    'regex:/^(([a-z]+[0-9]+)|([0-9]+[a-z]+))[a-z0-9]*$/i'
                ],

            ],
            [
                'account.required' => '請輸入帳號',
                'account.between' => '帳號需介於6-20字元',
                'account.regex' => '帳號需包含英文數字',
                'account.unique' => '帳號已存在',
                'password.required' => '請輸入密碼',
                'password.between' => '密碼需介於 6-20 字元',
                'password.regex' => '密碼需包含英文數字',
            ]
        );
        if ($objValidator->fails())
            return response()->json($objValidator->errors()->all(), 400, [], JSON_UNESCAPED_UNICODE);
        $result = $this->userService->register($postData);
        if (is_string($result))
            return response()->json($result, 400, [], JSON_UNESCAPED_UNICODE);
        return response()->json(JWTAuth::fromUser($result), 200, [], JSON_UNESCAPED_UNICODE);
    }
    //endregion

    // region 登入
    public function login(Request $request)
    {
        $postData = $request->only('account', 'password');
        $objValidator = Validator::make(
            $postData,
            [
                'account' => 'required',
                'password' => 'required'
            ],
            [
                'account.required' => '請輸入帳號',
                'password.required' => '請輸入密碼'
            ]
        );
        if ($objValidator->fails())
            return response()->json($objValidator->errors()->all(), 400, [], JSON_UNESCAPED_UNICODE);
        $result = $this->userService->login($postData);
        if (is_string($result))
            return response()->json($result, 400, [], JSON_UNESCAPED_UNICODE);
        return response()->json(JWTAuth::fromUser($result), 200, [], JSON_UNESCAPED_UNICODE);
    }
    //endregion

}
