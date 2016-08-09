<?php

/**
 * author: chenlong
 * Date: 2016/8/4
 * Time: 16:33
 */
namespace app\modules\task\controllers;

use app\controllers\CommonController;
use app\models\TaskModel;
use Yii;
use Functions;

class IndexController extends CommonController
{
    /*
     * @desc 任务列表
     */
    public  function  actionIndex(){
        $page=$this->get_page_value();
        $taskModel= new TaskModel();
        $data= $taskModel->getPage($taskModel->find(),$page[0],$page[1]);
        return $this->renderPartial("index",["data"=>$data]);
    }



    /**
     * @desc 任务编辑
     * @return string
     */
    public  function  actionEdit(){
        $id=Yii::$app->request->get("id");
        $post=Yii::$app->request->post();
        $taskModel= new TaskModel();
        if(empty($post)){
            $data= $taskModel->find()->where(["id"=>$id])->asArray()->one();
            $task_level=Yii::$app->params["task_level"];
            $data["level"]=$task_level;
            return $this->renderPartial("edit",["data"=>$data]);
        }
        $result=$taskModel->findOne(["id"=>$post["id"]]);
        foreach($post as $key=>$value){
            if($key!="id"){
                $result->$key=$value;
            }
        }
       if($result->save()){
            return Functions::return_json(200,"修改成功","","index_id_index","closeCurrent");
       }else{
           Functions::dwz_json(300,"修改失败，请重试","index_id_index","closeCurrent");
       }

    }


    /**
     * @desc 任务添加
     * @return string
     */
    public  function  actionAdd(){
        $post=Yii::$app->request->post();
        if(empty($post)){
            $task_level=Yii::$app->params["task_level"];
            $data["level"]=$task_level;
            return $this->renderPartial("add",["data"=>$data]);
        }

        $taskModel=new TaskModel();
        foreach($post as $key=>$value){
            if(empty($value)){
                Functions::dwz_json(300,"参数不完整，请确认后再添加");
            }
            $taskModel->$key=$value;
        }
        if($taskModel->save()){
            return Functions::return_json(200,"添加成功","","index_id_index","closeCurrent");
        }else{
            Functions::dwz_json(300,"修改失败，请重试");
        }

    }

    /**
     * @desc 删除任务
     * @return string
     */
    public  function  actionDelete(){
        $id=Yii::$app->request->get("id");
        $taskModel=new TaskModel();
        $result= $taskModel->deleteAll(["id"=>$id]);
        if($result>0){
            return Functions::return_json(200,"删除成功");
        }
        Functions::dwz_json(300,"删除失败");
    }

}