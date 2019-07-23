<?php

namespace app\admin\logic;
/**
 * 菜单绑定--最多3级
*/
class MenuBind
{
    private  $menu = [];
    private  $menu_id = [];
    private  $type = 1;
    private  $level1 = [];
    private  $level2 = [];
    private  $level3 = [];

    /**
     * $menu 菜单列表：二维数组
     * $menu_id 角色对应的菜单id：[1,2,5,6]
     * $type：1编辑角色权限页面使用  2：根据menu_id 过滤菜单 ---因为编辑角色权限页面必须把返回的父菜单checked = false
    */
    public function __construct($menu,$menu_id = [],$type = 1)
    {
        $this->menu = $menu;
        $this->menu_id = $menu_id;
        $this->type = $type;
        $this->startExplode();
    }



    public function startExplode(){
        if($this->type == 1){
            $this->menuChecked($this->menu_id); //将角色对应的权限checked=true
            $this->fatherMenuCheckedFalse();
        }
        if($this->type == 2){
            $this->filterMenu();// 根据menu_id 过滤菜单
        }
        $this->levelExplode();
        $this->level2BindLevel3();
        $this->level1BindLevel2();
    }

    /**
     * 根据等级分割数组
    */
    public function levelExplode(){
        foreach ($this->menu as $k=>$v){
            if($v['level'] == 1){
                $this->level1[] = $v;
            }
            if($v['level'] == 2){
                $this->level2[] = $v;
            }
            else if($v['level'] == 3){
                $this->level3[] = $v;
            }
        }

    }

    /**
     * 过滤菜单
     * $menu_id 可显示的菜单id
    */
    public function filterMenu(){
        foreach ($this->menu as $k=>$v){
            if(!in_array($v['id'],$this->menu_id)){
                unset($this->menu[$k]);
            }
        }
    }

    /**
     * 用户已有权限加checked
     */
    public function menuChecked($checked){
        if(!$checked){
            return false;
        }
        foreach ($checked as $c){
            foreach ($this->menu as $kk=>$m){
                if($c == $m['id']){
                    $this->menu[$kk]['checked']  = true;
                    break;
                }
            }
        }

    }

    /**
     * 编辑角色权限页面将父菜单的checked = false
    */
    public function fatherMenuCheckedFalse(){
        $filter_fid = [];
        foreach($this->menu_id as $k=>$v){
            foreach ($this->menu as $kk=>$vv){
                if($v == $vv['id'] && $vv['fid'] > 0 && in_array($vv['fid'],$this->menu_id)){
                    $filter_fid[] = $vv['fid'];
                }
            }
        }

        foreach ($this->menu as $k =>$v){
            if(in_array($v['id'],$filter_fid)){

                isset($this->menu[$k]['checked']) && $this->menu[$k]['checked'] = false;
            }
        }
    }

    /**
     * 将二级菜单和对应的三级菜单绑定
    */
    public function level2BindLevel3(){
        if(count($this->level3) > 0 && count($this->level2) > 0){
            foreach ($this->level2 as $k=>$level2_val) {

                foreach ($this->level3 as $level3_val){
                    if($level2_val['id'] == $level3_val['fid']){
                        $this->level2[$k]['children'][] = $level3_val;
                    }
                }

            }
        }
    }

    /**
     * 将一级菜单和对应的二级菜单绑定
    */
    public function level1BindLevel2(){
        if(count($this->level2) > 0 && count($this->level1) > 0){
            foreach ($this->level1 as $k=>$level1_val) {

                foreach ($this->level2 as $level2_val){
                    if($level1_val['id'] == $level2_val['fid']){
                        $this->level1[$k]['children'][] = $level2_val;
                    }
                }
            }
        }

    }

    /**
     * 获取最后绑定好的菜单
    */
    public function getMenu(){
        return $this->level1;
    }

}