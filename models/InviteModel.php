<?php
/**
 * author: chenlong
 * Date: 2016/7/26
 * Time: 9:37
 */

namespace app\models;


class InviteModel extends  BaseModel
{

    const NORMAL=0; //正常的邀请码
    const ADMIN_TEMP=1; //管理员临时的邀请码
    const USER_TEMP=2; //团长临时的邀请码

    const STATUS_UNACTIVE=3003;//未激活
    const STATUS_UNUSED=3003;//未使用
    const STATUS_ACTIVE=3004; //已激活
    const STATUS_USED=3004; //已使用

    public static  function  tableName(){
        return "{{hhs_invite}}";
    }

    /**
     * @desc 查询总数
     * @param array $condition
     * @return int|string
     */
    public  function  select_count($where="",$andwhere="",$andFilerwhere=""){

             $data= $this->find()->where($where);

         if($andwhere){
             $data=$data->andWhere($andwhere);
         }
        if($andFilerwhere){
            $data=$data->andFilterWhere($andFilerwhere);
        }
        return $data->asArray()->count();
    }
}