<?php
/**
 * @author oj
 * @data : 2016/3/30
 * @time: 18:36
 */

namespace app\components;

use Yii;
use app\models\Auth_adminModel;
use \yii\base\Widget;
use app\models\Auth_assignmentModel;
use app\models\Auth_item_childModel;
use app\models\Auth_itemModel;
use yii\web\Session;
use app\common;

class MenuWidget extends Widget
{
    public $enableCsrfValidation = false;

    public function init()
    {
        parent::init();
    }

    /**
     * @desc查询出用户的权限并写入到菜单中
     * @return string
     */
    public function run()
    {

        $auth_item_model = new Auth_itemModel();

        $type = 2;//表示子菜单

        $permissions_show = $this->get_permission($type);//获取所有子菜单

        $parent_menus = $auth_item_model->findAll(['type' => 3]);//查询所有的父菜单


        $menus = array();
        $menus_name = array();
        if (!empty($permissions_show)) {

            foreach ($parent_menus as $k => $v) {
                foreach ($permissions_show as $value) {
                    if ($value->parent_menu == $v->name && !in_array($value['show_name'],$menus_name)) {
                        $menus_name[] = $value['show_name'];

                        $data = explode('/', $value->name);
                        $rel = isset($data[1]) ? $data[1] : '';
                        $menus[$v->name][] = ['url' => $value->name, 'name' => $value->show_name, 'rel' => $rel];
                    }
                }
            }
        }
        return $this->render('menu', ['menus' => $menus, 'parent_menus' => $parent_menus]);
    }

    public function get_permission($type )
    {

        $auth_admin_model = new Auth_adminModel();
        $auth_item_model = new Auth_itemModel();
        $auth_item_child_model = new Auth_item_childModel();
        $auth_assignment_model = new Auth_assignmentModel();

        $user_id = common\Tools::get_user_id();
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
                        $permission = $auth_item_model->findOne(['name'=>$v->child]);

                       if ( $permission->type == $type) {
                            $permissions[] = $permission;
                        }
                    }
                }
            }
        }

        return $permissions;

    }

}