<?php
namespace app\admin\controller;

class Menu extends Base{
    public function index(){
        return $this->fetch();
    }

    public function menuAddView(){
        return $this->fetch();
    }

    /**
     * 添加菜单
    */
    public function menuAdd(){
        $add['level'] = input('level');
        $add['fid'] = input('fid');
        $add['name'] = input('name');
        $add['sort'] = input('sort');
        $add['icon'] = input('icon');
        $add['ctl'] = input('ctl');
        $add['act'] = input('act');
        $add['add_time'] = time();
        if(!$add['level']){
            $this->ajaxReturn([],400,'参数不正确');
        }
        if(intval($add['sort']) > 20 || intval($add['sort']) == 0){
            $this->ajaxReturn([],400,'sort不正确');
        }
        $is_menu = db('menu')->where('name',$add['name'])->select();
        if(count($is_menu) > 0){
            $this->ajaxReturn([],400,'该菜单已存在');
        }

        $res = db('menu')->insert($add);
        return $res > 0 ? $this->ajaxReturn() : $this->ajaxReturn([],400,'失败');
    }

    /**
     * 删除菜单
    */
    public function menuDel(){
        $id = input('id');
        if(!$id || empty($id)){
            $this->ajaxReturn([],400,'id参数有误');
        }
        $is_child = db('menu')->where('fid',$id)->find();
        if($is_child || count($is_child) > 0){
            $this->ajaxReturn([],401,'当前菜单下有子菜单无法删除');
        }
        $res = db('menu')->where('id',$id)->delete();
        return $res > 0 ? $this->ajaxReturn() : $this->ajaxReturn([],400,'失败');
    }

    /**
     * 获取菜单列表
    */
    public function getMenuList(){
        $menu = db('menu')->select();
        $this->ajaxReturn($menu);
    }


    /**
     * 根据level获取菜单
    */
    public function levelGetMenu(){
        $level = intval(input('level')) - 1;
        if(!$level || !$level > 0){
            $this->ajaxReturn([],400,'参数不正确');
        }
        $menu = db('menu')->where('level',$level)->select();
        $this->ajaxReturn($menu);
    }

    /**
     * 编辑页面
    */
    public function menuEditView(){
        $id = input('id');
        $menu = db('menu')->where('id',$id)->find();

        $fid_find = null;
        //获取父菜单名称
        if(count($id) > 0 && $menu['level'] > 1){
            $fid_find = db('menu')->where('id',$menu['fid'])->find();
        }
        $this->assign('fid_find',$fid_find);
        $this->assign('menu',$menu);
        return $this->fetch();
    }

    public function menuEdit(){
        $update['id'] = input('id');
        $update['level'] = input('level');
        $update['fid'] = input('fid');
        $update['name'] = input('name');
        $update['sort'] = input('sort');
        $update['icon'] = input('icon');
        $update['ctl'] = input('ctl');
        $update['act'] = input('act');
        $update['add_time'] = time();
        if(empty($update['id'])){
            $this->ajaxReturn([],400,'id错误');
        }
        if(!$update['level']){
            $this->ajaxReturn([],400,'参数不正确');
        }
        if(intval($update['sort']) > 20 || intval($update['sort']) == 0){
            $this->ajaxReturn([],400,'sort不正确');
        }

        $res = db('menu')->where('id',$update['id'])->update($update);
        return $res > 0 ? $this->ajaxReturn() : $this->ajaxReturn([],400,'失败');
    }

}