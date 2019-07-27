<?php
namespace app\admin\controller;
class Venue extends Base{
    public function index(){
        return $this->fetch();
    }

    public function createVenue(){
        return $this->fetch();
    }

    public function venueAdd(){
        $save['name'] = input('name');
        $save['school'] = input('school');
        $save['xq_name'] = input('xq_name');
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
        return $this->fetch();
    }


    public function seatAreaRowNum(){
        return $this->fetch();
    }
    /**
     * 添加楼层--页面
    */
    public function seatAreaRowNumAddView(){
        $activity = db('activity')->select();
        $this->assign('activity',$activity);

        $activity_id = input('activity_id');
        $storey = db('storey')->where('activity_id',$activity_id)->select();
        $this->assign('storey',$storey);
        return $this->fetch();
    }

    //设置楼层排数
    public function setStorey(){
        //楼层1
        $add['activity_id'] = input('activity_id');
        $add['type'] = input('storey1');
        $add['pai_number'] = input('storey1_pai');
        $add['add_time'] = time();
        $res = 0;

        if(!$add['activity_id'] && empty($add['activity_id'])){
            $this->ajaxReturn([],400,'activity_id错误');
        }
        if(!empty($add['pai_number']) && $add['pai_number'] > 0){
            $add['pai_area'] = json_encode(input('storey1Pai/a'));
            //是编辑操作还是新增操作
            $is_add = db('storey')
                ->where('activity_id',$add['activity_id'])
                ->where('type',$add['type'])
                ->select();

            //编辑
            if(count($is_add) > 0){
                $res = db('storey')
                    ->where('activity_id',$add['activity_id'])
                    ->where('type',$add['type'])
                    ->update($add);
            }else{
                $res = db('storey')->insert($add);
            }
        }

        //楼层2
        $add['type'] = input('storey2');
        $add['pai_number'] = input('storey2_pai');
        if(!empty($add['pai_number']) && $add['pai_number'] > 0){
            $add['pai_area'] = json_encode(input('storey2Pai/a'));
            //是编辑操作还是新增操作
            $is_add = db('storey')
                ->where('activity_id',$add['activity_id'])
                ->where('type',$add['type'])
                ->select();

            //编辑
            if(count($is_add) > 0){
                $res = db('storey')
                    ->where('activity_id',$add['activity_id'])
                    ->where('type',$add['type'])
                    ->update($add);
            }else{
                $res = db('storey')->insert($add);
            }
        }

        //楼层3
        $add['type'] = input('storey3');
        $add['pai_number'] = input('storey3_pai');
        if(!empty($add['pai_number']) && $add['pai_number'] > 0){
            $add['pai_area'] = json_encode(input('storey3Pai/a'));
            //是编辑操作还是新增操作
            $is_add = db('storey')
                ->where('activity_id',$add['activity_id'])
                ->where('type',$add['type'])
                ->select();

            //编辑
            if(count($is_add) > 0){
                $res = db('storey')
                    ->where('activity_id',$add['activity_id'])
                    ->where('type',$add['type'])
                    ->update($add);
            }else{
                $res = db('storey')->insert($add);
            }
        }
        $this->saveAjaxReturn($res);
    }

    public function setPaiAreaView(){
        return $this->fetch();
    }
}