<?php
namespace app\admin\controller;

class Activity extends Base{
    public function index(){
        return $this->fetch();
    }

    /**
     * 获取活动列表
    */
    public function getActivityList(){
        $activity = db('activity')->where('user_id',$this->userInfo['id'])->select();
        $this->ajaxReturn($activity);
    }

    /**
     * 创建活动页面
    */
    public function createActivityView(){
        $venue = db('venue')->select();
        $this->assign('venue',$venue);
        return $this->fetch();
    }

    public function createActivityAdd(){
        if(!$this->userInfo['id'] || $this->userInfo['id'] == 0){
            $this->ajaxReturn([],400,'user_id错误');
        }
        $save = input('get.');
        $save['user_id'] = $this->userInfo['id'];
        if(!isset($save['name']) || empty($save['name'])){
            $this->ajaxReturn([],400,'活动名称不能为空');
        }
        if(isset($save['a_start_time']) && strtotime($save['a_start_time']) > strtotime($save['a_end_time'])){
            $this->ajaxReturn([],400,'活动开始时间不能大于结束时间');
        }

        if(isset($save['x_start_time']) && strtotime($save['x_start_time']) > strtotime($save['x_end_time'])){
            $this->ajaxReturn([],400,'选座开始时间不能大于结束时间');
        }

        $save['add_time'] = time();
        unset($save['file']);
        $res = db('activity')->insert($save);
        return $res > 0 ? $this->ajaxReturn() : $this->ajaxReturn([],400,'失败');
    }

    public function createActivityEdit(){
        $id = input('id');
        if(empty($id)){
            $this->ajaxReturn([],400,'id错误');
        }
        if(!$this->userInfo['id'] || $this->userInfo['id'] == 0){
            $this->ajaxReturn([],400,'user_id错误');
        }
        $save = input('get.');
        $save['user_id'] = $this->userInfo['id'];
        if(!isset($save['name']) || empty($save['name'])){
            $this->ajaxReturn([],400,'活动名称不能为空');
        }
        if(isset($save['a_start_time']) && strtotime($save['a_start_time']) > strtotime($save['a_end_time'])){
            $this->ajaxReturn([],400,'活动开始时间不能大于结束时间');
        }

        if(isset($save['x_start_time']) && strtotime($save['x_start_time']) > strtotime($save['x_end_time'])){
            $this->ajaxReturn([],400,'选座开始时间不能大于结束时间');
        }

        $save['add_time'] = time();
        unset($save['file']);
        $res = db('activity')->where('id',$id)->update($save);
        return $res > 0 ? $this->ajaxReturn() : $this->ajaxReturn([],400,'失败');
    }


    /**
     * 启用上墙或禁用上墙
    */
    public function activitySq(){
        $id = input('id');
        $is_sq = input('is_sq');
        if(empty($id)){
            $this->ajaxReturn([],400,'id错误');
        }
        $is_sq = $is_sq == 1 ? 0 : 1;
        $res = db('activity')->where('id',$id)->update(['is_sq'=>$is_sq]);
        return $res > 0 ? $this->ajaxReturn() : $this->ajaxReturn([],400,'失败');
    }

    /**
     * 发布或暂停发布
     */
    public function activityFb(){
        $id = input('id');
        $fb_status = input('fb_status');
        if(empty($id)){
            $this->ajaxReturn([],400,'id错误');
        }
        $fb_status = $fb_status == 1 ? 0 : 1;
        $res = db('activity')->where('id',$id)->update(['fb_status'=>$fb_status]);
        return $res > 0 ? $this->ajaxReturn() : $this->ajaxReturn([],400,'失败');
    }

    /**
     * 删除活动
    */
    public function activityDel(){
        $id = input('id');
        if(empty($id)){
            $this->ajaxReturn([],400,'id错误');
        }
        $res = db('activity')->where('id',$id)->delete();
        return $res > 0 ? $this->ajaxReturn() : $this->ajaxReturn([],400,'失败');
    }

    public function activityEditView(){
        $imgPrefix = "http://" . $_SERVER['HTTP_HOST']."/public/uploads";
        $id = input('id');
        if(empty($id)){
            exit('id错误');
        }

        $venue = db('venue')->select();
        $this->assign('venue',$venue);

        $activity = db('activity')->where('id',$id)->find();
        $this->assign('activity',$activity);
        $this->assign('imgPrefix',$imgPrefix);
        return $this->fetch();
    }

    //设置活动的二维码
    public function setCode(){
        $activity = db('activity')->select();
        $this->assign('activity',$activity);
        return $this->fetch();
    }
}