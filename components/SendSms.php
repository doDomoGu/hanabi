<?php
namespace app\components;
include_once '../extensions/aliyun-sdk-sms/aliyun-php-sdk-core/Config.php';

use Sms\Request\V20160927 as Sms;
use DefaultProfile;
use DefaultAcsClient;
use ClientException;
use ServerException;
use yii\base\Component;
use yii;

class SendSms extends Component {
    public $client;
    public $sign;
    public $templateCode;
    public $mobile;
    public $param;

    public function __construct(array $config=[])
    {
        parent::__construct($config);

        $config = Yii::$app->params['aliyun_sms_config'];
        $this->sign = $config['sign'];
        $iClientProfile = DefaultProfile::getProfile($config['regionId'],$config['accessKey'], $config['accessSecret']);
        $this->client = new DefaultAcsClient($iClientProfile);
    }

    public function sendByRegVerifyCode($mobile,$code){
        $this->templateCode = 'SMS_18820006';
        $this->mobile = $mobile;
        $product = 'sdadsa';

        $this->param = "{\"code\":\"$code\",\"product\":\"$product\"}";


        $this->send();

    }

    public function send(){

        $request = new Sms\SingleSendSmsRequest();

        $request->setSignName($this->sign);/*签名名称*/
        $request->setTemplateCode($this->templateCode);/*模板code*/
        $request->setRecNum($this->mobile);/*目标手机号*/
        $request->setParamString($this->param);/*模板变量，数字一定要转换为字符串*/
        try {
            $response = $this->client->getAcsResponse($request);
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
