<?php
namespace app\admin\controller;
use think\Controller;
use think\captcha\Captcha;
use think\Session;
class User extends Controller {

    /**
     * 登录页面
    */
    public function index(){
        return $this->fetch();
    }

    public function singUp(){
//        $code = input('code');
//        $is_check_verify = $this->check_verify($code); //检查验证码
//        if(!$is_check_verify){
//            $return = ['code'=>1,'msg'=>'验证码错误','data'=>[]];
//            exit(json_encode($return));
//        }
//        $login_name = input('login_name');
        $phone = input('phone');
        $phoneCode = input('phoneCode');
        $type = input('type');

        $where  = [];
        $where['phone'] = $phone;
        $where['type']  = $type; //注册
        $where['is_shiyong'] = 2; //未使用
        $where['code'] = $phoneCode;
        $where['start_time'] = ['<',time()];
        $where['end_time'] = ['>',time()];
        $check_code = db('duanxin')->where($where)->find();

        //验证码是否正确
        if(!$check_code){
            $return = ['code'=>400,'msg'=>'验证码错误或超出有效期','data'=>[]];
            exit(json_encode($return));
        }

//        $pwd = $this->setEncryption($pwd);
        $res = db('user')
            ->where('phone','eq',$phone)
            ->where('is_lock','eq',0)
            ->find();
        if(count($res) > 0){
            $return = ['code'=>400,'msg'=>'此账号被冻结，请联系管理员','data'=>[]];
            exit(json_encode($return));
        }

        $res = db('user')
            ->where('phone','eq',$phone)
            ->find();

        if(count($res) > 0){
            //设置用户默认角色
            $role_id = $this->setDefaultRole(); //json
            if($role_id){
                db('user')
                    ->where('phone',$phone)
                    ->where('is_super','neq',1)
                    ->update(['role_id'=>$role_id]);
            }
            $res = db('user')
                ->where('phone','eq',$phone)
                ->find();

            $this->setUserInfo($res);

            $return = ['code'=>0,'msg'=>'成功','data'=>[]];
            exit(json_encode($return));
        }else{
            $return = ['code'=>1,'msg'=>'账号或密码错误','data'=>[]];
            exit(json_encode($return));
        }

    }

    //保存用户登录信息
    public function setUserInfo($userInfo){
        $userInfo = $userInfo;
        Session::set('userInfo',$userInfo);
    }

    public function setEncryption($param){
        return md5(md5($param));
    }

    /**
     *  获取验证码
     */
    public function getEntry(){
        $captcha = new Captcha();
        return  $captcha->entry();

    }

    public function check_verify($code, $id = ''){
        $code = input('code');
        $captcha = new Captcha();
        return $captcha->check($code,$id);
    }

    //退出登录
    public function clearUserInfo(){
        Session::delete('userInfo');
        $this->success('成功','User/index');
    }

    /**
     * 注册页面
    */
    public function registerView(){
        return $this->fetch();
    }

    public function registerAdd(){
        $add['phone'] = input('phone');
        $is_phone = db('user')->where('phone',$add['phone'])->find();
        if(count($is_phone) > 0){
            $return = ['code'=>400,'msg'=>'该手机号已注册','data'=>[]];
            exit(json_encode($return));
        }
        $add['school'] = input('school');
        $add['enrollment_time'] = input('enrollment_time'); //入学时间
        $add['organization1'] = input('organization1'); //组织1
        $add['organization2'] = input('organization2'); //组织2
        $add['pwd'] = input('pwd'); //密码
        $pwdr = input('pwdr');
        if($add['pwd'] != $pwdr){
            $return = ['code'=>400,'msg'=>'两次密码不一致','data'=>[]];
            exit(json_encode($return));
        }
        $add['pwd'] = md5(md5($add['pwd']));
        $add['user_name']  = input('user_name'); //昵称
        $add['add_time'] = time();
        $phoneCode = input('phoneCode');
        if(!$phoneCode){
            $return = ['code'=>400,'msg'=>'请输入验证码','data'=>[]];
            exit(json_encode($return));
        }

        $where  = [];
        $where['phone'] = $add['phone'];
        $where['type']  = 2; //注册
        $where['is_shiyong'] = 2; //未使用
        $where['code'] = $phoneCode;
        $where['start_time'] = ['<',time()];
        $where['end_time'] = ['>',time()];
        $check_code = db('duanxin')->where($where)->find();
        //验证码是否正确
        if(!$check_code){
            $return = ['code'=>400,'msg'=>'验证码错误或超出有效期','data'=>[]];
            exit(json_encode($return));
        }


        $res = db('user')->insert($add);
        if($res > 0){
            $return = ['code'=>0,'msg'=>'成功','data'=>[]];
            exit(json_encode($return));
        }else{
            $return = ['code'=>401,'msg'=>'失败','data'=>[]];
            exit(json_encode($return));
        }
    }


    //设置用户默认角色
    public function setDefaultRole(){
        $role_id = [];
        $role = db('role')->where('is_default_role',1)->select();
        if(!$role){
            return 0;
        }
        foreach ($role as $k=>$v){
            array_push($role_id,$v['id']);
        }
        return json_encode($role_id);
    }

    /**
     * 获取验证码
    */
    public function getPhoneCode(){
        $start_time = time();
        $end_time = time()+300;//有效时间5分钟
        $phone = input('phone');
        require_once (ROOT_PATH .'/logic/code.php');
        $code = new \code();
        $code = $code->numberCode();
        $type = input('type');//type:2 注册  1：登录
        $add_time = time();
        if(!$phone){
            $return = ['code'=>401,'msg'=>'手机号错误','data'=>[]];
            exit(json_encode($return));
        }
        if(!$code){
            $return = ['code'=>401,'msg'=>'生成验证码失败','data'=>[]];
            exit(json_encode($return));
        }
        //清除上次注册发送的验证码
        $clear = db('duanxin')->where('phone',$phone)->where('type',2)->update(['is_shiyong'=>1]);
        $add = db('duanxin')
            ->insert(['phone'=>$phone,
                'code'=>$code,'type'=>$type,
                'add_time'=>$add_time,
                'start_time'=>$start_time,
                'end_time'=>$end_time
            ]);

        if(!$add){
            $return = ['code'=>401,'msg'=>'插入数据库失败','data'=>[]];
            exit(json_encode($return));
        }
        require_once (ROOT_PATH .'/server/Ali/AlibabaCloudMes.php');
        $AliMes = new \AlibabaCloudMes();
        $AliMes->sendSms($phone,$code,'register'); //用户注册-发送短信
        $res = $AliMes->getRes();
        if($res["Code"]=='OK'){
            $return = ['code'=>0,'msg'=>'发送成功','data'=>$res];
            exit(json_encode($return));
        }else{
            $return = ['code'=>401,'msg'=>'发送失败','data'=>$res];
            exit(json_encode($return));
        }

    }

}