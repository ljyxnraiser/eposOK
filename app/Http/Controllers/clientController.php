<?php

namespace App\Http\Controllers;
//use  Illuminate\Http\Request;
use App\client_info;
use Request;
use App\Http\Controllers\Controller;

class clientController extends Controller
{

    public function postRegister( ){
        $re=new client_info();
       // $re->postRegister();
        return $re->postRegister();


    }

}
