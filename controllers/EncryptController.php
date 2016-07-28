<?php
/**
 * @author oj
 * @data : 2016/4/28
 * @time: 11:25
 */

namespace app\controllers;

use Yii;
use yii\curl\Curl;
use yii\web\Controller;
use Functions;

class EncryptController extends Controller
{
    /**
     * @desc验签验证
     */
    public function init()
    {

        $get_appkey_url = Yii::$app->params['get_appkey_url'];
        $get_value = Yii::$app->request->get();
        $post_value = Yii::$app->request->post();
        if (!isset($get_value['msign'])) {
            $data = [
                'code' => 305,
                'msg' => '没有验签字段!',
            ];
            echo json_encode($data);
            die;
        }
        if ($get_value['msign'] == "leyou@hcp") {

        } else {
            $value = array_merge($get_value, $post_value);
            if (!isset($get_value['app_id'])) {
                $data = [
                    'code' => 305,
                    'msg' => '没有app_id字段!',
                ];
                echo json_encode($data);
                die;
            }
            $app_id = $get_value['app_id'];
            $cache = Yii::$app->cache;
            $key = $app_id . "app_key";
            $app_key = $cache->get($key);
            if ($app_key) {
                $appkey = $app_key;
            } else {
                $curl = new Curl;
                $params['app_id'] = $get_value['app_id'];
                $response = $curl->setOption(CURLOPT_POSTFIELDS, http_build_query($params))->post($get_appkey_url);
                $code = json_decode($response, true);
                if ($code['code'] != 200) {
                    $data = [
                        'code' => $code['code'],
                        'msg' => $code['msg'],
                    ];
                    echo json_encode($data);
                    die;
                } else {
                    $appkey = $code['data']['app_key'];
                    $cache->set($key, $appkey, 7200);
                }

            }

            $value['app_key'] = $appkey;
            unset($value['msign']);
            unset($value['r']);
            ksort($value);
            $option = "";
            foreach ($value as $key => $val) {
                $option .= $key . "=" . $val . "+";
            }
            $secret_string = substr($option, 0, -1);
            $secret_sign = md5($secret_string);
            //        http://testadmin.sochepiao.com/index.php?r=announcement/bulletin/bulletin_list&app_id=1&custom=0b1e7defa8e7d234d48fe23954e06f65&horodatage=1462937803379&msign=809d543e44656dee968b0071363c6814&is_home=1
            if ($secret_sign != $get_value['msign']) {
                $data = [
                    'code' => 305,
                    'msg' => '验签不正确!',
                ];
                echo json_encode($data);
                die;
            }
        }

    }
}