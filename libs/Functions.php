<?php

class Functions
{

    /**
     * 生成guid
     * @return string
     */
    public static function guid()
    {
        mt_srand((double)microtime() * 10000);
        $charid = strtolower(md5(uniqid(rand(), true)));
        $uuid = substr($charid, 0, 8) . substr($charid, 8, 4) . substr($charid, 12, 4) . substr($charid, 16, 4) . substr($charid, 20, 12);
        return $uuid;
    }

    /**
     * 格式化输出
     * @param string $str
     * @param string $e
     */
    public static function pre($str, $e = true)
    {
        echo "<pre>";
        print_r($str);
        echo "</pre>";

        if ($e) {
            exit;
        }
    }

    /**
     * 调试日志记录
     * @param unknown $message
     */
    public static function debug_log($message)
    {
        $logfile = Yii::$app->basePath . '/runtime/' . date("Ymd") . ".log";
        $time = date("Y-m-d H:i:s", time());
        $fp = @fopen($logfile, 'a');
        @fwrite($fp, $time . "\r\n");
        @fwrite($fp, var_export($message, true) . "\r\n" . "\r\n");
        @fclose($fp);
    }

    /**
     * 系统提示
     * @param string $msg
     * @param int $type
     * @param string $url
     */
    public static function alert($msg = 'null', $type = 1, $url = 'null')
    {
        echo '<script>';
        echo 'alert("' . $msg . '");';
        if ($type == 1) {
            echo 'location.href="' . $url . '"';
        } elseif ($type == 2) {
            echo 'history.back();';
        }
        echo '</script>';
    }

    /**
     * 处理json返回
     * @param number $status
     * @param string $message
     * @param array $params
     */
    public static function exit_json($status = 0, $message = null, $params = array())
    {
        exit(json_encode(array('status' => $status, 'message' => $message, 'params' => $params)));
    }

    /**
     * 处理json返回
     * @param number $status
     * @param string $message
     * @param array $params
     */
    public static function exit_api_json($status = 0, $message = null, $params = array())
    {
        exit(json_encode(array('code' => $status, 'msg' => $message, 'data' => $params)));
    }




    /**
     * 处理dwz返回数据格式
     * @param number $code
     * @param string $message
     * @param string $message
     * @param string $type
     * @param string $rel
     * @param string $callback
     * @param string $reload
     */
    public static function dwz_json($code = 300, $message = '系统错误!', $type = '', $rel = '', $callback = 'closeCurrent', $reload = '')
    {
        $array = ["statusCode" => $code, "message" => $message, "navTabId" => $type, "rel" => $rel, "callbackType" => $callback, "forwardUrl" => $reload];
        exit(json_encode($array));
    }

    /**
     * 处理返回数据格式
     * @param number $code
     * @param string $message
     * @param string $type
     * @param string $result
     * @param string $callback
     * @param string $reload
     */
    public static function return_json($code = 300, $message = '系统错误!',$result=array(),$navTabId="",$callbackType="")
    {
        $array = ["statusCode" => $code, "message" => $message, "result"=>$result,"navTabId"=>$navTabId,"callbackType"=>$callbackType];
        return json_encode($array);
    }

    /**
     * 处理对外返回数据格式
     * @param number $code
     * @param string $message
     * @param string $type
     * @param string $result
     * @param string $callback
     * @param string $reload
     */
    public static function return_api_json($code = 300, $message = '系统错误!',$result=array())
    {
        $array = ["code" => $code, "msg" => $message, "data"=>$result];
        return json_encode($array);
    }


    /**
     * CURL Get方式获取接口数据
     * @param string $url
     * @param array $params
     * @param string $type
     * @return mixed
     */
    public static function curl_get_contents($url = null, $params = array(), $type = 'post')
    {

        $token = 'leyou_api_2016';
        $url_params = '';

        foreach ($params as $k => $v) {
            $url_params .= '&' . $k . '=' . $v;
        }
        $send_url = $url . $url_params;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $send_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $out_put = curl_exec($ch);
        curl_close($ch);
        return $out_put;
    }

    /**
     * @DESC CURL方式获取接口数据
     * @param string $url
     * @param string $data(POST)
     * @return mixed
     */
    public static function curl_post_contents($url = '', $data = '')
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $out_data = curl_exec($ch);
        curl_close($ch);

        return $out_data;
    }

}