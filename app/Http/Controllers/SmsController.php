<?php

namespace App\Http\Controllers;

use App\SmsCode;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    //
    public function store($phone,$userId)
    {
        $input = [];
        $input['code'] = rand(1000, 9999);
        $input['phone'] = $phone;
        $input['user_id'] = $userId;
        SmsCode::create($input);
        $this->sendSms($input['code']);
    }

    public function sendSms($code)
    {
        $basic  = new \Nexmo\Client\Credentials\Basic('1f76bd4e', 'TIIrPiQkTQ6kf9FN');
        $client = new \Nexmo\Client($basic);

        $message = $client->message()->send([
            'to' => '380672623783',
            'from' => 'Nexmo',
            'text' => 'Hello from Nexmo'
        ]);
    }

    public function getLastCode()
    {

    }
}
