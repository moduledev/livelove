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
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, "https://rest.nexmo.com/sms/json");
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS,
        //     "from=Nexmo&text={$code}&to={$phone}&api_key=50a3c5e7&api_secret=Umv48BTlbxT0QVO9");
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_exec($ch);
        // curl_close($ch);

        Nexmo::message()->send([
            'to'   => $phone,
            'from' => 'LiveLove',
            'text' => $code
        ]);

        // Authorisation details.
//        $username = "bayduzh89@gmail.com";
//        $hash = "1021dd72b9a73a89408b6b2914cd24a5899e25c9da5092d4d310b62253b0a276";
//
//        // Config variables. Consult http://api.txtlocal.com/docs for more info.
//        $test = "0";
//
//        // Data for text message. This is the text message data.
//        $sender = "API Test"; // This is who the message appears to be from.
//        $numbers = "44777000000"; // A single number or a comma-seperated list of numbers
//        $message = "This is a test message from the PHP API script.";
//        // 612 chars or less
//        // A single number or a comma-seperated list of numbers
//        $message = urlencode($message);
//        $data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers="."380985594949"."&test=".$test;
//        $ch = curl_init('http://api.txtlocal.com/send/?');
//        curl_setopt($ch, CURLOPT_POST, true);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        $result = curl_exec($ch); // This is the result from the API
//        curl_close($ch);
//
//        // Process your response here
//        echo $result;

    }

}
