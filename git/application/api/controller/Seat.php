<?php
namespace app\api\controller;
class Seat extends Base{
    //根据活动获取区域
    public function getArea(){
        $activity_id = input('activity_id');
        if(!$activity_id){
            $this->ajaxReturn([],401,'活动id错误',false);
        }
        $activity = db('activity')->where('id',$activity_id)->find();
        if(!$activity){
            $this->ajaxReturn([],401,'活动id错误',false);
        }
        $venue_id = $activity['venue_id'];
        if(!$venue_id){
            $this->ajaxReturn([],401,'该活动还未设置场馆',false);
        }
        $putong  = [];
        $vip = 0;

        $set_vip_area = db('set_vip_area')
            ->where('activity_id',$activity_id)
            ->select();

        $temp_vip = [];  //vip区域 ['A','B']
        if($set_vip_area){
            foreach ($set_vip_area as $k=>$v){
                array_push($temp_vip,$v['area']);
            }
        }
        //----------------------获取普通区域---------------
        $putong_seat = db('seat')
            ->where('venue_id',$venue_id)
            ->where('area','not in',$temp_vip)
            ->select();
        //----------------------是否有VIP区域---------------
        $is_vip = db('seat')
            ->where('venue_id',$venue_id)
            ->where('area','in',$temp_vip)
            ->select();
        if($is_vip){
            $vip = 1;
        }
        $this->ajaxReturn(['putong_area'=>$putong_seat,'is_vip'=>$vip]);
    }
}