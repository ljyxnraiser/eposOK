<?php

namespace App\Http\Controllers;

use App\client_info;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class clientController extends Controller
{
    public  function clientLogon(){
        $client_info=new client_info();
      return  $client_info['client_id'];

    }
}
