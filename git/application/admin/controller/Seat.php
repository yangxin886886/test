<?php
namespace app\admin\controller;
class Seat extends Base
{

    //编辑座位页面
    public function editSeatView()
    {
        $venue = db('venue')->select();
        $this->assign('venue', $venue);
        return $this->fetch();
    }

    //查询楼层列表
    public function venueIdVenueList()
    {
        $venue_id = input('venue_id');
        if (!$venue_id && empty($venue_id)) {
            $this->ajaxReturn([], 400, '该场馆还未设置楼层信息');
        }
        //永远拿最新的楼层信息
        $data = db('storey')
            ->where('venue_id', $venue_id)
            ->order('type', 'asc')
            ->select();
        if (!$data) {
            $this->ajaxReturn([], 808, '暂无楼层信息');
        }
        $this->ajaxReturn($data);
    }

    //查询区域
    public function getAreaList()
    {
        $area = require(ADMIN_MODULE . '/area/area.php'); //区域列表
        $type = input('type');  //几楼
        $venue_id = input('venue_id'); //活动id
        $storey = db('storey')
            ->where('venue_id', $venue_id)
            ->where('type', '<=', $type)
            ->select();
        if (!$storey) {
            $this->ajaxReturn([], 400, '楼层错误');
        }

        $del_num = 0;  //要删除的长度
        foreach ($storey as $k => $v) {
            if ($v['type'] != $type) {
                $del = json_decode($v['pai_area'], true);
                foreach ($del as $d => $dv) {
                    if (!empty($dv) && is_numeric(intval($dv))) {
                        $del_num += intval($dv);
                    }
                }
            }
        }
        //排除区域
        for ($i = 0; $i < $del_num; $i++) {
            unset($area[$i]);
        }

        //获取对应的区域
        $storey = db('storey')
            ->where('venue_id', $venue_id)
            ->where('type', $type)
            ->find();
        if (!$storey) {
            $this->ajaxReturn([], 400, 'false');
        }
        $start_num = 0;
        $get_area_num = json_decode($storey['pai_area'], true);
        foreach ($get_area_num as $k => $v) {
            if (!empty($v) && is_numeric(intval($v))) {
                $start_num += intval($v);
            }
        }
        $arr = [];
        for ($i = $del_num; $i < $del_num + $start_num; $i++) {
            $arr[] = $area[$i];
        }

        $this->ajaxReturn($arr);
    }

    //添加座位
    public function seatAdd()
    {
        $area_color = input('area_color');
        $save['venue_id'] = input('venue_id');
        $save['storey_id'] = input('storey_id');
        $save['pai_num'] = input('pai_num');
        $save['area'] = input('c_area');
        $save['is_equal'] = input('is_equal') ? 1 : 0;
        $pai_seat = input('pai_seat/a');  //数组某排有多少座位[2,3]代表 1排有2个座位 2排有三个座位
        if (!$save['venue_id']) {
            $this->ajaxReturn([], 400, 'venue_id错误');
        }
        //保存区域的颜色
//        if(!empty($save['area_color'])){
//            db('area_color')
//                ->insert([
//                    'venue_id'=>$save['venue_id'],
//                    'color'=>$area_color,
//                    'storey_id'=>$save['storey_id'],
//                    'area'=>$save['area']
//                ]);
//        }
        if (!$pai_seat) {
            $this->ajaxReturn([], 400, '座位发生错误');
        }
        $save['pai_seat'] = json_encode($pai_seat);

//        $data = [];
//        for($i=1;$i<=count($pai_seat);$i++){
//            $arr = [
//                'venue_id'=>$save['venue_id'],
//                'storey_id'=>$save['storey_id'],
//                'area'=>$save['area'],
//                'what_row'=>$i
//            ];
//            array_push($data,$arr);
//        }
//        $res = db('seat')->insertAll($data);
        if (!empty($area_color)) {
            $save['area_color'] = $area_color;
        }
        $is_save = db('seat')
            ->where('venue_id', $save['venue_id'])
            ->where('storey_id', $save['storey_id'])
            ->where('area', $save['area'])
            ->find();
        $res = 0;
        //新增
        if (!$is_save) {
            $res = db('seat')->insert($save);
        } else {
            $res = db('seat')
                ->where('venue_id', $save['venue_id'])
                ->where('storey_id', $save['storey_id'])
                ->where('area', $save['area'])
                ->update($save);
        }
        $this->saveAjaxReturn($res);
    }

    //获取区域的颜色和排数
    public function getAreaColorPai()
    {
        $venue_id = input('venue_id');
        $storey_id = input('storey_id');
        $area = input('area');
        if (!$venue_id) {
            $this->ajaxReturn([], 400, 'venue_id错误');
        }
        if (!$storey_id) {
            $this->ajaxReturn([], 400, 'storey_id错误');
        }
        if (!$area) {
            $this->ajaxReturn([], 400, 'area错误');
        }
        $data = db('seat')
            ->where('venue_id', $venue_id)
            ->where('storey_id', $storey_id)
            ->where('area', $area)
            ->find();
        $data['pai_seat'] = json_decode($data['pai_seat'], true);
        $this->ajaxReturn($data);
    }


    public function reserveView()
    {
        $activity = db('activity')->select();
        $this->assign('activity', $activity);
        return $this->fetch();
    }

    //预留座位
    public function reserveSeat()
    {
        $save['activity_id'] = input('activity_id');
        $save['venue_id'] = input('venue_id');
        $save['area'] = input('area');//区
        $save['pai'] = input('pai'); //排
        $save['seat_num'] = input('seat_num'); //座位号
        if (!$save['activity_id']) {
            $this->ajaxReturn([], 400, 'activity_id错误');
        }
        if (!$save['venue_id']) {
            $this->ajaxReturn([], 400, 'venue_id错误');
        }
        if (!$save['area']) {
            $this->ajaxReturn([], 400, 'area错误');
        }
        if (!$save['pai']) {
            $this->ajaxReturn([], 400, 'pai错误');
        }
        if (!$save['seat_num']) {
            $this->ajaxReturn([], 400, 'seat_num错误');
        }
        $res = 0;
        $is_reserve = db('reserve')
            ->where('activity_id', $save['activity_id'])
            ->where('venue_id', $save['venue_id'])
            ->where('area', $save['area'])
            ->where('pai', $save['pai'])
            ->where('seat_num', $save['seat_num'])
            ->find();
        if (!$is_reserve) {
            $res = db('reserve')->insert($save);
        } else {
            $res = db('reserve')
                ->where('id', $is_reserve['id'])
                ->delete();
        }

        $this->saveAjaxReturn($res);
    }

    //根据活动id获取场馆信息
    public function aIdGetStorey()
    {
        //获取venue_id
        $activity_id = input('activity_id');
        if (!$activity_id) {
            $this->ajaxReturn([], 400, 'activity_id错误');
        }
        $res = db('activity')->where('id', $activity_id)->find();
        if (!$res['venue_id']) {
            $this->ajaxReturn([], 400, '该活动还未设置场馆');
        }

        //根据venue_id获取楼层信息
        $venue_id = $res['venue_id'];
        if (!$venue_id && empty($venue_id)) {
            $this->ajaxReturn([], 400, '该活动的场馆还未设置楼层信息');
        }

        //获取场馆名称
        $venue = db('venue')->where('id', $venue_id)->find();

        //永远拿最新的楼层信息
        $data = db('storey')
            ->where('venue_id', $venue_id)
            ->order('type', 'asc')
            ->select();
        if (!$data) {
            $this->ajaxReturn([], 808, '暂无楼层信息');
        }
        $arr['storey'] = $data;
        $arr['venue_id'] = $venue_id;
        $arr['venue_name'] = $venue['name'];
        $this->ajaxReturn($arr);
    }

    //设置VIP区域
    public function setVipArea()
    {
        $activity_id = input('activity_id');
        $area = input('area');
        if (!$activity_id) {
            $this->ajaxReturn([], 400, '活动错误');
        }
        if (!$area) {
            $this->ajaxReturn([], 400, '区域错误');
        }

        $is = db('set_vip_area')
            ->where('activity_id', $activity_id)
            ->where('area', $area)
            ->find();
        $res = 0;
        if ($is) {
            $res = db('set_vip_area')
                ->where('activity_id', $activity_id)
                ->where('area', $area)
                ->delete();
        } else {
            $save = ['activity_id' => $activity_id, 'area' => $area];
            $res = db('set_vip_area')->insert($save);
        }
        $this->saveAjaxReturn($res);
    }

    //设置活动验证码
    public function setActivityCode(){
        $activity_id = input('activity_id');
        $code_count = input('code_count'); //验证码数量
        $weishu = input('weishu');//验证码位数
        if(!$weishu){
            $weishu =  input('vweishu');
        }
        $level = input('level');//1：普通验证码 2：VIP验证码

        if(!$activity_id){
            $this->ajaxReturn([],400,'未选活动或活动错误');
        }
        if(!$code_count){
            $this->ajaxReturn([],400,'验证码数量错误');
        }
        if(!$weishu){
            $this->ajaxReturn([],400,'验证码位数错误');
        }
        if(!$level){
            $this->ajaxReturn([],400,'level错误');
        }
        //禁止生成的验证码
        $is_no_code = db('code')->where('activity_id',$activity_id)->select();

        $save = [];
        $code = new  \app\admin\logic\Code($weishu,$code_count,$is_no_code);
        $code = $code->getRes(); //获取验证码数组
        foreach ($code as $k=>$v){
            $arr = [
                'activity_id'=>$activity_id,
                'level'=>$level,
                'weishu'=>$weishu,
                'code'=>$v
            ];
            array_push($save,$arr);
        }

        $is = db('code')
            ->where('activity_id',$activity_id)
            ->where('level',$level)
            ->select();
        //编辑操作
        if($is){
            db('code')
                ->where('activity_id',$activity_id)
                ->where('level',$level)
                ->delete();
        }
        $res = db('code')->insertAll($save);
        $this->saveAjaxReturn($res);
    }

}