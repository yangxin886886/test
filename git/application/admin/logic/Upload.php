<?php
namespace app\admin\logic;
class Upload{
    private $fileName = null;   //上传文件的name
    private $filePath = null;  //文件保存路径
    private $error = null;     //错误信息
    private $saveName = null;  //20160820/42a79759f284b767dfcb2a0197904287.jpg
    public function __construct($fileName = 'file')
    {
        $this->fileName = $fileName;
        $this->filePath = ROOT_PATH . 'public' . DS . 'uploads';
    }

    public function upload(){
        $file = request()->file($this->fileName);
        if(!$file){
            $this->setError('获取文件时出错');
            return false;
        }

        $info = $file->move($this->filePath);
        if(!$info){
            $this->setError($file->getError());
            return false;

        }
        $this->setSaveName($info->getSaveName());
        return true;
    }

    public function setFilePath($path = ''){
        if(empty($path)){
            return false;
        }
        $this->filePath = $path;
    }

    public function setSaveName($save_name){
        $this->saveName = strtr($save_name,'\\','/');
    }

    public function getSaveName(){
        return $this->saveName;
    }

    public function setError($error){
        $this->error = $error;
    }

    public function getError(){
        return $this->error;
    }

}
