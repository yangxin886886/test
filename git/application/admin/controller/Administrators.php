<?php
namespace app\admin\controller;
use think\Session;
class Administrators extends Base{
    public function  index(){
        $role = db('role')->select();
        $this->assign('role',$role);
        return $this->fetch();
    }

    public function getAdminList(){
        $where = [];
        $login_name = input('login_name');
        $phone = input('phone');
        $email = input('email');
        $role_id = input('role_id');
        if(!empty($login_name)){
            $where['login_name'] = ['like','%'.$login_name.'%'];
        }
        if(!empty($phone)){
            $where['phone'] = ['like','%'.$phone.'%'];
        }
        if(!empty($email)){
            $where['email'] = ['like','%'.$email.'%'];
        }
        if(!empty($role_id)){
            $where['role_id'] = ['like','%'.$role_id.'%'];
        }

        $data = db('user')->where($where)->select();
        $this->ajaxReturn($data);
    }


    public function adminAddView(){
        $data = db('role')->select();
        $this->assign('data',$data);
        return $this->fetch();
    }

    public function adminAdd(){
        $add['user_name'] = input('user_name');

        $add['login_name'] = input('login_name');
//        if(empty($add['login_name'])){
//            $this->ajaxReturn([],400,'登录名不能为空');
//        }

        $isUser = db('user')->where('login_name',$add['login_name'])->find();
        if(count($isUser) > 0){
            $this->ajaxReturn([],400,'该登录名已存在');
        }
        $add['pwd'] = input('pwd');
        if(!empty($add['pwd'])){
            $add['pwd'] = md5(md5($add['pwd']));
        }
        $add['phone'] = input('phone');
        if(empty($add['phone'])){
            $this->ajaxReturn([],400,'手机号不能为空');
        }
        $add['email'] = input('email');
        $role_id = input('roles/a');
        if(count($role_id) > 0){
            $add['role_id'] = json_encode($role_id);
        }
        $res = db('user')->insert($add);
        $res > 0 ? $this->ajaxReturn() : $this->ajaxReturn([],401,'失败');
    }

    public function adminEditView(){
        $data = db('role')->select();
        $this->assign('data',$data);

        $id = input('id');
        $user = db('user')->where('id',$id)->find();
        $role_id = [];
        if(count($user) > 0){
            $role_id = json_decode($user['role_id'],true);
        }
        $this->assign('role_id',$role_id);
        $this->assign('user',$user);

        return $this->fetch();
    }

    public function adminEdit(){
        $id = input('id');
        if(!$id || empty($id)){
            $this->ajaxReturn([],400,'id错误');
        }
        $update['user_name'] = input('user_name');

//        $update['login_name'] = input('login_name');
//        if(empty($update['login_name'])){
//            $this->ajaxReturn([],400,'登录名不能为空');
//        }

        $update['pwd'] = input('pwd');
        if(!empty($update['pwd'])){
            $isUpdatePwd = db('user')
                ->where('id',$id)
                ->where('pwd',$update['pwd'])
                ->find();
            //用户修改了密码
            if(count($isUpdatePwd) == 0 || !$isUpdatePwd){
                $update['pwd'] = md5(md5($update['pwd']));
            }
        }else{
            $this->ajaxReturn([],400,'密码不能为空');
        }

        $update['phone'] = input('phone');
        if(empty($update['phone'])){
            $this->ajaxReturn([],400,'手机号不能为空');
        }
        $update['email'] = input('email');
        $update['role_id'] = input('roles/a');
        if($update['role_id']){
            $update['role_id'] = json_encode($update['role_id']);
        }
        $res = db('user')->where('id',$id)->update($update);
        $res > 0 ? $this->ajaxReturn() : $this->ajaxReturn([],401,'失败');
    }

    //冻结用户
    public function adminLock(){
        $id = input('id'); //用户id
        if(empty($id)){
            $this->ajaxReturn([],400,'id错误');
        }
        $userInfo = Session::get('userInfo');
        if($userInfo['is_super'] != 1){
            $this->ajaxReturn([],401,'非超级管理员不能操作');
        }
        if($userInfo['is_super'] == 1 && $userInfo['id'] == $id){
            $this->ajaxReturn([],401,'无法冻结超级管理员');
        }
        $is_lock = db('user')->where('id',$id)->value('is_lock');
        $is_lock = intval($is_lock) == 0 ? 1 : 0;

        $res = db('user')->where('id',$id)->update(['is_lock'=>$is_lock]);
        return $res > 0 ? $this->ajaxReturn() : $this->ajaxReturn([],401,'失败');
    }
}