<?php
namespace app\admin\logic;
class Code{
    private $word = [
        'A','B','C','D','E','F','G','H','I','J',
        'K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'
    ];
    private $ratio  = 2;   //字母和数字的比例
    private $res    = [];  //生成的验证码 假设$weishu数等于6['ABC123','BAC123']可随机打乱
    private $rand_min = 1; //验证码开始范围
    private $rand_max = 9; //验证码结束范围

    /**
     * 验证码的位数必须大于1
     * @param  $no_arr :禁止生成的验证码：二维数组
     * @param  $no_arr_ke: $no_arr的key 例如：$no_arr[0]['code']
     * @param  $weishu :验证的位数
     * @param  $code_count :生成多少个验证码
     * @return $res
    */
    public function __construct($weishu,$code_count,$no_arr = [],$no_arr_key = 'code'){
        $yu = 0;        //可为数字也可为字母
        $word_num = 0; //单词位数
        $number = 0;   //数字位数
        if($weishu % 2 == 0){
            $word_num  = $weishu / $this->ratio;
            $number = $weishu / $this->ratio;
        }
        else if ($weishu % 2 == 1){
            $word_num  = ($weishu -1) / $this->ratio;
            $number = ($weishu -1) / $this->ratio;
            $yu = 1;
        }

        while (count($this->res) != $code_count){
            $code = $this->createCode($word_num,$number,$yu);
            $code = str_shuffle($code);//打乱验证码
            if($no_arr && $this->is_no_code($no_arr,$no_arr_key,$code)){
                continue;
            }
            if(in_array($code,$this->res)){
                continue;
            }
            array_push($this->res,$code);
        }
    }

    public function createCode($word_num,$number,$yu){
        $str = '';
        for($i=1;$i<=$word_num;$i++){
            $str .= $this->word();
        }
        for($i=1;$i<=$number;$i++){
            $str .= $this->number();
        }
        if($yu > 0){
            $str .= $this->yu();
        }
        return $str;
    }

    //生成单词
    public function word(){
        $word_length = count($this->word) -1 ;
        $rand = rand(0,$word_length);
        return $this->word[$rand]; //返回某个单词
    }

    //生成数字
    public function number(){
        $rand = rand($this->rand_min,$this->rand_max);
        return $rand;//返回数字
    }

    //余数
    public function yu(){
        $rand = rand($this->rand_min,$this->rand_max);
        return $rand;
    }

    //是否是禁止的验证码
    public function is_no_code($no_arr,$no_arr_key,$code){
        foreach ($no_arr as $k=>$v){
            if($v[$no_arr_key] == $code){
                return true;
            }
        }
        return false;
    }

    //获取验证码数组
    public function getRes(){
        return $this->res;
    }

}