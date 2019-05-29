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
    /** Generate and store sms code in DB
     * @param $phone
     * @param $userId
     */
    public static function store($phone, $userId)
    {
        $input = [];
        $input['code'] = rand(1000, 9999);
        $input['phone'] = str_replace('+','',$phone);
        $input['user_id'] = $userId;
        SmsCode::create($input);
        SmsService::sendSms($input['code'],$input['phone'] = str_replace('+','',$phone));
    }

    /** Send sms using nexmo package
     * @param $code
     * @param $phone
     */
    public static function sendSms($code, $phone)
    {
        Nexmo::message()->send([
            'to'   => $phone,
            'from' => 'LiveLove',
            'text' => $code
        ]);
    }
}