<?php

namespace App\Http\Controllers;

use App\SmsCode;
use Illuminate\Http\Request;
use Nexmo\Laravel\Facade\Nexmo;

class SmsController extends Controller
{
    //
    public function store($phone, $userId)
    {
        $input = [];
        $input['code'] = rand(1000, 9999);
        $input['phone'] = str_replace('+','',$phone);
        $input['user_id'] = $userId;
        SmsCode::create($input);
        $this->sendSms($input['code'],$input['phone'] = str_replace('+','',$phone));
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
