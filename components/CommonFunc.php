<?php
namespace app\components;

use yii\base\Component;
use yii;

class CommonFunc extends Component {
    /*
     *  根据chars 和 length 生成随机字符串
     *  返回类型 string
     */
    public static function generateCode( $length = 8 ) {
        // 字符集，可任意添加你需要的字符
        $chars = 'klmnvXYojAB15w23LRSCD0GTUtuZMcdINOPxFHzabJpqrs4KyefghiVW67EQ89';
        $code = '';
        for ( $i = 0; $i < $length; $i++ )
        {
            // 这里提供两种字符获取方式
            // 第一种是使用 substr 截取$chars中的任意一位字符；
            // 第二种是取字符数组 $chars 的任意元素
            // $code .= substr($chars, mt_rand(0, strlen($chars) – 1), 1);
            $code .= $chars[ mt_rand(0, strlen($chars) - 1) ];
        }
        return $code;
    }

    // 6位数字验证码
    public static function generateVerifyCode($length = 6) {
        $chars = '0123456789';

	$code = '';
        for ( $i = 0; $i < $length; $i++ )
        {
            $code .= $chars[ mt_rand(0, strlen($chars) - 1) ];
        }
	return $code;
    }

    public static function fixZero($num){
        if($num<10){
            $return = '0000'.$num;
        }elseif($num<100){
            $return = '000'.$num;
        }elseif($num<1000){
            $return = '00'.$num;
        }elseif($num<10000){
            $return = '0'.$num;
        }else{
            $return = $num;
        }
        return $return;
    }

    public static function mySubstr($str,$len){
        $strlen = mb_strlen( $str, 'utf-8' );
        if($strlen>$len-2){
            $str = mb_substr( $str, 0, $len-1, 'utf-8' ).'...';
        }

        return $str;
    }

    public static function getGenderCn($gender){
        if($gender==1){
            return '男';
        }elseif($gender==2){
            return '女';
        }else{
            return 'N/A';
        }
    }

    public static function getStatusCn($status){
        if($status==1){
            return '正常';
        }elseif($status==0){
            return '<span style="color:red;">禁用</span>';
        }else{
            return 'N/A';
        }
    }
}
