<?php
/**
 * @Author: oj
 * @Date: 2016/3/16
 * @Time: 17:30
 */

namespace app\models;

use yii;
use app\models\BaseModel;
use yii\db\ActiveRecord;

class Auth_item_childModel extends ActiveRecord
{


    public static function tableName()
    {
        return '{{auth_item_child}}';
    }

    public function rules()
    {
        return array(
            [['parent', 'child'], 'required'],
//            ['name','filter','filter'=>'trim'],
//            [ 'name', 'unique', 'targetClass' => '\app\models\Auth_itemModel', 'message' => '此名称已经被占用.','on'=>self::scenarios_create],
//            [ 'type', 'integer'],
//            [[ 'name', 'description'], 'string', 'max'=>25]
        );
    }

    public function attributeLabels()
    {
        return [
            'parent' => '父权限',
            'child' => '子权限',

        ];

    }
}