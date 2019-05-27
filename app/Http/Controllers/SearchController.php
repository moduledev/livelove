<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /** Search user by phone or name
     * @param Request $request
     * @return mixed
     */
    public function search(Request $request)
    {
        $q = Input::get('q');
        $user = User::where('name', 'LIKE', '%' . $q . '%')->orWhere('phone', 'LIKE', '%' . $q . '%')->get();
        if (count($user) > 0) return view('admin.content.search')->withDetails($user)->withQuery($q);
        else return view('admin.content.search')->withErrors(['search','По запросу '. $q .' ничего не найдело!']);
    }
}
