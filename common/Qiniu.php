<?php
/**
 * author: chenlong
 * Date: 2016/8/11
 * Time: 15:37
 */

namespace app\common;


use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use Yii;

class Qiniu
{
    /**
     * @param $file_path 文件路径
     * @param $bucket 空间名称
     * @return bool|string
     * @throws \Exception
     */

    public static function qiniu_upload($file_path, $bucket)
    {

        $qiniu_params = Yii::$app->params['qiniu_params'];
        //下载地址
        $qiniu_picture_domain = $qiniu_params["qiniu_domain"];
        $accessKey = $qiniu_params['accessKey'];
        $secretKey = $qiniu_params['secretKey'];
        $auth = new Auth($accessKey, $secretKey);

        $uptoken = $auth->uploadToken($bucket, null, 3600);

        //上传文件的本地路径
        $filePath = $file_path;
        $uploadMgr = new UploadManager();

        list($ret, $err) = $uploadMgr->putFile($uptoken, null, $filePath);
        if ($err !== null) {
            return false;
        }
        return $qiniu_picture_domain ."/". $ret['key'];
    }


    /**
     * @desc 私有空间获得加密url
     * @param $Url
     * @return string
     */
    public function qiniu_get_tooken_url($Url)
    {

        $qiniu_params = yii::$app->params['qiniu_params'];
        $accessKey = $qiniu_params['accessKey'];
        $secretKey = $qiniu_params['secretKey'];
        $auth = new Auth($accessKey, $secretKey);
        $tokenUrl = $auth->privateDownloadUrl($Url);
        return $tokenUrl;

    }

}