<?php
namespace app\api\controller;
class WxUser extends Base{
    private $APPID = 'wx864aa06d56447126';
    private $SECRET = 'e3b041b56b4a9edca7d95240ec183507';
    //获取opneid
    public function getOpenid(){
        $code = input('code');//获取code
        if(!$code){
            $this->ajaxReturn([],400,'code错误',false);
        }
        //通过code换取网页授权access_token
        $weixin =  file_get_contents("https://api.weixin.qq.com/sns/jscode2session?appid=$this->APPID&secret=$this->SECRET&js_code=$code&grant_type=authorization_code");

        $jsondecode = json_decode($weixin); //对JSON格式的字符串进行编码
        $array = get_object_vars($jsondecode);//转换成数组
        $openid = $array['openid'];//输出openid
        if(!$openid){
            $this->ajaxReturn($array,400,'获取openid错误',false);
        }

        //保存用户信息
        $set_user = $this->wxUser($openid);
        if(!$set_user){
            $this->ajaxReturn([],400,'保存用户信息失败',false);
        }

        $this->ajaxReturn(['openid'=>$openid]);
    }

    //保存微信用户信息
    public function WxUser($openid){
        $is_user = db('wx_user')->where('openid',$openid)->find();
        if($is_user){
            return true;
        }
        $data = ['openid'=>$openid,'add_time'=>time()];
        $res = db('wx_user')->insert($data);
        return $res > 0 ? true : false;
    }

    //获取微信用户信息
    public function getWxUser(){
        $openid = input('openid');
        if(!$openid){
            $this->ajaxReturn([],401,'openid错误',false);
        }
        $wx_user = db('wx_user')->where('openid',$openid)->find();
        $this->ajaxReturn($wx_user);
    }
}