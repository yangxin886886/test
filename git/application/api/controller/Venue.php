<?php
namespace app\api\controller;
class Venue extends Base{
    /**
     * 获取场馆列表--
    */
    public function getVenueList(){
        $venue = db('venue')->select();
        if(!$venue){
            $this->ajaxReturn([],400,'暂无场馆',false);
        }
        $this->ajaxReturn($venue);
    }

}