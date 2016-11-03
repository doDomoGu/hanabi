<?php
namespace app\components;
include_once 'aliyun-php-sdk-sms/aliyun-php-sdk-core/Config.php';
use Sms\Request\V20160927 as Sms;

use yii\base\Component;
use yii;

class SendSmsFunc extends Component {

    public function send(){
        $config = Yii::$app->params['aliyun_sms_config'];
        $accessKey = $config['accessKey'];
        $accessSecret = $config['accessSecret'];
        $sign = $config['sign'];
        $regionId = $config['regionId'];


        $sms_template_code = 'SMS_18820006';
        $mobile = '18017865582';
        $code = '911234';
        $product = 'ctexzc';



        $iClientProfile = DefaultProfile::getProfile($regionId, $accessKey, $accessSecret);
        $client = new DefaultAcsClient($iClientProfile);
        $request = new Sms\SingleSendSmsRequest();
        $request->setSignName($sign);/*签名名称*/
        $request->setTemplateCode($sms_template_code);/*模板code*/
        $request->setRecNum($mobile);/*目标手机号*/
        $request->setParamString("{\"code\":\"$code\",\"product\":\"$product\"}");/*模板变量，数字一定要转换为字符串*/
        try {
            $response = $client->getAcsResponse($request);
            print_r($response);
        }
        catch (ClientException  $e) {
            print_r($e->getErrorCode());
            print_r($e->getErrorMessage());
        }
        catch (ServerException  $e) {
            print_r($e->getErrorCode());
            print_r($e->getErrorMessage());
        }
    }

}
