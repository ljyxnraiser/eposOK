<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Request;

class client_info extends Model
{
    protected $table ='client_info';
    protected $primaryKey='clent_id';

    public function postRegister( ){
        $request= Request::all();
        $client_name=$request['client_name'];
         return $client_name;
    }
}
