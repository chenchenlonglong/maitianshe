<?php
/**
 * @author oj
 * @data : 2016/4/6
 * @time: 11:06
 */

namespace app\common;

use app\models\Auth_adminModel;
use app\models\Auth_assignmentModel;
use app\models\Auth_item_childModel;
use app\models\Auth_itemModel;
use yii;


class Tools
{
    /**
     * @desc 将父子菜单组建成一个 键名(父)=>键值(子) 的数组
     * @param $parent
     * @param $child
     * @return array
     */
    public static function get_menu($parent, $child)
    {
        $data = array();
        foreach ($parent as $k => $v) {
            foreach ($child as $value) {
                if ($value->parent_menu == $v->name) {
                    $arr = explode('/', $value->name);
                    $rel = isset($arr[1]) ? $arr[1] : '';
                    $data[$v->name][] = [
                        'url' => isset($value['name']) ? $value['name'] : '',
                        'show_name' => isset($value['show_name']) ? $value['show_name'] : '',
                        'name' => isset($value['name']) ? $value['name'] : '',
                        'type' => isset($value['type']) ? $value['type'] : '',
                        'rel' => $rel,
                        'description' => isset($value['description']) ? $value['description'] : '',
                        'parent_menu' => isset($value['parent_menu']) ? $value['parent_menu'] : '',
                        'created_at' => isset($value['created_at']) ? $value['created_at'] : '',
                    ];
                }
            }
        }
        return $data;
    }


    /**
     * @desc从session中获取用户id
     * @return mixed
     */
    public static function get_user_id()
    {
        $session = Yii::$app->session;
        if ($session->isActive) {
            $session->open();
        }
        return $session->get('user_id');
    }

    /**
     * @获取当前登录用户的信息对象
     * @return null|static
     */
    public static function get_user_name($user_id = ''){
        if($user_id === ''){
            $user_id = self::get_user_id();
        }
        $auth_admin_model = new Auth_adminModel();
        $user = $auth_admin_model->find()->select(["customer_name"])->where(['user_id' => $user_id])->asArray()->one();
        if($user){
            return $user["customer_name"];
        }else{
            return "";
        }

    }

    /**
     * @desc根据用户名获取用户id
     * @param $username
     * @return null|static
     */
    public static function get_id($username){
        $auth_admin_model = new Auth_adminModel();
        $user = $auth_admin_model->findOne(['customer_name' => $username]);
        return $user;
    }

    /**
     * @desc获取用户的操作权限
     * @param $user_id
     * @param $type 1:角色;2:子菜单;3:主菜单;4:操作
     * @return array
     */
    public static function get_permission($type = 4)
    {

        $auth_admin_model = new Auth_adminModel();
        $auth_item_model = new Auth_itemModel();
        $auth_item_child_model = new Auth_item_childModel();
        $auth_assignment_model = new Auth_assignmentModel();

        $user_id = self::get_user_id();
        $user = $auth_admin_model->findOne(['user_id' => $user_id]);

        $permissions = array();

        if (isset($user->is_super) && $user->is_super == 1) { //超级管理员 获取所有的权限

            $data = $auth_item_model->findAll(['type' => $type]);
            foreach ($data as $k) {
                $permissions[] = $k;
            }

        } else {
            //获取角色
            $roles = $auth_assignment_model->findall(['user_id' => $user_id]);

            if (!empty($roles)) {
                foreach ($roles as $role) {
                    $name = $role->item_name;
                    $data = $auth_item_child_model->findAll(['parent' => $name]);
                    foreach ($data as $v) {
                        $permission = $auth_item_model->findOne(['name' => $v->child]);

                        if ($permission->type == $type) {
                            $permissions[] = $permission;
                        }
                    }
                }

            }
        }
        return $permissions;

    }

    /**
     * @desc将获取的用户权限对象转化为一维数组
     * @param int $type
     * @return array
     */
    public static function get_action_permission($type = 4)
    {
        $user_permission = self::get_permission($type);
        $data = array();
        foreach ($user_permission as $value) {
            $data[] = $value->name;
        }
        return $data;
    }


    /**@desc返回在线运营人员的信息
     * @return array
     */
    public static function get_online_operation_personnel()
    {
        $auth_admin_model = new Auth_adminModel();
        $auth_assignment_model = new Auth_assignmentModel();
        $users = $auth_admin_model->findAll(['is_login' => 1]);

        $operation_user = array();
        foreach ($users as $user) {
            $user_id = $user->user_id;
            $data = $auth_assignment_model->findAll(['user_id' => $user_id]);
            foreach ($data as $row) {
                $role = $row->item_name;
                if ($role == '运营人员') {
                    $operation_user[] = $user;
                }
            }
        }
        return $operation_user;
    }

    /**@desc返回在线运营人员的id
     * @return array
     */

    public static function get_online_operation_personnel_id(){
        $operation_users = self::get_online_operation_personnel();

        $user_id = array();
        foreach ($operation_users as $operation_user) {
            $user_id[] = $operation_user->user_id;
        }
        return $user_id;
    }


    public static function md5_pwd($password){
        $password = md5('maitianshe@'.$password);
        return $password;
    }
}