<?php
/**
 * @Author: oj
 * @Date: 2016/3/16
 * @Time: 17:30
 */

namespace app\models;

use yii;
use app\models\Auth_item_childModel;

class Auth_itemModel extends BaseModel
{

    public function rules()
    {
        return array(
            [['name'], 'unique','message' => '此名称已经被占用.','on'=>'create,update'],
//            [['字段名'],required,'requiredValue'=>'必填值','message'=>'提示信息']
//            ['name','filter','filter'=>'trim'],
//            [ 'name', 'unique', 'targetClass' => '\app\models\Auth_itemModel', 'message' => '此名称已经被占用.','on'=>self::scenarios_create],
//            [ 'type', 'integer'],
//            [[ 'name', 'description'], 'string', 'max'=>25]
        );
    }
//    public function checktagname($attribute,$params){
//        $oldtag = $this::model()->findByAttributes(array('tagname'=>$this->tagname));
//        if($oldtag->tagid > 0){
//            $this->addError($attribute, '该权限&角色已经存在!');
//        }
//    }

//    public function attribute()
//    {
//        return array(
//            'name' => '名称',
//        );
//    }


    public static function tableName(){
        return '{{auth_item}}';
    }


    /**
     * @desc获取编辑的权限&角色信息
     * @param $name 权限&角色的名字
     * @return $this 返回自身对象
     * @throws \Exception
     */
    public function get_item($name)
    {
        $model = $this::findOne(['name' => $name]);

        if (!$model) {
            throw new \Exception('编辑的角色或权限不存在！');
        }
        if($model->type == 2 or $model->type == 4){
            $this->parent_menu = $model->parent_menu;
            $this->is_show = $model->is_show;
        }
        $this->name = $model->name;
        $this->type = $model->type;
        $this->show_name = $model->show_name;
        $this->description = $model->description;
        $this->created_at = $model->created_at;

        return $this;
    }

    /**
     * @desc获取所有权限
     * @param $name
     * @return array|yii\db\ActiveRecord[]
     */
    public function get_permission($condition){
        $query = Auth_item_childModel::find()->where($condition);
        $permissions = $query->asArray()->all();
        return $permissions;
    }


}