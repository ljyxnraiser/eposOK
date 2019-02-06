<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Validator;
use Request;

class client_info extends Model
{
    protected $table ='client_info';//数据表名称
    protected $primaryKey='clent_id';//主键
   // protected  $fillable=['client_id','client_name','client_passwd','client_status','client_sum'];

    public function postRegister( ){
        $request= Request::all();
        $jsondata='{"d":"dfdf"}';
      // $arr=json_decode('\''.$request,true.'\'');
        //$client_name=$request['client_name'];
        $pp=Request::ip();
        $header=Request::header();
        //var_dump($request)   ;
    }
}
