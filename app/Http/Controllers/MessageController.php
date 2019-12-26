<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MessageService;
use Auth;
use Validator;


class MessageController extends Controller
{
    public function __construct()
    {
        $this->messageService = new MessageService();
    }

    // region send
    public function sendMessage(Request $request)
    {
        $postData = $request->all();
        $objValidator = Validator::make(
            $postData,
            [
                'content' => 'required|string|max:100'
            ],
            [
                'content.required' => '請輸入內容',
                'content.string' => '請輸入字串',
                'content.max' => '內容最多輸入100字元'
            ]
        );
        if ($objValidator->fails())
            return response()->json($objValidator->errors()->all(), 400, [], JSON_UNESCAPED_UNICODE);
        $result = $this->messageService->sendMessage($postData);
        return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
    }

    // region get
    public function getMessage(Request $request)
    {
        $result = $this->messageService->getMessage();
        return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
    }
    public function gePtt(Request $request)
    {
        $dd = $request->input('page');
        $python = 'C:\\Users\\\User\\AppData\\Local\\Programs\\Python\\Python38-32\\python.exe';
        $locale = 'de_DE.UTF-8';
        setlocale(LC_ALL, $locale);
        putenv('LC_ALL=' . $locale);
        $shell = "$python C:\Users\User\PhpstormProjects\messageBoard\public\python.py $dd 2>&1";
        $pythonPrint = shell_exec($shell);

        return $pythonPrint;
    }

}
