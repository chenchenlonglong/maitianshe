<?php
/**
 * author: chenlong
 * Date: 2016/9/6
 * Time: 17:43
 */

namespace app\common;


use app\models\InviteModel;

class Invite
{
    /**
     * @desc 查询某人剩余邀请码数量
     * @param $user_id
     * @return int|string
     */
        public  static  function  get_residue_invite($user_id){
            $inviteModel= new InviteModel();
         return   $inviteModel->find()->where(["user_id"=>$user_id])->andWhere(["!=","invition_status",3005])->count();
        }
}