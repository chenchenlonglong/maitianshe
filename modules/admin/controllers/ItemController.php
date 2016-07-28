<?php
/**
 * @Author: oj
 * @Date: 2016/3/16
 * @Time: 17:30
 */

namespace app\modules\admin\controllers;

use app\common\Tools;
use app\models\Auth_item_childModel;
use yii;
use app\models\Auth_itemModel;
use yii\data\Pagination;
use app\controllers\BaseController;
use yii\db\Exception;

class ItemController extends BaseController
{
    public $enableCsrfValidation = false;

    public $name;
    public $type;
    public $description;
    public $show_name;
    public $permissions;
    public $is_show;
    public $parent_menu;

    /**
     * @desc权限列表的展示
     * @return string
     */
    public function actionIndex()
    {

        $auth_item_model = new Auth_itemModel();

        $curPage = Yii::$app->request->get('page', 1);
        $pageSize = 50;

        //搜索
        $type = Yii::$app->request->post('type', '');
        $value = Yii::$app->request->post('value', '');
        $search = ($type && $value) ? ['like', $type, $value] : '';

        //查询语句
        $query = $auth_item_model->find();
        $data = $auth_item_model->getPages($query, $curPage, $pageSize, $search);


        //查询所有的父菜单
        $parent_menus = $auth_item_model->findAll(['type' => 3]);
        $permissions = $auth_item_model->findAll(['type' => 2]);
        $fns = $auth_item_model->findAll(['type' => 4]);
        $roles = $auth_item_model->findAll(['type' => 1]);

        $menus = Tools::get_menu($parent_menus, $permissions);
        $actions = Tools::get_menu($permissions, $fns);

        $user_actions = Tools::get_action_permission();

        $data['parent_menus'] = isset($parent_menus) ? $parent_menus : array();
        $data['menus'] = isset($menus) ? $menus : array();
        $data['actions'] = isset($actions) ? $actions : array();
        $data['roles'] = isset($roles) ? $roles : array();
        $data['user_actions'] = isset($user_actions) ? $user_actions : array();

        $pages = new Pagination(['totalCount' => $data['count'], 'pageSize' => $pageSize]);

        return $this->renderPartial('index', ['pages' => $pages, 'data' => $data, 'search' => $search]);
    }


    /**
     * @desc创建角色&权限的方法
     * @return string|yii\web\Response
     */
    public function actionCreate()
    {
        $auth_item_model = new Auth_itemModel();
        $auth_item_child_model = new Auth_item_childModel();
        $type = Yii::$app->request->get('type');

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();

            if ($post['type'] == 1) { //创建角色

                $transaction = Yii::$app->db->beginTransaction();//开启事务
                try {
                    $this->save_auth($auth_item_model, $post, 'create');

                    $post['permissions'] = isset($post['permissions']) ? $post['permissions'] : array();
                    foreach ($post['permissions'] as $child) {

                        $permission = $auth_item_model->findOne(['name' => $child]);

                        if($permission->type == 4){
                            $auth_item_child_model = new Auth_item_childModel();
                            $auth_item_child_model->child = $child;
                            $auth_item_child_model->parent = $post['name'];

                            $auth_item_child_model->save();
                        }else{
                            $result2 = $auth_item_child_model->findOne(['child' => $child, 'parent' => $post['name']]);
                            if (!$result2) {
                                $auth_item_child_model = new Auth_item_childModel();
                                $auth_item_child_model->child = $child;
                                $auth_item_child_model->parent = $post['name'];

                                $auth_item_child_model->save();
                            }
                        }

                    }
                    $transaction->commit();
                    $result = true;
                } catch (Exception $e) {

                    $transaction->rollBack();
                    return json_encode(['statusCode' => 300, 'message' => '添加失败, 请重试!']);
                }
            } else { //创建子菜单
                if (isset($post['parent_menu']) && count($post['parent_menu']) > 1) {
                    return json_encode(['statusCode' => 300, 'message' => '父菜单只能选一个, 请重试!']);
                }
                if (!isset($post['parent_menu'])) {
                    return json_encode(['statusCode' => 300, 'message' => '请选择父菜单!']);
                }
                $result = $this->save_auth($auth_item_model, $post, 'create');
            }
            if ($result) {
                return json_encode(['statusCode' => 200, 'message' => '添加成功!', 'navTabId' => 'item_id_index', 'callbackType' => 'closeCurrent']);
            } else {
                return json_encode(['statusCode' => 300, 'message' => '添加失败, 请重试!']);
            }
        }

        //查询所有的父菜单
        $parent_menus = $auth_item_model->findAll(['type' => 3]);
        $permissions = $auth_item_model->findAll(['type' => 2]);
        $fns = $auth_item_model->findAll(['type' => 4]);

        $menus = Tools::get_menu($parent_menus, $permissions);//所有的菜单
        $actions = Tools::get_menu($permissions, $fns);//所有的功能操作

        if ($type == 1) {
            $title = '角色';
        } else {
            $title = '权限';
        }
        $params = [
            'model' => $auth_item_model,
            'type' => $type,
            'title' => $title,
            'permissions' => $permissions,
            'parent_menus' => $parent_menus,
            'menus' => $menus,
            'actions' => $actions,
        ];

        return $this->renderPartial('create', $params);
    }

    /**
     * @desc创建父菜单
     * @return mixed|string
     */
    public function actionCreate_main_menu()
    {

        $auth_item_model = new Auth_itemModel();

        $post = Yii::$app->request->post();
        $type = Yii::$app->request->get('type');

        if ($post) {
            $result = $this->save_auth($auth_item_model, $post, 'create');
            if ($result) {
                return json_encode(['statusCode' => 200, 'message' => '添加成功!', 'navTabId' => 'item_id_index', 'callbackType' => 'closeCurrent']);
            } else {
                return json_encode(['statusCode' => 300, 'message' => '添加失败, 请重试!']);
            }
        }

        $title = '主菜单';
        $params = [
            'model' => $auth_item_model,
            'title' => $title,
            'type' => $type,
        ];
        return $this->renderPartial('create_main_menu', $params);

    }

    /**
     * @desc创建操作权限
     * @return mixed|string
     */
    public function actionCreate_action()
    {
        $auth_item_model = new Auth_itemModel();

        $post = Yii::$app->request->post();
        $type = Yii::$app->request->get('type');

        if ($post) {

            if (isset($post['parent_menu']) && count($post['parent_menu']) > 1) {
                return json_encode(['statusCode' => 300, 'message' => '父菜单只能选一个, 请重试!']);
            }
            if (!isset($post['parent_menu'])) {
                return json_encode(['statusCode' => 300, 'message' => '请选择父菜单!']);
            }

            $result = $this->save_auth($auth_item_model, $post, 'create');
            if ($result) {
                return json_encode(['statusCode' => 200, 'message' => '添加成功!', 'navTabId' => 'item_id_index', 'callbackType' => 'closeCurrent']);
            } else {
                return json_encode(['statusCode' => 300, 'message' => '添加失败, 请重试!']);
            }
        }
        $parent_menus = $auth_item_model->findAll(['type' => 3]);
        $permissions = $auth_item_model->findAll(['type' => 2]);

        $menus = Tools::get_menu($parent_menus, $permissions);

        $title = '功能';
        $params = [
            'model' => $auth_item_model,
            'type' => $type,
            'title' => $title,
            'menus' => $menus,
            'parent_menus' => $parent_menus,
        ];
        return $this->renderPartial('create_action', $params);

    }

    /**
     * @desc删除角色&权限的方法
     * @return mixed|string
     */
    public function actionDelete()
    {
        $name = Yii::$app->request->get('name');

        $auth_item_model = new Auth_itemModel();


        $data = $auth_item_model->findOne(['name' => $name]);
        if (!$data) {
            return json_encode(['statusCode' => 300, 'message' => '删除的角色或权限不存在！']);
        }

        $transaction = Yii::$app->db->beginTransaction(); //开始事务
        try {
            $auth_item_model->deleteAll(['name' => $name]);
            $query = $auth_item_model->find()->where(['parent_menu' => $name]);
            $data = $query->asArray()->all();
            $data = array_column($data, 'name');

            foreach ($data as $row) {
                $auth_item_model->deleteAll(['parent_menu' => $row]);
            }
            $auth_item_model->deleteAll(['parent_menu' => $name]);

            $transaction->commit();//提交
        } catch (Exception $e) {
            $transaction->rollBack();
            return json_encode(['statusCode' => 300, 'message' => '删除失败, 请重试!']);
        }

        return json_encode(['statusCode' => 200, 'message' => '删除成功!', 'navTabId' => 'item_id_index']);

    }

    /**
     * @desc修改权限&角色的方法
     * @param $name
     * @return string|yii\web\Response
     */
    public function actionUpdate($name)
    {
        $auth_item_model = new Auth_itemModel();
        $auth_item_child_model = new Auth_item_childModel();
        $model = $auth_item_model->get_item($name);

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();

            if ($post['type'] == 1) {
                $transaction = Yii::$app->db->beginTransaction();//开启事务
                try {
                    $item = $auth_item_model->findOne(['name' => $name]);
                    $this->save_auth($item, $post, 'update');

                    $query = $auth_item_child_model->find()->where(['parent' => $post['name']]);
                    $permission = $query->asArray()->all();

                    if (!empty($permission)) {
                        $auth_item_child_model->deleteAll('parent = :role', [':role' => $post['name']]);
                    }
                    $post['permissions'] = isset($post['permissions']) ? $post['permissions'] : array();


                    foreach ($post['permissions'] as $v) {

                        $permission = $auth_item_model->findOne(['name' => $v]);


                        if ($permission->type == 4) {
                            $result1 = $auth_item_child_model->findOne(['child' => $permission->parent_menu, 'parent' => $post['name']]);
                            if (!$result1) {
                                $auth_item_child_model->child = $permission->parent_menu;
                                $auth_item_child_model->parent = $post['name'];

                                $auth_item_child_model->save();
                            }
                        }
                        $result2 = $auth_item_child_model->findOne(['child' => $v, 'parent' => $post['name']]);
                        if (!$result2) {
                            $auth_item_child_model = new Auth_item_childModel();
                            $auth_item_child_model->child = $v;
                            $auth_item_child_model->parent = $post['name'];

                            $auth_item_child_model->save();
                        }

                    }
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollBack();
                    return json_encode(['statusCode' => 300, 'message' => '修改失败, 请重试!']);
                }

            } else {
                if (isset($post['parent_menu']) && count($post['parent_menu']) > 1) {
                    return json_encode(['statusCode' => 300, 'message' => '父菜单只能选一个, 请重试!']);
                }
                if (!isset($post['parent_menu']) && ($post['type'] != 3)) {
                    return json_encode(['statusCode' => 300, 'message' => '请选择父菜单!']);
                }

                $item = $auth_item_model->findOne(['name' => $name]);
                $result = $this->save_auth($item, $post, 'update');

                if (!$result) {
                    return json_encode(['statusCode' => 300, 'message' => '修改失败, 请重试!']);
                }
            }
            return json_encode(['statusCode' => 200, 'message' => '修改成功!', 'navTabId' => 'item_id_index', 'callbackType' => 'closeCurrent']);

        } else {
            //查询所有的父菜单
            $parent_menus = $auth_item_model->findAll(['type' => 3]);
            $permissions = $auth_item_model->findAll(['type' => 2]);
            $menus = Tools::get_menu($parent_menus, $permissions);

            $query = $auth_item_child_model->find()->where(['parent' => $name]);
            $data = $query->asArray()->all();

            $permission_check = array_column($data, 'child');

            $fns = $auth_item_model->findAll(['type' => 4]);
            $actions = Tools::get_menu($permissions, $fns);//用户所有的功能操作权限

            if ($model->type == 1) {
                $title = '角色';
            } elseif ($model->type == 2) {
                $title = '权限';
            } elseif ($model->type == 3) {
                $title = '主菜单';
            } elseif ($model->type == 4) {
                $title = '功能';
            }
            $params = [
                'model' => $model,
                'type' => $model->type,
                'title' => $title,
                'menus' => $menus,
                'permission_check' => $permission_check,
                'parent_menus' => $parent_menus,
                'actions' => $actions,
            ];
            return $this->renderPartial('update', $params);
        }

    }

    public function save_auth($model, $post, $type = 'create')
    {
        $model->name = isset($post['name']) ? $post['name'] : '';
        $model->show_name = isset($post['show_name']) ? $post['show_name'] : '';
        $model->type = isset($post['type']) ? $post['type'] : '';
        $model->description = isset($post['description']) ? $post['description'] : '';
        $model->parent_menu = isset($post['parent_menu']) ? $post['parent_menu'][0] : null;
        if ($type == 'create') {
            $model->created_at = time();
        } else {
            $model->updated_at = time();
        }

        return $model->save();
    }


}