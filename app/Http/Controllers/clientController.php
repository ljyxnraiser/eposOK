<?php

namespace App\Http\Controllers;
//use  Illuminate\Http\Request;
use App\client_info;
use Request;
use DB;
use App\Http\Controllers\Controller;


class clientController extends Controller
{

    public function postRegister( ){
        $re=new client_info();
       // $re->postRegister();
        return $re->postRegister();
    }

    //插入数据
    public function SignUp(){
       $headerType= Request::header('type');//获得表头的一些数据
        $request=Request::all();
        //表头为种类确认
        if ($headerType=='signUp'){
            //$client_info=client_info::insert($request);
            $time=time();
            $client_info=new client_info();
            $client_info->client_id=substr($time,-5)*100+random_int(1,99)+pow(10,7)*8;
            $client_info->client_name=$request['client_name'];
            $client_info->client_passwd=$request['client_passwd'];
            $client_info->client_status=0;
            $client_info->client_sum=0;
            //$client_info->save();
            ///$client_info=client_info::create($request);
            //$client_info->created_at();
            $client_info->save();
           return $client_info;
        }else{return'失败了';}

    }
    public  function sec(){
        //$client_info=new client_info();
        //$client_info=client_info::all();
        $client_info=client_info::where('client_id',2)->update(['client_name'=>'23333']);
        $client_info=client_info::where('client_id',2)->get();
        return($client_info);
    }

}
