<?php

/**
 * Author: ty
 * Date: 2016/3/28
 * Time: 14:20
 */
namespace app\common;
use app\models\AdminrelationModel;
use app\models\OrderModel;
use yii;
use app\models\RebateModel;
use app\models\ReduceModel;
use app\models\InviteModel;
use app\models\UserModel;

class Statistics
{
    /**
     * @desc:统计一共(收入)可提取金额
     * @param $user_id
     * @param int $start_time 时间戳
     * @param int $end_time 时间戳
     * @return int;
     */
    public static function count_true_money($user_id,$flag = 0,$start_time = 0,$end_time = 0){
        $rebateModel = new RebateModel();
        if($flag == 0) {
            if ($start_time == 0 && $end_time != 0) {
                $true_money_data = $rebateModel->find()->where(['user_id' => $user_id])
                    ->andWhere(['<=', 'time', $end_time])
                    ->andWhere(['status' => 3004])
                    ->asArray()
                    ->all();
            } elseif ($start_time != 0 && $end_time == 0) {
                $true_money_data = $rebateModel->find()->where(['user_id' => $user_id])
                    ->andWhere(['>=', 'time', $start_time])
                    ->andWhere(['status' => 3004])
                    ->asArray()
                    ->all();

            } elseif ($end_time != 0 && $end_time != 0) {
                $true_money_data = $rebateModel->find()->where(['user_id' => $user_id])
                    ->andWhere(['>=', 'time', $start_time])
                    ->andWhere(['<=', 'time', $end_time])
                    ->andWhere(['status' => 3004])
                    ->asArray()
                    ->all();
            } else {
                $true_money_data = $rebateModel->find()->where(['user_id' => $user_id])
                    ->andWhere(['status' => 3004])
                    ->asArray()
                    ->all();
            }
        }else{
            if ($start_time == 0 && $end_time != 0) {
                $true_money_data = $rebateModel->find()->where(['user_id' => $user_id])
                    ->andWhere(['<=', 'time', $end_time])
                    ->andWhere(['status' => 3004])
                    ->andWhere(['flag' => $flag])
                    ->asArray()
                    ->all();
            } elseif ($start_time != 0 && $end_time == 0) {
                $true_money_data = $rebateModel->find()->where(['user_id' => $user_id])
                    ->andWhere(['>=', 'time', $start_time])
                    ->andWhere(['status' => 3004])
                    ->andWhere(['flag' => $flag])
                    ->asArray()
                    ->all();

            } elseif ($end_time != 0 && $end_time != 0) {
                $true_money_data = $rebateModel->find()->where(['user_id' => $user_id])
                    ->andWhere(['>=', 'time', $start_time])
                    ->andWhere(['<=', 'time', $end_time])
                    ->andWhere(['status' => 3004])
                    ->andWhere(['flag' => $flag])
                    ->asArray()
                    ->all();
            } else {
                $true_money_data = $rebateModel->find()->where(['user_id' => $user_id])
                    ->andWhere(['status' => 3004])
                    ->andWhere(['flag' => $flag])
                    ->asArray()
                    ->all();
            }
        }

        $total_true_money = 0;
        foreach($true_money_data as $value){
            $total_true_money += $value['amount'];
        }

        return $total_true_money;
    }

    /**
     * @desc:统计冻结金额
     * @param $user_id
     * @param int $start_time
     * @param int $end_time
     * @return int;
     */
    public static function count_forzen_money($user_id,$flag = 0,$start_time = 0,$end_time = 0){
        $rebateModel = new RebateModel();
        if($flag == 0) {
            if ($start_time == 0 && $end_time != 0) {
                $forzen_money_data = $rebateModel->find()->where(['user_id' => $user_id])
                    ->andWhere(['<=', 'time', $end_time])
                    ->andWhere(['status' => 3003])
                    ->asArray()
                    ->all();
            } elseif ($start_time != 0 && $end_time == 0) {
                $forzen_money_data = $rebateModel->find()->where(['user_id' => $user_id])
                    ->andWhere(['>=', 'time', $start_time])
                    ->andWhere(['status' => 3003])
                    ->asArray()
                    ->all();

            } elseif ($end_time != 0 && $end_time != 0) {
                $forzen_money_data = $rebateModel->find()->where(['user_id' => $user_id])
                    ->andWhere(['>=', 'time', $start_time])
                    ->andWhere(['<=', 'time', $end_time])
                    ->andWhere(['status' => 3003])
                    ->asArray()
                    ->all();
            } else {
                $forzen_money_data = $rebateModel->find()->where(['user_id' => $user_id])
                    ->andWhere(['status' => 3003])
                    ->asArray()
                    ->all();
            }
        }else{
            if ($start_time == 0 && $end_time != 0) {
                $forzen_money_data = $rebateModel->find()->where(['user_id' => $user_id])
                    ->andWhere(['<=', 'time', $end_time])
                    ->andWhere(['status' => 3003])
                    ->andWhere(['flag' => $flag])
                    ->asArray()
                    ->all();
            } elseif ($start_time != 0 && $end_time == 0) {
                $forzen_money_data = $rebateModel->find()->where(['user_id' => $user_id])
                    ->andWhere(['>=', 'time', $start_time])
                    ->andWhere(['status' => 3003])
                    ->andWhere(['flag' => $flag])
                    ->asArray()
                    ->all();

            } elseif ($end_time != 0 && $end_time != 0) {
                $forzen_money_data = $rebateModel->find()->where(['user_id' => $user_id])
                    ->andWhere(['>=', 'time', $start_time])
                    ->andWhere(['<=', 'time', $end_time])
                    ->andWhere(['status' => 3003])
                    ->andWhere(['flag' => $flag])
                    ->asArray()
                    ->all();
            } else {
                $forzen_money_data = $rebateModel->find()->where(['user_id' => $user_id])
                    ->andWhere(['status' => 3003])
                    ->andWhere(['flag' => $flag])
                    ->asArray()
                    ->all();
            }
        }

        $total_forzen_money = 0;
        foreach($forzen_money_data as $value){
            $total_forzen_money += $value['amount'];
        }

        return $total_forzen_money;
    }
    /**
     *  @desc:得到管理员的团队总累计成团数
     * @param $admin_id
     * @return int
     */
    public static function get_admin_team_num($admin_id){
        $count_finish_team=0;
        $user_ids=AdminrelationModel::find()->where(['admin_id'=>$admin_id])->all();
        foreach($user_ids as $k=>$v){
            $count_finish_team+=Statistics::count_finish_team($v['head_id']);//成团数
        }
        return $count_finish_team;
    }

    /**
     * @desc:查看某人的开团成功数量
     * @param $user_id
     * @param int $start_time
     * @param int $end_time
     * @return int|string
     */
    public static function count_finish_team($user_id,$start_time = 0,$end_time = 0){

        $model = new OrderModel();
        if($start_time != 0 && $end_time == 0){
            $finish_team = $model->find()
                ->where(['team_status'=>2])
                ->andWhere(['user_id' => $user_id])
                ->andWhere(['>=', 'add_time', $start_time])
                ->asArray()
                ->count();
        }elseif($start_time == 0 && $end_time != 0){
            $finish_team = $model->find()
                ->where(['team_status'=>2])
                ->andWhere(['user_id' => $user_id])
                ->andWhere(['<=', 'add_time', $end_time])
                ->asArray()
                ->count();
        }elseif($start_time != 0 && $end_time != 0){
            $finish_team = $model->find()
                ->where(['team_status'=>2])
                ->andWhere(['user_id' => $user_id])
                ->andWhere(['>=', 'add_time', $start_time])
                ->andWhere(['<=', 'add_time', $end_time])
                ->asArray()
                ->count();
        }else{
            $finish_team = $model->find()
                ->where(['team_status'=>2])
                ->andWhere(['user_id' => $user_id])
                ->asArray()
                ->count();
        }

        return $finish_team;
    }

    /**
     * @desc:查看某人的(开团数量)
     * @param $user_id
     * @param int $start_time
     * @param int $end_time
     * @return int|string
     */
    public static function count_create_team($user_id,$start_time = 0,$end_time = 0){

        $model = new OrderModel();
        if($start_time != 0 && $end_time == 0){
            $finish_team = $model->find()
                ->andWhere(['team_first'=>1])
                ->andWhere(['user_id' => $user_id])
                ->andWhere(['>=', 'add_time', $start_time])
                ->asArray()
                ->count();
        }elseif($start_time == 0 && $end_time != 0){
            $finish_team = $model->find()
                ->andWhere(['team_first'=>1])
                ->andWhere(['user_id' => $user_id])
                ->andWhere(['<=', 'add_time', $end_time])
                ->asArray()
                ->count();
        }elseif($start_time != 0 && $end_time != 0){
            $finish_team = $model->find()
                ->andWhere(['team_first'=>1])
                ->andWhere(['user_id' => $user_id])
                ->andWhere(['>=', 'add_time', $start_time])
                ->andWhere(['<=', 'add_time', $end_time])
                ->asArray()
                ->count();
        }else{
            $finish_team = $model->find()
                ->andWhere(['team_first'=>1])
                ->andWhere(['user_id' => $user_id])
                ->asArray()
                ->count();
        }

        return $finish_team;
    }



    /**
     * @desc:计算用户剩余可以提现的资金(一共收入的提现资金减去已经提取得提现资金，就为用户可以剩余可以提现的资金)
     * @param $user_id
     * @param int $flag
     * @param int $start_time
     * @param int $end_time
     * @return int
     */
    public static function count_tatal_true_money($user_id,$flag = 0,$start_time = 0,$end_time = 0){
        //计算总共进入多少提现资金
        $true_in_money = Statistics::count_true_money($user_id,$flag,$start_time,$end_time);
        //计算总共支出多少提现资金
        $true_out_money = Statistics::reduce_total_money($user_id);
        return $true_in_money-$true_out_money;
    }

    /**
     * @desc:计算用户已提现金额(支出)
     * @param $user_id
     * @return int
     */
    public static function reduce_total_money($user_id){
        $Reduce =new ReduceModel();
        $reduce_total=  $Reduce->find()->where(["user_id"=>$user_id,"flag"=>3004])->andWhere(["!=","audit_time",""])->asArray()->all();
        $total=0;
        if($reduce_total){
            foreach($reduce_total as $k=>$v){
                $total+=intval($v['amount']);
            }
            return $total;
        }else{
            return $total;
        }
    }



    /**
     * @desc:邀请人数统计
     */
    public static function invite_person_num($user_id,$user_level,$start_time = 0,$end_time = 0){
        $invite_model = new InviteModel();

        if($start_time != 0 && $end_time == 0){
            if($user_level == 2){
                $num = $invite_model->find()
                    ->where(['user_by_id' => $user_id])
                    ->andWhere(['invition_status' => 3005])
                    ->andWhere(['>=', 'active_time', $start_time])
                    ->asArray()
                    ->count();
            }elseif($user_level == 3){
                $num = $invite_model->find()
                    ->where(['user_id' => $user_id])
                    ->andWhere(['user_by_id' => 0])
                    ->andWhere(['invition_status' => 3005])
                    ->andWhere(['>=', 'active_time', $start_time])
                    ->asArray()
                    ->count();
            }
        }elseif($start_time == 0 && $end_time != 0){
            if($user_level == 2){
                $num = $invite_model->find()
                    ->where(['user_by_id' => $user_id])
                    ->andWhere(['invition_status' => 3005])
                    ->andWhere(['<=', 'active_time', $end_time])
                    ->asArray()
                    ->count();
            }elseif($user_level == 3){
                $num = $invite_model->find()
                    ->where(['user_id' => $user_id])
                    ->andWhere(['user_by_id' => 0])
                    ->andWhere(['invition_status' => 3005])
                    ->andWhere(['<=', 'active_time', $end_time])
                    ->asArray()
                    ->count();
            }
        }elseif($start_time != 0 && $end_time != 0){
            if($user_level == 2){
                $num = $invite_model->find()
                    ->where(['user_by_id' => $user_id])
                    ->andWhere(['invition_status' => 3005])
                    ->andWhere(['>=', 'active_time', $start_time])
                    ->andWhere(['<=', 'active_time', $end_time])
                    ->asArray()
                    ->count();
            }elseif($user_level == 3){
                $num = $invite_model->find()
                    ->where(['user_id' => $user_id])
                    ->andWhere(['user_by_id' => 0])
                    ->andWhere(['invition_status' => 3005])
                    ->andWhere(['>=', 'active_time', $start_time])
                    ->andWhere(['<=', 'active_time', $end_time])
                    ->asArray()
                    ->count();
            }
        }else{
            if($user_level == 2){
                $num = $invite_model->find()
                    ->where(['user_by_id' => $user_id])
                    ->andWhere(['invition_status' => 3005])
                    ->asArray()
                    ->count();
            }elseif($user_level == 3){
                $num = $invite_model->find()
                    ->where(['user_id' => $user_id])
                    ->andWhere(['user_by_id' => 0])
                    ->andWhere(['invition_status' => 3005])
                    ->asArray()
                    ->all();
            }
        }

        return $num;
    }

    /**
     * @desc:获取本周周一和周日的时间戳
     * @return mixed
     */
    public static function get_mon_sun_time(){
        $timestamp=time();
        $monday_date = date('Y-m-d', $timestamp-86400*date('w',$timestamp)+(date('w',$timestamp)>0?86400:-/*6*86400*/518400));

        $sunday = strtotime($monday_date) + /*6*86400*/518400;
        $sunday = date('Y-m-d',$sunday);

        $arr['mon'] = strtotime($monday_date);
        $arr['sun'] = strtotime($sunday);

        return $arr;
    }

    /**
     * @desc:获取本月第一天额最后一天的时间戳
     * @return mixed
     */
    public static function get_month_one_to_end_time(){
        $first = date('Y-m-01', time());
        $last = date('Y-m-d', strtotime(date('Y-m-01', time()) . ' +1 month -1 day'));
        $arr['first'] = strtotime($first);
        $arr['last'] = strtotime($last);

        return $arr;
    }

    /**
     * @desc:得到管理员职称的名字
     */
    public static function get_admin_level_name($team_num){
        if($team_num<30){
            return 7;
        }elseif($team_num>=30 && $team_num<=100){
            return 8;
        }elseif($team_num>=101 && $team_num<=500){
            return 9;
        }elseif($team_num>=501 && $team_num<=1000){
            return 10;
        }elseif($team_num>=1001 && $team_num<= 5000){
            return 11;
        }elseif($team_num>=5001 && $team_num<= 20000){
            return 12;
        }elseif($team_num>=20001){
            return 13;
        }

    }

    /**
     * @desc:得到团长职称的名字
     */
    public static function get_commonder_level_name($open_suc_team_num){
        if($open_suc_team_num<=10){
            return 1;
        }elseif($open_suc_team_num>=11 && $open_suc_team_num<=100){
            return 2;
        }elseif($open_suc_team_num>=101 && $open_suc_team_num<=200){
            return 3;
        }elseif($open_suc_team_num>=201 && $open_suc_team_num<=500){
            return 4;
        }elseif($open_suc_team_num>=501 && $open_suc_team_num<= 1000){
            return 5;
        }elseif($open_suc_team_num>1000){
            return 6;
        }
    }


    public static function get_sort_arr($arr,$sort,$field){
        $sort = array(
            'direction' => $sort, //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
            'field'     => $field,       //排序字段
        );
        $arrSort = array();
        foreach($arr AS $uniqid => $row){
            foreach($row AS $key=>$value){
                $arrSort[$key][$uniqid] = $value;
            }
        }
        if($sort['direction']){
            array_multisort($arrSort[$sort['field']], constant($sort['direction']), $arr);
        }

        return $arr;
    }


    /*@desc 随机生成验证码
     *   
     *  
    */

    public static function verify(){
        $letters=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
        $msg="";
        $letter="";
        for($i=0;$i<4;$i++){
            $msg.=mt_rand(0, 9);

        }
        for($i=0;$i<4;$i++){
            $const=mt_rand(0, 9);
            $letter.=$letters[$const];
        }
        $invition_code=$msg.$letter;
        return $invition_code;
    }

    /*使用外交官徽章*/
    public static function Diplomat(){
        $model_user=new UserModel();
        $model_rebate=new RebateModel();
        $model_invition=new InviteModel();
        $session = Yii::$app->session;
        $user_id=$session->get('user_id');
        $start_time=time();
        $end_time=time()+(3600*24*30);
        if($user_id){
            $user=$model_user::find()->where(['user_id'=>$user_id])->one();
            $user_level=$user['e_user_level'];
            $e_diplomat_medal_number=$user['e_diplomat_medal_number'];

        }
        if($user_level==3){
            $data=array('user_id'=>$user_id,'user_by_id'=>0,'invition_flag'=>0,'invition_status'=>3004,'start_time'=>$start_time,'end_time'=>$end_time);

        }elseif($user_level==2){
            //根据团长id查找管理员
            $admin_model=new AdminrelationModel();

            $head_info=$admin_model::find()->where(["head_id"=>$user_id])->one();
            $admin_id=$head_info['admin_id'];

            $data=array('user_id'=>$admin_id,'user_by_id'=>$user_id,'invition_flag'=>0,'invition_status'=>3003,'start_time'=>$start_time,'end_time'=>$end_time);
        }
        $data['invition_code']=self::verify();
        $model_invition->setAttributes($data);
        $invite_info=$model_invition->save();
        $id=$model_invition->primaryKey;
        if($invite_info){
            $user->e_diplomat_medal_number=$e_diplomat_medal_number-1;
            $diplomat_medal_number=$user->save();
            if($user_level==3 && $diplomat_medal_number){
                $rebate_admin=array('amount'=>10,'user_id'=>$user_id,'flag'=>8,'invite_id'=>$id,'status'=>3004,'time'=>time());//管理员返利
                $rebate_head=array('amount'=>30,'user_id'=>$user_id,'flag'=>8,'invite_id'=>$id,'status'=>3003,'time'=>time());//购买邀请码的人返利
                $admin_model=clone $model_rebate;
                $admin_model->setAttributes($rebate_admin);
                $admin=$admin_model->save();
                $head_model= clone $model_rebate;
                $head_model->setAttributes($rebate_head);
                $head=$head_model->save();
                if($admin && $head){
                    return 200;
                }else{
                    return 300;
                }
            }elseif($diplomat_medal_number){
                return 200;
            }elseif(!$diplomat_medal_number){
                return 300;
            }

        }

    }


}