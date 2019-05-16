<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 016 16.05.19
 * Time: 9:49
 */

namespace App\SmsService;


use App\SmsCode;
use Nexmo\Laravel\Facade\Nexmo;

class SmsService
{
    public static function store($phone, $userId)
    {
        $input = [];
        $input['code'] = rand(1000, 9999);
        $input['phone'] = str_replace('+','',$phone);
        $input['user_id'] = $userId;
        SmsCode::create($input);
//        $this->sendSms($input['code'],$input['phone'] = str_replace('+','',$phone));
    }

    public function sendSms($code,$phone)
    {
        Nexmo::message()->send([
            'to'   => $phone,
            'from' => 'LiveLove',
            'text' => $code
        ]);
    }
}