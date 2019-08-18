<?php
namespace app\api\controller;
//用户选座
class XuanZuo extends Base{
    //用户选座
    public function userSeat(){
        $activity_id = input('activity_id');
        $code = input('code');
        $venue_id = input('venue_id');
        $area = input('area');
        $pai = input('pai');
        $seat_num = input('seat_num');
        $reserve_type = 2;//微信用户选座
        $openid  = input('openid');
        if(!$activity_id){
            $this->ajaxReturn([],401,'活动id错误',false);
        }
        if(!$code){
            $this->ajaxReturn([],401,'请填写验证码',false);
        }
        if(!$venue_id){
            $this->ajaxReturn([],401,'venue_id错误',false);
        }
        if(!$area){
            $this->ajaxReturn([],401,'area错误',false);
        }
        if(!$pai){
            $this->ajaxReturn([],401,'排错误',false);
        }
        if(!$seat_num ){
            $this->ajaxReturn([],401,'座位编号错误',false);
        }
        if(!$openid){
            $this->ajaxReturn([],401,'openid错误',false);
        }

        //判断活动是否开始选座了
        $current_time = date("Y-m-d H:i:s");
        $is_time_where['id'] = $activity_id;
        $is_time_where['x_start_time'] = ['<= time',$current_time];
        $is_time_where['x_end_time'] = ['>= time',$current_time];
        $is_start_xuan = db('activity')
            ->where($is_time_where)
            ->find();
        if(!$is_start_xuan){
            $this->ajaxReturn([],400,'该活动还未开始选座位',false);
        }

        //某个活动用户最多选两个座位----------start
        $is_xuan_zuo = db('reserve')
            ->where('activity_id',$activity_id)
            ->where('openid',$openid)
            ->count();
        if($is_xuan_zuo>=2){
            $this->ajaxReturn([],400,'一个用户最多选择两个座位',false);
        }
        //某个活动用户最多选两个座位----------end

        //判断该活动的验证码是否被使用
        $is_code = db('code')
            ->where('activity_id',$activity_id)
            ->where('code',$code)
            ->where('is_user',1)
            ->find();
        if($is_code){
            $this->ajaxReturn([],400,'该验证码已经被使用了',false);
        }

        //判断该验证码是普通验证码还是vip验证码--再判断本次活动该座位的区域是否是vip区域
        $level = $is_code['level']; //1:普通验证码 2：vip验证码
        $is_vip_area = db('set_vip_area')
            ->where('activity_id',$activity_id)
            ->where('area',$area)
            ->find();
        if($level == 1 && $is_vip_area){
            $this->ajaxReturn([],400,'普通验证码无法选择vip区域',false);
        }

        //用户选座---先判断该活动的座位是否被选
        $where = [];
        $where['activity_id'] = $activity_id;
        $where['area'] = $area;
        $where['pai'] = $pai;
        $where['seat_num'] = $seat_num;
        $is_beixuan = db('reserve')->where($where)->find();
        if($is_beixuan){
            $this->ajaxReturn([],400,'该座位已被选',false);
        }

        //选座成功
        $add = [];
        $add['activity_id'] = $activity_id;
        $add['venue_id'] = $venue_id;
        $add['area'] = $area;
        $add['pai'] = $pai;
        $add['seat_num'] = $seat_num;
        $add['reserve_type'] = $reserve_type;
        $add['openid'] = $openid;
        $xuanzuo = db('reserve')->insert($add);
        //选座成功
        if($xuanzuo){
            //将动的该验本次活证码该为被使用过的验证码 is_use
            $set_code = db('code')
                ->where('activity_id',$activity_id)
                ->where('code',$activity_id)
                ->update(['is_use'=>1]);
            if(!$set_code){
                $this->ajaxReturn([],400,'设置验证码已使用时发生错误',false);
            }
        }else{
            //选座失败
            $this->ajaxReturn([],400,'选座失败',false);
        }
    }
}