<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class client_info extends Model
{
    protected $table ='client_info';
    protected $primaryKey='clent_id';

    public function postRegister(Request $request){
        $client_info=$request->get('client_info');

    }
}
