<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;

class Base extends Controller{

    public  $userInfo = [];  //用户信息
    private $menu = [];     //格式化后的菜单
    private $dbMenu = [];   //直接从数据库读取的菜单列表：在添加菜单页面使用
    private $menu_id = [];  //普通管理员对应的菜单id 例[1,2,7]
    private $current_ctl = null;
    private $current_act = null;
    private $no_check_ctl_act = [
        ['ctl'=>'Index','act'=>'index']
    ]; //无需验证的控制器和动作

    public function __construct()
    {
        parent::__construct();
        $this->isLogin();  //检查是否登录
        $this->setCtlAct(); //获取当前控制器和动作名称
        $this->setMenuID(); //设置用户对应的菜单id[1,2,7]
        $this->userRoleAuth();//获取用户对应的菜单--绑定后的三级菜单
        //$this->checkAuth(); //验证用户是否有访问当前控制器的权限
        $this->assign('menu',$this->menu);
        $this->assign('userInfo',$this->userInfo);
    }

    public function isLogin(){
        if(!Session::has('userInfo')){
            $this->error('请先登录','User/index');
        }
        $this->userInfo = session::get('userInfo'); //保存用户信息
    }



    /**
     * 获取用户对应菜单---格式化后的三级菜单
    */
    public function userRoleAuth(){

        $menu = db('menu')->field('*')->order('level','asc')->select();
        $menu_bind = new \app\admin\logic\MenuBind($menu,[],1);
        //超级管理员显示所有菜单
        if($this->userInfo['is_super'] ==1){
            $admin_menu = require(ADMIN_MODULE . '/menu/menu.php');
            $this->menu = array_merge($menu_bind->getMenu(),$admin_menu);
            return true;
        }

        $menu_id = $this->menu_id;
        $menu_bind = new \app\admin\logic\MenuBind($menu,$menu_id,2);
        $auth_menu = $menu_bind->getMenu();
        if(count($auth_menu) > 0){
            $this->menu = $auth_menu;   //设置普通管理员的菜单
        }
    }

    /**
     * 保存普通管理员对应的菜单id;例[1,2 7]
    */
    public function setMenuID(){
        //下面是普通管理员
        $role_id = json_decode($this->userInfo['role_id'],true);
        if(!$role_id){
            return false;
        }
        $menu_id = db('role')
            ->field('menu_id')
            ->where('id','in',$role_id)
            ->select();

        if(!$menu_id){
            return false;
        }
        $id_str = '';
        foreach ($menu_id as $k=>$v){
            $id_str .= $v['menu_id'];
        }
        $menu_id = array_unique(explode(',',$id_str)); //用户对应的菜单id去重复[1,2 7]
        $this->menu_id = $menu_id;
    }

    /**
     * 验证权限
     * @param $no_check_ctl_act 无需验证的控制器和动作
    */
    public function checkAuth(){
        //超级管理员不用验证权限
        if($this->userInfo['is_super'] == 1){
            return true;
        }

        //默认可以访问控制器和动作
        if(isset($this->no_check_ctl_act[0]) && $this->no_check_ctl_act[0] && count($this->no_check_ctl_act[0]) > 0){
            foreach ($this->no_check_ctl_act as $k=>$v){
                if(strtolower($v['ctl']) == strtolower($this->current_ctl) && strtolower($v['act']) == strtolower($this->current_act) ){
                    return true;
                }
            }
        }

        $is_auth = false; //是否有访问当前ctl 和act和权限
        $menu_id = $this->menu_id;
        if(!$menu_id){
            return false;
        }
        $auth_menu = db('menu')->where('id','in',$menu_id)->select();
        if(!$menu_id){
            return false;
        }
        foreach ($auth_menu as $k=>$v){
            if(strtolower($v['ctl']) == strtolower($this->current_ctl) && strtolower($v['act']) == strtolower($this->current_act)){
                $is_auth = true;
            }
        }
        if(!$is_auth){
            exit('暂无权限');
        }
    }


    /**
     * 数据库是否添加了菜单
     */
    public function getDbMenu(){
        $menu = db('menu')->select();
        $this->menu = require(ADMIN_MODULE . '/menu/menu.php');
//        if(count($menu) > 0){
//            $this->dbMenu = $menu;
//            $this->setMenuFormat(); //转化菜单格式
//        }else{
//            $this->menu = require(ADMIN_MODULE . '/menu/menu.php');
//        }
    }


    public function setMenu(){
        return $this->dbMenu;
    }

    public function setCtlAct(){
        $request = Request::instance();
        $this->current_ctl = $request->controller();
        $this->current_act = $request->action();
    }

    /**
     * 增加或更新
     * $code 错误码
    */
    public function saveAjaxReturn($res,$code = 401){
        return $res > 0 ? $this->ajaxReturn() : $this->ajaxReturn([],$code,'失败');
    }

    public function ajaxReturn($data = [],$code = 0,  $msg = '成功'){
        exit(json_encode(['code'=>$code,'data'=>$data,'msg'=>$msg]));
    }

    /**
     * 获取当前主机地址和保存文件目录
    */
    public function getImgPrefix(){

    }
}

