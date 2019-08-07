<?php
class code{
    //生成纯数字验证码
    public function numberCode($weishu = 4){
        $code = '';
        for($i=0;$i<$weishu;$i++){
            $code .= rand(0,9);
        }
        return $code;
    }
}