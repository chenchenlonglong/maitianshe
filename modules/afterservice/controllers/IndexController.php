<?php

/**
 * author: chenlong
 * Date: 2016/10/27
 * Time: 9:51
 */
namespace app\modules\afterservice\controllers;

use app\common\Qiniu;
use app\controllers\CommonController;
use app\models\AfterserviceModel;
use app\models\GoodsModel;
use app\models\Order_goodsModel;
use app\models\Order_infoModel;
use Functions;
use Yii;
use yii\web\UploadedFile;


class IndexController extends CommonController
{

    public $enableCsrfValidation = false;

    /**
     * @desc 列表
     * @return string
     */
    public  function actionIndex(){
        $model= new AfterserviceModel();
        $page_info= $this->get_page_value();
        $phone=Yii::$app->request->post("phone");

        $order_id=Yii::$app->request->post("order_id");
        $result=Yii::$app->request->post("result");
        $where=[
            "phone"=>$phone,
            "order_id"=>$order_id,
            "result"=>$result,
        ];
        if($where){
          $data=  $model->getPage($model->find(),$page_info[0],$page_info[1]," id desc ",$where);
        }else{
            $data= $model->getPage($model->find(),$page_info[0],$page_info[1]," id desc ");
        }
        return $this->renderPartial("index",["data"=>$data,"where"=>$where]);

    }

    /**
     * @desc 调出订单详情
     * @return string
     */
    public  function actionAdd(){
        $order_id=Yii::$app->request->post("order_id");
        if(empty($order_id)){
            return $this->renderPartial("add_order_id");
        }

        $order_info=Order_infoModel::find()->select(["consignee","mobile","invoice_no"])->where(["order_id"=>$order_id])->asArray()->one();

        $goods_info=Order_goodsModel::find()->select(["goods_id","goods_name"])->where(["order_id"=>$order_id])->asArray()->one();


        if(empty($order_info) || empty($goods_info)){
            Functions::dwz_json(300,"无此订单号");
        }

        $goods_sn=GoodsModel::find()->select(["maitian_goods_sn"])->where(["goods_id"=>$goods_info["goods_id"]])->asArray()->one();

        $consignee=$order_info["consignee"];
        $mobile=$order_info["mobile"];
        $invoice_no=$order_info["invoice_no"];
        $goods_name=$goods_info["goods_name"];

        $model=new AfterserviceModel();

        return $this->renderPartial("add",["order_id"=>$order_id,
            "mobile"=>$mobile,"invoice_no"=>$invoice_no,
            "receive_name"=>$consignee,"goods_name"=>$goods_name,"model"=>$model,
            "goods_sn"=>$goods_sn["maitian_goods_sn"]]);
    }


    /**
     * @desc 添加
     * @return string
     */
    public function  actionEdit(){
        $post=Yii::$app->request->post();

        $afterModel= new AfterserviceModel();


        $afterModel->order_id=$post["order_id"];
        $afterModel->goods_sn=$post["goods_sn"];
        $afterModel->goods_name=$post["goods_name"];
        $afterModel->receive_name=$post["receive_name"];
        $afterModel->phone=$post["mobile"];
        $afterModel->wx_name=$post["wx_name"];
        $afterModel->start_time=strtotime($post["start_time"]);
        $afterModel->invoice_no=$post["invoice_no"];
        $afterModel->compensate_money=$post["compensate_money"];
        $afterModel->description=$post["description"];
        $afterModel->remark=$post["remark"];
        $afterModel->result=0;

        $image1 =UploadedFile::getInstance($afterModel, "image_1_url");
        $image2 =UploadedFile::getInstance($afterModel, "image_2_url");
        $image3 =UploadedFile::getInstance($afterModel, "image_3_url");


        if($image1){
            if(!in_array($image1->type,Yii::$app->params["image_allow"])){
                return    Functions::return_json(300,"文件格式不正确");
            }
            $img_url_1=Qiniu::qiniu_upload($image1->tempName,Yii::$app->params["qiniu_params"]["qr_code_path"]);
            $afterModel->image_1_url=$img_url_1;
        }
        if($image2){
            if(!in_array($image2->type,Yii::$app->params["image_allow"])){
                return    Functions::return_json(300,"文件格式不正确");
            }
            $img_url_2=Qiniu::qiniu_upload($image2->tempName,Yii::$app->params["qiniu_params"]["qr_code_path"]);
            $afterModel->image_2_url=$img_url_2;
        }
        if($image3){
            if(!in_array($image3->type,Yii::$app->params["image_allow"])){
                return    Functions::return_json(300,"文件格式不正确");
            }
            $img_url_3=Qiniu::qiniu_upload($image3->tempName,Yii::$app->params["qiniu_params"]["qr_code_path"]);
            $afterModel->image_3_url=$img_url_3;
        }

        if($afterModel->save()){
         return   Functions::return_json(200,"添加成功","","","index_id_index");
        }
         return    Functions::return_json(300,"添加失败");
    }

    /**
     * @desc 完成售后
     */
    public  function  actionPush(){
        $id=Yii::$app->request->get("id");
        $model= new AfterserviceModel();
        $result= $model->updateAll(["result"=>1,"finish_time"=>time()],["id"=>$id]);
        if($result>0){
            return Functions::return_json(200,"提交成功");
        }
        return Functions::return_json(300,"提交失败，请重试");
    }

    /**
     * @desc 修改
     * @return string
     */
    public  function actionChange(){
        $id=Yii::$app->request->get("id");
        $Model= new AfterserviceModel();
        if($id){
            $result=AfterserviceModel::find()->where(["id"=>$id])->asArray()->one();
            if(empty($result)){
                 Functions::dwz_json("300","数据异常");
            }
            return $this->renderPartial("change",["data"=>$result,"model"=>$Model]);
        }
        $post=Yii::$app->request->post();

        $afterModel=$Model->findOne(["id"=>$post["id"]]);

        $afterModel->wx_name=$post["wx_name"];
        $afterModel->compensate_money=$post["compensate_money"];
        $afterModel->description=$post["description"];
        $afterModel->remark=$post["remark"];


        $image1 =UploadedFile::getInstance($Model, "image_1_url");
        $image2 =UploadedFile::getInstance($Model, "image_2_url");
        $image3 =UploadedFile::getInstance($Model, "image_3_url");
        if($image1){
            if(!in_array($image1->type,Yii::$app->params["image_allow"])){
                return    Functions::return_json(300,"文件格式不正确");
            }
            $img_url_1=Qiniu::qiniu_upload($image1->tempName,Yii::$app->params["qiniu_params"]["qr_code_path"]);
            $afterModel->image_1_url=$img_url_1;
        }
        if($image2){
            if(!in_array($image2->type,Yii::$app->params["image_allow"])){
                return    Functions::return_json(300,"文件格式不正确");
            }
            $img_url_2=Qiniu::qiniu_upload($image2->tempName,Yii::$app->params["qiniu_params"]["qr_code_path"]);
            $afterModel->image_2_url=$img_url_2;
        }
        if($image3){
            if(!in_array($image3->type,Yii::$app->params["image_allow"])){
                return    Functions::return_json(300,"文件格式不正确");
            }
            $img_url_3=Qiniu::qiniu_upload($image3->tempName,Yii::$app->params["qiniu_params"]["qr_code_path"]);
            $afterModel->image_3_url=$img_url_3;
        }

        if($afterModel->save()){
            return Functions::return_json(200,"修改成功");
        }
        return Functions::return_json(200,"修改失败，请稍后再试");

    }

    /**
     * @desc 详情
     * @return string
     */
    public  function  actionDetail(){
        $id=Yii::$app->request->get("id");
        $Model= new AfterserviceModel();
        $result=AfterserviceModel::find()->where(["id"=>$id])->asArray()->one();
            if(empty($result)){
                Functions::dwz_json("300","数据异常");
            }
            return $this->renderPartial("detail",["data"=>$result,"model"=>$Model]);

    }


}