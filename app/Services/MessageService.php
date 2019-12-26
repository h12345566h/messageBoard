<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2019/12/11
 * Time: 上午 06:36
 */

namespace App\Services;

use App\Message as MessageEloquent;

class MessageService
{
    public function sendMessage($postData)
    {
        $data['account'] = $postData['account'];
        $data['content'] = $postData['content'];
        return MessageEloquent::create($data);
    }

    public function getMessage()
    {
            $message = MessageEloquent::orderByDesc('created_at')->get();
            return $message;
    }

}