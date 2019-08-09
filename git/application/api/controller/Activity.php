<?php
namespace app\api\controller;
class  Activity extends Base{

    //获取活动列表--和已选座位数
    public function getActivityList(){
        $user_id = input('user_id');
        $current_time = date("Y-m-d H:i:s");
        //正在进行的活动
        $activity = db('activity')
            ->field('a.*,count(r.activity_id) as reserve')
            ->alias('a')
            ->join('reserve r','a.id = r.activity_id','left')
            ->group('a.id')
            ->where('user_id',$user_id)
            ->where('a_start_time','<= time',$current_time)
            ->where('a_end_time','>= time',$current_time)
            ->select();

        if(!$activity){
            $this->ajaxReturn([],400,'暂无活动或已结束',false);
        }
        //获取活动对应的座位信息
        foreach ($activity as $k=>$v){
            //未设置场馆
            if(empty($v['venue_id'])){
                $activity[$k]['count'] = 0;
                continue;
            }
            //场馆有多少座位
            $activity[$k]['count'] = $this->seatCount($v['venue_id']);
        }

        $this->ajaxReturn($activity);
    }

    //即将进行的活动
    public function jijiangActivity(){
        $user_id = input('user_id');
        $current_time = date("Y-m-d H:i:s");
        //即将进行的活动
        $jijiang_activity = db('activity')
            ->field('a.*,count(r.activity_id) as reserve')
            ->alias('a')
            ->join('reserve r','a.id = r.activity_id','left')
            ->group('a.id')
            ->where('user_id',$user_id)
            ->where('a_start_time','> time',$current_time)
            ->select();
        if(!$jijiang_activity){
            $this->ajaxReturn([],400,'暂无活动或已结束',false);
        }

        //获取活动对应的座位信息
        foreach ($jijiang_activity as $k=>$v){
            //未设置场馆
            if(empty($v['venue_id'])){
                $activity[$k]['count'] = 0;
                continue;
            }
            //场馆有多少座位
            $jijiang_activity[$k]['count'] = $this->seatCount($v['venue_id']);
        }

        $this->ajaxReturn($jijiang_activity);
    }

    //获取活动的总座位数
    public function seatCount($venue_id){
        $count = 0;//座位总数
        $seat = db('seat')->select();
        if(!$seat){
            return $count;//该场馆还未设置座位信息
        }
        foreach ($seat as $k=>$v){
            if($v['venue_id'] == $venue_id){
                $data = json_decode($v['pai_seat'],true);
                if(count($data) > 0){
                    foreach ($data as $kk=>$vv){
                        $count += intval($vv);
                    }
                }
            }
        }

        return $count;
    }

    //获取某活动详情
    public function activityDetails(){
        $activity_id = input('activity_id');
        if(!$activity_id){
            $this->ajaxReturn([],401,'活动id错误',false);
        }

        $current_time = date("Y-m-d H:i:s");
        //正在进行的活动
        $activity = db('activity')
            ->field('a.*,count(r.activity_id) as reserve')
            ->alias('a')
            ->join('reserve r','a.id = r.activity_id','left')
            ->group('a.id')
            ->where('a.id',$activity_id)
            ->where('a_start_time','<= time',$current_time)
            ->where('a_end_time','>= time',$current_time)
            ->find();

        if(!$activity){
            $this->ajaxReturn([],400,'暂无活动',false);
        }
        //获取活动对应的座位信息
        if(empty($v['venue_id'])){
            $activity['count'] = 0;
        }else{
            //场馆有多少座位
            $activity['count'] = $this->seatCount($v['venue_id']);
        }
        $this->ajaxReturn($activity);
    }

    /**
     * 发布或暂停发布
     */
    public function activityFb(){
        $user_id  = input('user_id');
        $activity_id = input('activity_id'); //活动id
        $fb_status = input('fb_status');//发布状态 0：未发布 1已发布
        if(empty($user_id)){
            $this->ajaxReturn([],400,'用户id错误');
        }
        if(empty($activity_id)){
            $this->ajaxReturn([],400,'活动id错误');
        }
        if(empty($fb_status)){
            $this->ajaxReturn([],400,'发布状态错误');
        }

        $res = db('activity')
            ->where('user_id',$user_id)
            ->where('id',$activity_id)
            ->update(['fb_status'=>$fb_status]);
        $this->saveAjaxReturn($res);
    }

    /**
     * 删除活动
     */
    public function activityDel(){
        $user_id  = input('user_id');
        $activity_id = input('activity_id');
        $current_time = date("Y-m-d H:i:s"); //当前时间
        if(empty($activity_id)){
            $this->ajaxReturn([],400,'id错误',false);
        }
        $res = db('activity')
            ->where('id',$activity_id)
            ->where('user_id',$user_id)
            ->where('a_start_time','<= time',$current_time)
            ->where('a_end_time','>= time',$current_time)
            ->find();
        if($res){
            $this->ajaxReturn([],400,'活动进行中不可删除',false);
        }
        $res = db('activity')
            ->where('id',$activity_id)
            ->where('user_id',$user_id)
            ->delete();
        $this->saveAjaxReturn($res);
    }

    /**
     * @param  string $school 学校名称
     * @param  int $venue_id 场馆id
     * 搜索学校正在进行的活动--不传venue_id 默认选择所有场馆
     */
    public function searchSchoolActivity(){
        $school = input('school'); //学校名称
        $venue_id = input('venue_id'); //场馆id
        if(!$school){
            $this->ajaxReturn([],400,'学校名称不能为空',false);
        }
        //判断学校是否正确
        $school_where = [];
//        $school_where['school'] = ['like','%'.$school.'%'];
        $school_where['school'] = $school;
        if($venue_id){
            $school_where['venue_id'] = $venue_id;
        }
        $is_school = db('venue')
            ->where($school_where)
            ->select();
        if(!$is_school){
            $this->ajaxReturn([],400,'学校不存在或者选择场馆错误',false);
        }

        //获取学校对应的正在进行的活动
        $current_time = date("Y-m-d H:i:s");
        $where = [];
        if($venue_id){
            $where['venue_id'] = $venue_id;
        }
        $where['a_start_time'] = ['<= time',$current_time];
        $where['a_end_time'] = ['>= time',$current_time];
//        $where['school'] = ['like','%'.$school.'%'];
        $where['school'] = $school;
        $activity = db('activity')
            ->field('a.*,count(r.activity_id) as reserve')
            ->alias('a')
            ->join('reserve r','a.id = r.activity_id','left')
            ->join('venue v','a.venue_id = v.id','inner')
            ->group('a.id')
            ->where($where)
            ->select();

        if(!$activity){
            $this->ajaxReturn([],400,'暂无活动或已结束',false);
        }
        //获取活动对应的座位信息
        foreach ($activity as $k=>$v){
            //未设置场馆
            if(empty($v['venue_id'])){
                $activity[$k]['count'] = 0;
                continue;
            }
            //场馆有多少座位
            $activity[$k]['count'] = $this->seatCount($v['venue_id']);
        }
        $this->ajaxReturn($activity);
    }

    /**
     * @param  string $school 学校名称
     * @param  int $venue_id 场馆id
     * 搜索学校即将进行的活动--不传venue_id 默认选择所有场馆
     */
    public function searchSchoolJjActivity(){
        $school = input('school'); //学校名称
        $venue_id = input('venue_id'); //场馆id
        if(!$school){
            $this->ajaxReturn([],400,'学校名称不能为空',false);
        }
        //判断学校是否正确
        $school_where = [];
//        $school_where['school'] = ['like','%'.$school.'%'];
        $school_where['school'] = $school;
        if($venue_id){
            $school_where['venue_id'] = $venue_id;
        }
        $is_school = db('venue')
            ->where($school_where)
            ->select();
        if(!$is_school){
            $this->ajaxReturn([],400,'学校不存在或者选择场馆错误',false);
        }

        //获取学校对应的即将进行的活动
        $current_time = date("Y-m-d H:i:s");
        $where = [];
        if($venue_id){
            $where['venue_id'] = $venue_id;
        }
        $where['a_start_time'] = ['>= time',$current_time];
//        $where['school'] = ['like','%'.$school.'%'];
        $where['school'] = $school;
        $activity = db('activity')
            ->field('a.*,count(r.activity_id) as reserve')
            ->alias('a')
            ->join('reserve r','a.id = r.activity_id','left')
            ->join('venue v','a.venue_id = v.id','inner')
            ->group('a.id')
            ->where($where)
            ->select();

        if(!$activity){
            $this->ajaxReturn([],400,'暂无活动或已结束',false);
        }
        //获取活动对应的座位信息
        foreach ($activity as $k=>$v){
            //未设置场馆
            if(empty($v['venue_id'])){
                $activity[$k]['count'] = 0;
                continue;
            }
            //场馆有多少座位
            $activity[$k]['count'] = $this->seatCount($v['venue_id']);
        }
        $this->ajaxReturn($activity);
    }


    /**
     * 学校联想
     * 输入学校时具有联想功能，选定学校，再联想场馆，但是默认是全部场馆
    */
    public function lenovoSchool(){
        $school = input('school');
        if(!$school){
            $this->ajaxReturn([],400,'学校名称不可为空',false);
        }
        $where = [];
        $where['school'] = ['like','%'.$school.'%']; //联想学校
        $venue = db('venue')->where($where)->select();
        if(!$venue){
            $this->ajaxReturn([],400,'暂无',false);
        }
        $this->ajaxReturn($venue);
    }

    /**
     * 学校对应的场馆
    */
    public function schoolVenue(){
        $school = input('school');
        if(!$school){
            $this->ajaxReturn([],400,'学校名称不可为空',false);
        }
        $where = [];
        $where['school'] = $school;
        $venue = db('venue')->where($where)->select();
        if(!$venue){
            $this->ajaxReturn([],400,'暂无',false);
        }
        $this->ajaxReturn($venue);
    }
}