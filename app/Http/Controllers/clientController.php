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
    public function SignUp()
    {
       $headerType= Request::header('type');//获得表头的一些数据
        $request=Request::all();
        //表头为种类确认
        if ($headerType=='signUp')
        {
            $repeatBool=DB::table('client_info') //查找表中是否已存在用户名
                ->where('client_name','=',$request['client_name'])
                ->get();
            $repeatBool=(int)$repeatBool; //返回值转换为int类型，做判断使用； 0：查找不到 1：查找到
                if ($repeatBool == 0){
                $time = time();
                $client_info = new client_info();
                $client_info->client_id = substr($time, -5) * 100 +random_int(1, 99)+ pow(10, 7) ;
                $client_info->client_name = $request['client_name'];
                $client_info->client_passwd = $request['client_passwd'];
                $client_info->client_status = 0;
                $client_info->client_sum = 0;
                //$client_info->save();
                //$client_info=client_info::create($request);
                //$client_info->created_at();
                $client_info->save();
                return '注册成功';
               }if($repeatBool == 1){return '用户名已存在';}
        }
        else{return'注册失败';}
    }

    public function SignIn()
    {
        $headerType= Request::header('type');//获得表头的一些数据
        $request=Request::all();
        if ($headerType=='signIn')
        {
            $statusBool=DB::table('client_info')
                ->where('client_name','=',$request['client_name'])
                ->where('client_passwd',$request['client_passwd'])
                ->update(['client_status'=>1]);
            return $statusBool;
        }
        //var_dump($request)  ;
        if($headerType!='signIn')
        {return '登陆失败';}

    }

    public function SignOut(){
        $headerType= Request::header('type');//获得表头的一些数据
        $request=Request::all();
        if ($headerType=='signOut'){
            $status=DB::table('client_info')
                ->where('client_name','=',$request['client_name'])
                ->where('client_passwd',$request['client_passwd'])
                ->where('client_status','=',1)
                ->update(['client_status'=>0]);
            return $status;
        }
    }
    //验证用户返回数据
    public function VerifyClient(){
        $headerType= Request::header('type');//获得表头的一些数据
        $request=Request::all();
        if ($headerType=='Verify'){
            $clientData=DB::table('client_info')
                ->where('client_name','=',$request['client_name'])
                ->where('client_passwd',$request['client_passwd'])
                ->where('client_status','=',1)
                ->get();
            return $clientData;
        }

    }

    //修改密码
    public function ChangePassword(){
        $headerType= Request::header('type');//获得表头的一些数据
        $request=Request::all();
        if ($headerType=='changePasswd'){
            $changePW=DB::table('client_info')
                ->where('client_name','=',$request['client_name'])
                ->where('client_status','=',1)
                ->update('client_passwd',$request['client_passwd']);
            return $changePW;
        }
    }
    //充值
    public function ChargeMoney(){
        $headerType= Request::header('type');//获得表头的一些数据
        $request=Request::all();
        if ($headerType=='Charge'){
            $clientSum=DB::table('client_info')
                ->where('client_name','=',$request['client_name'])
                ->where('client_passwd',$request['client_passwd'])
                ->where('client_status','=',1)
                ->update(['client_sum'=>$request['client_sum']]);
            return $clientSum;
        }
    }

    //购买

    /**
     * @return string
     * @throws \Exception
     */
    public  function  Buy()
    {
        $headerType = Request::header('type');//获得表头的一些数据
        $request = Request::all();
        if ($headerType == 'Buy')          //如果type是buy，从表中查找选择用户余额
        {
            $clientSum = DB::table('client_info')
                ->where('client_name', '=', $request['client_name'])
                ->where('client_passwd', $request['client_passwd'])
                ->where('client_status', '=', 1)
                ->value('client_sum');
            $clientPay = $request['client_pay'];  //需支付的金额
            $clientSumFloat = (float)$clientSum - (float)$clientPay;  //现有额度
            if ($clientSumFloat >= 0)   //如果现有额度大于等于0，更新用户余额
            {
                $clientSumBool = DB::table('client_info')
                    ->where('client_name', '=', $request['client_name'])
                    ->where('client_passwd', $request['client_passwd'])
                    ->where('client_status', '=', 1)
                    ->update(['client_sum' => $clientSumFloat]);
                if ($clientSumBool == 1)   //如果返回1，数据更新成功
                {
                    //支付完毕后
                    //创建menu_personal一条数据
                    //创建menu_id填入shop_id,client_id,creat_at
                    //(^10)__ 1557324200+99+4^10+4*10^10
                    $menu_id=substr(time(), -2)*100+random_int(1, 99)+pow(10, 10)*4;
                    //client_id
                    $client_id=DB::table('client_info')
                        ->where('client_name', $request['client_name'])
                        ->where('client_passwd', $request['client_passwd'])
                        ->where('client_status', '=', 1)
                        ->pluck('client_id');

                    //连接menu_personal数据插入
                    $menu_personal_bool=DB::table('menu_personal')
                        ->insert(
                            [
                                'menu_id'=>$menu_id,
                                'shop_id'=>(int)$request['shop_id'],
                                'client_id'=>$client_id[0],
                                'created_at'=>date("Y-m-d H:i:s",time()),
                                'menu_status'=>0

                            ]);
                    if($menu_personal_bool==1){
                        //创建成功
                            //返回给unity[menu_id,created_at]
                        $menu_personal_id_time=DB::table('menu_personal')
                            ->where('menu_id',$menu_id )
                            ->select('menu_id','created_at')
                        ->get();
                        return $menu_personal_id_time;
                    }
                    else{
                        return "系统错误";
                    }

                    //创建menu_info，n个数据
                        //创建menu_index,填入上面menu_id，获取dish_id,dish_num，填入creat_at
                   // return $clientSumFloat;
                } else {
                    return "false";   //否则更新失败
                }
            }
            else {
                return "sum_not_enough";    //否则将报错，提示余额不足
            }
        }
    }
    //结算完毕以后插入菜品和数量到menu_info数据中
    public function Insert2MenuInfo(){
        $headerType= Request::header('type');//获得表头的一些数据
        $request=Request::all();
        if ($headerType=='Menuinfo'){
            $clientSum=DB::table('menu_personal')
                ->where('menu_id',$request['menu_id'])
                ->where('created_at',$request['created_at'])
                ->update(['updated_at'=>date("Y-m-d H:i:s",time())]);

            if ($clientSum==1){
                /*foreach ($request as $key=>$onef){
                var_dump($request);
                }*/
                $requestA= array_values($request);//使数组key变为从零排序
                $dishNumArr=$requestA[2];//第三个数组提出来作为新的数组
                $allArr[]=array();
                for ($i=0;$i<count($dishNumArr);$i++ ){
                    $menu_index=substr(time(), -2)*100+random_int(1, 99)+pow(10, 10)*5;
                    $arr[]=array(
                        'menu_index'=>(string)$menu_index,
                        'menu_id'=>(string)$request['menu_id'],
                        'dish_id'=>(int)$dishNumArr[$i]['dish_id'],
                        'dish_num'=>(int)$dishNumArr[$i]['dish_num'],
                        'created_at'=>date("Y-m-d H:i:s",time()),

                    );
                    array_push($allArr,$arr);
                    array_shift($allArr);

                }
                //return $allArr;
               // var_dump($allArr);

               /* $arrA=[[
                    'menu_index'=>(string)(substr(time(), -2)*100+random_int(1, 99)+pow(10, 10)*5),
                    'menu_id'=>$request['menu_id'],
                    'dish_id'=>(int)$request['dish_id'],
                    'dish_num'=>(int)$request['dish_num'],
                    'created_at'=>date("Y-m-d H:i:s",time())
                    ],
                [
                    'menu_index'=>(string)((substr(time(), -2)*100+random_int(1, 99)+pow(10, 10)*5)+1),
                    'menu_id'=>$request['menu_id'],
                    'dish_id'=>(int)$request['dish_id'],
                    'dish_num'=>(int)$request['dish_num'],
                    'created_at'=>date("Y-m-d H:i:s",time())
                ]];*/
                var_dump($allArr);
                //return $allArr;
               // echo($allArr) ;
                //$allArr[]=array($allArr);
                $clientSum=DB::table('menu_info')
                    ->insert($allArr[0]);//zz必须加插入数组第一个元素[0]
                echo $clientSum;

            }else{return"没有更新成功";}

            return "sd";
        }else{return 213213;}
    }
}
