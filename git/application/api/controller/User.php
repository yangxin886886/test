<?php
namespace app\api\controller;
class User extends Base{

    /**
     * 获取验证码--验证码有效时间5分钟
     */
    public function getPhoneCode(){
        $start_time = time();
        $end_time = time() + 300;//有效时间5分钟
        $phone = input('phone');

        //生成验证码
        require_once (ROOT_PATH .'/logic/code.php');
        $code = new \code();
        $code = $code->numberCode();

        $type = input('type');//type:2 注册  1：登录
        $add_time = time();
        if(!$phone){
            $this->ajaxReturn([],401,'手机号错误',false);
        }
        if(!$code){
            $this->ajaxReturn([],401,'生成验证码失败',false);
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
            $this->ajaxReturn([],401,'插入数据库失败',false);
        }

        //发送短信
        require_once (ROOT_PATH .'/server/Ali/AlibabaCloudMes.php');
        $AliMes = new \AlibabaCloudMes();
        $AliMes->sendSms($phone,$code,'register'); //用户注册-发送短信

        $res = $AliMes->getRes();
        if($res["Code"]=='OK'){
            $this->ajaxReturn($res,200,'发送成功',true);
        }else{
            $this->ajaxReturn($res,401,'发送失败',false);
        }

    }

    //登录
    public function singUp(){
        $phone = input('phone');
        $phoneCode = input('phoneCode');
        $type = 1; //type:2 注册  1：登录

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
            $this->ajaxReturn([],401,'验证码错误或超出有效期',false);
        }

//        $pwd = $this->setEncryption($pwd);
        $res = db('user')
            ->where('phone','eq',$phone)
            ->where('is_lock','eq',0)
            ->find();
        if(count($res) > 0){
            $this->ajaxReturn([],401,'此账号被冻结，请联系管理员',false);
        }

        //用户信息
        $res = db('user')
            ->where('phone','eq',$phone)
            ->find();

        if(count($res) > 0){
            $this->ajaxReturn($res,200,'成功',true);
        }else{
            $this->ajaxReturn([],401,'账号不存在',false);
        }

    }


    //用户注册
    public function registerAdd(){
        $add['phone'] = input('phone');
        $add['school'] = input('school');
        $add['enrollment_time'] = input('enrollment_time'); //入学时间
        $add['organization1'] = input('organization1'); //组织1
        $add['organization2'] = input('organization2'); //组织2
        $add['pwd'] = input('pwd'); //密码
        $add['pwd'] = md5(md5($add['pwd']));
//        $add['user_name']  = input('user_name'); //昵称
        $add['add_time'] = time();
        $phoneCode = input('phoneCode'); //手机验证码
        if(!$add['phone']){
            $this->ajaxReturn([],401,'手机号不正确',false);
        }

        $is_phone = db('user')->where('phone',$add['phone'])->find();
        if(!$add['school']){
            $this->ajaxReturn([],401,'请输入学校及校区名称',false);
        }

        if(!$phoneCode){
            $this->ajaxReturn([],401,'请输入验证码',false);
        }
        if(count($is_phone) > 0){
            $this->ajaxReturn([],401,'该手机号已注册',false);
        }
//        $pwdr = input('pwdr');
//        if($add['pwd'] != $pwdr){
//            $return = ['code'=>400,'msg'=>'两次密码不一致','data'=>[]];
//            exit(json_encode($return));
//        }



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
            $this->ajaxReturn([],401,'验证码错误或超出有效期',false);
        }

        $res = db('user')->insert($add);
        if($res > 0){
            $this->ajaxReturn([],200,'成功',true);
        }else{
            $this->ajaxReturn([],401,'失败',false);
        }
    }
}