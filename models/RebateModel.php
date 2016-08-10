<?php
/**
 * author: chenlong
 * Date: 2016/8/10
 * Time: 12:24
 */

namespace app\models;

use yii\db\ActiveRecord;

class RebateModel extends ActiveRecord
{
    //流水表
    public static function tableName()
    {
        return 'hhs_rebate_relation';
    }

    public function rules()
    {
        return [

            [['amount','user_id','flag','invite_id','status','time',], 'required']
        ];
    }


}