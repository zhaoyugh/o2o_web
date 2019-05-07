<?php
namespace MLIB;
/**
 * PHP 汉字转拼音
 */
class Sms {
    /**
     * 发送手机短信
     * @param unknown $mobile 手机号
     * @param unknown $content 短信内容
     */
    public function send($mobile,$content) {
        return $this->_sendEmay($mobile,$content);
    }

    /**
     * 亿美短信发送接口
     * @param unknown $mobile 手机号
     * @param unknown $content 短信内容
     */
    private function _sendEmay($mobile,$content) {

        set_time_limit(0);
        define('SCRIPT_ROOT',  LIBRARIESPATH . '/EMAY/');
        require_once SCRIPT_ROOT.'Client.php';
        /**
         * 网关地址
         */
        $gwUrl = \Swoole::$php->config['sms']['gwUrl'];
        /**
         * 序列号,请通过亿美销售人员获取
         */
        $serialNumber = \Swoole::$php->config['sms']['serialNumber'];
        /**
         * 密码,请通过亿美销售人员获取
         */
        $password = \Swoole::$php->config['sms']['password'];
        /**
         * 登录后所持有的SESSION KEY，即可通过login方法时创建
         */
        $sessionKey = \Swoole::$php->config['sms']['sessionKey'];
        /**
         * 连接超时时间，单位为秒
         */
        $connectTimeOut = 2;
        /**
         * 远程信息读取超时时间，单位为秒
         */
        $readTimeOut = 10;
        /**
        $proxyhost     可选，代理服务器地址，默认为 false ,则不使用代理服务器
        $proxyport     可选，代理服务器端口，默认为 false
        $proxyusername 可选，代理服务器用户名，默认为 false
        $proxypassword 可选，代理服务器密码，默认为 false
         */
        $proxyhost = false;
        $proxyport = false;
        $proxyusername = false;
        $proxypassword = false;
        $client = new EMAY\Client($gwUrl,$serialNumber,$password,$sessionKey,$proxyhost,$proxyport,$proxyusername,$proxypassword,$connectTimeOut,$readTimeOut);
        //$client->setNameSpace('EMAY');
        /**
         * 发送向服务端的编码，如果本页面的编码为GBK，请使用GBK
         */
        $client->setOutgoingEncoding("UTF-8");
//         $statusCode = $client->login();
//        if ($statusCode!=null && $statusCode=="0") {
//        } else {
//            //登录失败处理
//            //echo "登录失败,返回:".$statusCode;exit;
//        }
        $statusCode = $client->sendSMS(array($mobile),\Swoole::$php->config['sms']['prefixStr'] . $content);
        if ($statusCode!=null && $statusCode=="0") {
            return true;
        } else {
            return false;
//             print_R($statusCode);
//             echo "处理状态码:".$statusCode;
        }
    }
}
