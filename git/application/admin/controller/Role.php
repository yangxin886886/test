<?php
namespace app\admin\controller;

class Role extends Base{
    public function  index(){
        $role = db('role')->select();
        $this->assign('role',$role);
        return $this->fetch();
    }

    public function roleAddView(){
        return $this->fetch();
    }

    /**
     * 获取角色列表
    */
    public function getRoleList(){
        $role = db('role')->select();
        $this->ajaxReturn($role);
    }

    /**
     * 通过id获取角色
    */
    public function getRoleById(){
        $id = input('id');
        if($id == 0){
            $role = db('role')->select();
        }else{
            $role = db('role')->where('id',$id)->select();
        }
        $this->ajaxReturn($role);
    }

    /**
     * 添加角色
    */
    public function roleAdd(){
        $add['name'] = input('name');
        $add['remark'] = input('remark');
        $add['menu_id'] = input('menu_id');
        $add['add_time'] = time();

        if(empty($add['name'])){
            $this->ajaxReturn([],400,'角色名称不可为空');
        }
        $isRole = db('role')->where('name','eq',$add['name'])->find();
        if($isRole || count($isRole) > 0){
            $this->ajaxReturn([],400,'该角色已存在');
        }

        $res = db('role')->insert($add);
        return $res > 0
            ? $this->ajaxReturn()
            : $this->ajaxReturn([],401,'失败');

    }

    /**
     * 删除角色：如果角色正在别使用无法删除
    */
    public function roleDel(){
        $id = input('id');
        $role_id = db('user')->field('role_id')->select();
        if($role_id && count($role_id) > 0){
            foreach ($role_id as $k=>$v){
                $a = json_decode($v['role_id'],true);
                if($a && count($a) > 0 && in_array($id,$a)){
                    $this->ajaxReturn([],401,'此角色正被使用无法删除');
                }
            }

        }
        $res = db('role')->where('id',$id)->delete();
        return $res > 0 ? $this->ajaxReturn() : $this->ajaxReturn([],401,'失败');

    }

    /**
     * 获取菜单列表转树形结构
    */
    public function roleMenuAuth(){
       $id = input('role_id');
       $checked = [];   //角色对应的权限
       if($id && $id > 0){
           $menu_id = db('role')->where('id',$id)->value('menu_id');
           if(!empty($menu_id)){
               $checked = explode(',',$menu_id);
           }
       }

       $menu = db('menu')->field('*,name as title')->order('level','asc')->select();

       $menu_bind = new \app\admin\logic\MenuBind($menu,$checked,1);
       $this->ajaxReturn($menu_bind->getMenu());
    }

    /**
     * 编辑页面
    */
    public function roleEditView(){
        $id = input('id');
        $role = db('role')->where('id',$id)->find();
        $this->assign('role',$role);
        return $this->fetch();
    }

    public function roleUpdate(){
        $id = input('role_id');
        $update['name'] = input('name');
        $update['remark'] = input('remark');
        $update['menu_id'] = input('menu_id');
        $update['add_time'] = time();

        $res = db('role')->where('id',$id)->update($update);
        return $res > 0
            ? $this->ajaxReturn()
            : $this->ajaxReturn([],401,'失败');
    }


}