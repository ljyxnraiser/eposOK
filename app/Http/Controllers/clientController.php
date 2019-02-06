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
    //生成唯一标识ID
    public function uniqIDfunction(){
      uniqid(microtime());

    }
    //插入数据
    public function SignUp(){
       $headerType= Request::header('type');//获得表头的一些数据
        $request=Request::all();
        //表头为种类确认
        if ($headerType=='signUp'){
            //$client_info=client_info::insert($request);
            $client_info=new client_info();
            $client_info->client_name=$request['client_name'];
            $client_info->client_passwd=$request['client_passwd'];
            $client_info->save();
            ///$client_info=client_info::create($request);
            //$client_info->created_at();
            //$client_info->save();
           echo $client_info;
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
