<?php
namespace app\admin\controller;
class Upload extends Base{
    public function upload(){
        $upload = new \app\admin\logic\Upload();
        $is_upload = $upload->upload();
        if($is_upload){
            $this->ajaxReturn($upload->getSaveName());
        }else{
            $this->ajaxReturn([],401,$upload->getError());
        }
    }
}