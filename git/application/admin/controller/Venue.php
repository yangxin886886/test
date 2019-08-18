<?php
namespace app\admin\controller;
class Venue extends Base{
    public function index(){
        return $this->fetch();
    }

    public function createVenue(){
        return $this->fetch();
    }

    /**
     * 获取场馆的所有区域
    */
    public function getVenueArea(){
        $venue_id = input('venue_id');
        $storey = db('storey')
            ->where('venue_id', $venue_id)
            ->order('type', 'asc')
            ->select();
        if (!$storey) {
            $this->ajaxReturn([], 808, '暂无楼层信息');
        }

        //获取区域
        $storey_area = []; //楼层对应的区域[1: [["A"], ["B"]], 2: [["C"], ["D"]],…]
        $area = require(ADMIN_MODULE . '/area/area.php'); //区域列表
        foreach ($storey as $k=>$v){
            $storey_area[$v['type']] = [];
            $pai_area = json_decode($v['pai_area'], true);
            foreach ($pai_area as $d => $dv) {
                if (!empty($dv) && is_numeric(intval($dv))) {
                    $storey_area[$v['type']][$d] =[];
                    for ($j=0;$j<intval($dv);$j++){
                        array_push( $storey_area[$v['type']][$d],array_shift($area));
                    }
                }
            }
        }
        $this->ajaxReturn($storey_area);
    }

    public function venueAdd(){
        $save['name'] = trim(input('name')," ");
        $save['school'] = trim(input('school')," ");
        $save['xq_name'] = trim(input('xq_name')," ");
        $save['pbfs'] = input('pbfs');
        $save['add_time'] = time();
        $res = db('venue')->insert($save);
        $this->saveAjaxReturn($res);
    }

    public function getVenueList(){
        return $this->fetch('index');
    }

    public function venueStyleView(){
        return $this->fetch();
    }

    public function createVenueStyle(){
        $venue = db('venue')->select();
        $this->assign('venue', $venue);
        return $this->fetch();
    }


    public function seatAreaRowNum(){
        return $this->fetch();
    }
    /**
     * 添加楼层--页面
    */
    public function seatAreaRowNumAddView(){
        $venue = db('venue')->select();
        $this->assign('venue',$venue);

        $activity_id = input('activity_id');
        $storey = db('storey')->where('activity_id',$activity_id)->select();
        $this->assign('storey',$storey);
        return $this->fetch();
    }

    //设置楼层排数
    public function setStorey(){
        //楼层1
        $add['venue_id'] = input('venue_id');
        $add['type'] = input('storey1');
        $add['pai_number'] = input('storey1_pai');
        $add['add_time'] = time();
        $add['pai_area'] = json_encode(input('storey1Pai/a'));
        $res = 0;
        if(!$add['venue_id'] && empty($add['venue_id'])){
            $this->ajaxReturn([],400,'venue_id错误');
        }

        $is_add = db('storey')
            ->where('venue_id',$add['venue_id'])
            ->where('type',$add['type'])
            ->select();
        if(count($is_add) > 0){
            //编辑
            $res = db('storey')
                ->where('venue_id',$add['venue_id'])
                ->where('type',$add['type'])
                ->update($add);

        }else{
            $res = db('storey')->insert($add);
        }

        //楼层2
        $add['type'] = input('storey2'); //第几楼
        $add['pai_number'] = input('storey2_pai');  //有几排
        $add['pai_area'] = json_encode(input('storey2Pai/a'));
        if(count($is_add) > 0){
            //编辑
            $res = db('storey')
                ->where('venue_id',$add['venue_id'])
                ->where('type',$add['type'])
                ->update($add);

        }else{
            $res = db('storey')->insert($add);
        }

        //楼层3
        $add['type'] = input('storey3');
        $add['pai_number'] = input('storey3_pai');
        $add['pai_area'] = json_encode(input('storey3Pai/a'));
        if(count($is_add) > 0){
            //编辑
            $res = db('storey')
                ->where('venue_id',$add['venue_id'])
                ->where('type',$add['type'])
                ->update($add);

        }else{
            $res = db('storey')->insert($add);
        }

        $this->saveAjaxReturn($res);
    }

    public function setPaiAreaView(){
        return $this->fetch();
    }

    /**
     * 创建楼层对应的区域
     */
    public function createArea(){

    }
}