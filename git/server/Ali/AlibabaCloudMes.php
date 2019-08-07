<?php

/*
 * 阿里云短信服务
 * */
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
class AlibabaCloudMes
{
    private $accessKeyId = 'LTAIEAShJvDWhxwX';
    private $accessKeySecret  = '6vJdbODkafom4AayushRjTkP2sN9PA';
    private $PhoneNumbers = "";
    private $loginTemplateCode = 'SMS_171859435'; //登录模版
    private $registerTemplateCode = 'SMS_172006017';//注册模版
    private $query = [
        'PhoneNumbers' =>'',
        'SignName' => "选个座平台",
        'TemplateCode' => "SMS_171859435",
        'TemplateParam' => '',
    ]; //option参数

    private $res = [];  //请求结果
    public function setRes($res){
        $this->res = $res;
    }
    public function getRes(){
        return $this->res;
    }
    /**
     * 发送短信
     * @param  $PhoneNumbers :手机号
     * @param  $code :验证码
     * @param $TemplateCode :login登录  register:注册
     */
    public  function sendSms($PhoneNumbers,$code,$TemplateCode = null) {
        $this->query['PhoneNumbers'] = $PhoneNumbers;
        $this->query['TemplateParam'] = '{code:'.$code.'}';
        if($TemplateCode = 'login'){
            $this->query['TemplateCode'] = $this->loginTemplateCode;
        }
        else if($TemplateCode='register'){
            $this->query['TemplateCode'] = $this->registerTemplateCode;
        }
        AlibabaCloud::accessKeyClient($this->accessKeyId, $this->accessKeySecret)
            ->regionId('cn-hangzhou')
            ->asDefaultClient();

        try {
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                // ->scheme('https') // https | http
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->options([
                    'query' => $this->query,
                ])
                ->request();
            $this->setRes($result->toArray());
        } catch (ClientException $e) {
            echo $e->getErrorMessage() . PHP_EOL;
        } catch (ServerException $e) {
            echo $e->getErrorMessage() . PHP_EOL;
        }
    }
}