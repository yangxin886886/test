<?php
namespace app\admin\controller;
class Seat extends Base{

    //编辑座位页面
    public function editSeatView(){
        $activity = db('activity')->select();
        $this->assign('activity',$activity);
        return $this->fetch();
    }

    //根据活动id查询楼层信息
    public function editSeatGet(){
        $activity_id = input('activity_id');
        $this->assign('activity_id',$activity_id);

        if(!$activity_id && empty($activity_id)){
            $is_activity_id = 0;
            //$this->ajaxReturn([],400,'该活动还未设置楼层信息');
        }
        $storey = [];
        $storey = db('storey')->where('activity_id',$activity_id)->select();
        $this->assign('storey',$storey);

        $activity = db('activity')->select();
        $this->assign('activity',$activity);
        return $this->fetch();
    }

    //根据活动id查询楼层列表
    public function activityIdVenueList(){
        $activity_id  = input('activity_id');
        if(!$activity_id && empty($activity_id)){
            $this->ajaxReturn([],400,'该活动还未设置楼层信息');
        }
        db('storey')->where('activity_id',$activity_id)->select();
    }

    //根据活动id和楼层id查询对应的区域
    public function aIdVidAreaList(){

    }
}