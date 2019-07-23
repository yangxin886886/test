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
        $code = input('code');
        $is_check_verify = $this->check_verify($code); //检查验证码
        if(!$is_check_verify){
            $return = ['code'=>1,'msg'=>'验证码错误','data'=>[]];
            exit(json_encode($return));
        }
//        $login_name = input('login_name');
        $phone = input('phone');
        $pwd = input('pwd');
        if(empty($user_name) && empty($pwd)){
            $return = ['code'=>1,'msg'=>'参数不能为空','data'=>[]];
            exit(json_encode($return));
        }

        $pwd = $this->setEncryption($pwd);

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
            ->where('pwd','eq',$pwd)
            ->find();

        if(count($res) > 0){
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
        $res = db('user')->insert($add);
        if($res > 0){
            $return = ['code'=>0,'msg'=>'成功','data'=>[]];
            exit(json_encode($return));
        }else{
            $return = ['code'=>401,'msg'=>'失败','data'=>[]];
            exit(json_encode($return));
        }
    }

}