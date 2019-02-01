<?php

namespace App\Http\Controllers;

use App\UserModel;
use Illuminate\Http\Request;

use App\Http\Requests;

class userController extends Controller
{
    public function User ()
    {
        $userm = new UserModel();
        return $userm->UserM();
    }
    //获取网络传输过来的数据
    public function GetUrl(Request $request){
       $input= $request->get('key');
    return $input;
    }
}
