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
    }
}
