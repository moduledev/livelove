<?php

namespace App\Http\Controllers;

use App\SmsCode;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    //
    public function store($phone, $userId)
    {
        $input = [];
        $input['code'] = rand(1000, 9999);
        $input['phone'] = $phone;
        $input['user_id'] = $userId;
        SmsCode::create($input);
        $this->sendSms($input['code'],$input['phone'] = $phone);
    }

    public function sendSms($code,$phone)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://rest.nexmo.com/sms/json");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            "from=Nexmo&text={$code}&to={$phone}&api_key=1f76bd4e&api_secret=TIIrPiQkTQ6kf9FN");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }

    public function getLastCode()
    {

    }
}
