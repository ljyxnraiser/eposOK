<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;//链接数据库用的类
class UserModel extends Model
{
public  function  UserM(){
    $shuju=DB::table('user')->get();//获取数据库
    return $shuju;//print（）；json
}
}
