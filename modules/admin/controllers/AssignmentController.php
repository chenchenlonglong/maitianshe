<?php
/**
 * @author oj
 * @data : 2016/3/28
 * @time: 15:24
 */

namespace app\modules\admin\controllers;


use app\common\Tools;
use app\controllers\BaseController;
use Yii;
use app\models\Auth_adminModel;
use app\models\Auth_itemModel;
use app\models\Auth_assignmentModel;
use yii\data\Pagination;

class AssignmentController extends BaseController
{
    public $enableCsrfValidation = false;

    /**
     * @desc用户信息列表展示
     * @return string|void
     */
    public function actionIndex()
    {
        $admin_model = new Auth_adminModel();

        $curPage = Yii::$app->request->get('page', 1);
        $pageSize = 200;

        //查询语句
        $query = $admin_model->find();
        $data = $admin_model->getPages($query, $curPage, $pageSize);
        $user = array();
        foreach ($data['data'] as $row) {
            $user_id = $row['user_id'];
            $user_roles = $this->get_user_roles($user_id);

            $row['user_roles'] = implode(',', $user_roles);
            $user[] = $row;
        }
        $data['data'] = $user;

        $user_actions = Tools::get_action_permission();

        $data['user_actions'] = isset($user_actions) ? $user_actions : array();


        $pages = new Pagination(['totalCount' => $data['count'], 'pageSize' => $pageSize]);

        return $this->renderPartial('index', ['pages' => $pages, 'data' => $data]);
    }

    /**
     * @desc创建用户并分配其角色
     * @return mixed|string
     */
    public function actionCreate()
    {

        if (Yii::$app->request->post()) {

            $transaction = Yii::$app->db->beginTransaction();//开启事务

            try {
                $post = Yii::$app->request->post();

                $auth_admin_model = New Auth_adminModel();
                $auth_admin_model->user_name = $post['user_name'];
                $auth_admin_model->password = Tools::md5_pwd($post['password']);
                $auth_admin_model->customer_name = $post['customer_name'];
                $auth_admin_model->created_at = time();
                $auth_admin_model->save();

                $query = $auth_admin_model->find()->where(['user_name' => $post['user_name']]);
                $user = $query->asArray()->one();
                $user_id = $user['user_id'];

                if (!empty($post['roles'])) {
                    foreach ($post['roles'] as $role) {
                        $auth_assignment_model = new Auth_assignmentModel();
                        $auth_assignment_model->item_name = $role;
                        $auth_assignment_model->user_id = $user_id;
                        $auth_assignment_model->created_at = time();
                        $auth_assignment_model->save();
                    }
                }
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollBack();
                return json_encode(['statusCode' => 300, 'message' => '添加失败, 请重试!']);
            }
            return json_encode(['statusCode' => 200, 'message' => '添加成功!', 'navTabId' => 'assignment_id_index', 'callbackType' => 'closeCurrent']);
        }

        $auth_item_model = new Auth_itemModel();
        $query = $auth_item_model->find()->where(array('type' => 1));
        $role = $query->asArray()->all();

        return $this->renderPartial('create', [
            'roles' => $role,
        ]);
    }

    /**
     * @desc修改该用户的信息和分配的角色
     * @return mixed|string
     */
    public function actionUpdate()
    {

        $user_id = Yii::$app->request->get('user_id');

        if (Yii::$app->request->post()) {

            $transaction = Yii::$app->db->beginTransaction();//开启事务

            try {
                $post = Yii::$app->request->post();

                $user_id = $post['user_id'];

                $auth_admin_model = New Auth_adminModel();

                $user = $auth_admin_model->findOne(['user_id' => $user_id]);
                if (!$user) {
                    return json_encode(['statusCode' => 300, 'message' => '改用户不存在!']);
                }
                $user->user_id = $post['user_id'];
                $user->user_name = $post['user_name'];
//                $user->password = Tools::md5_pwd($post['password']);
                $user->customer_name = $post['customer_name'];
                $user->updated_at = time();

                $user->save();

                if (!empty($post['roles'])) {
                    $query = $auth_admin_model->find()->where(['user_id' => $user_id]);
                    $assignment = $query->asArray()->all();

                    if (!empty($assignment)) {
                        $auth_assignment_model = new Auth_assignmentModel();
                        $auth_assignment_model->deleteAll('user_id = :user_id', [':user_id' => $user_id]);
                    }

                    foreach ($post['roles'] as $role) {
                        $auth_assignment_model = new Auth_assignmentModel();
                        $auth_assignment_model->item_name = $role;
                        $auth_assignment_model->user_id = $user_id;
                        $auth_assignment_model->save();
                    }

                }
                $transaction->commit();//提交事务
            } catch (Exception $e) {

                $transaction->rollBack();
                return json_encode(['statusCode' => 300, 'message' => 'xiu失败, 请重试!']);
            }
            return json_encode(['statusCode' => 200, 'message' => '修改成功!', 'navTabId' => 'assignment_id_index', 'callbackType' => 'closeCurrent']);
        }

        $item_model = new Auth_itemModel();
        $query = $item_model->find()->where(array('type' => 1));
        $role = $query->asArray()->all();

        $auth_admin_model = new Auth_adminModel();
        $user = $auth_admin_model->findone(array('user_id' => $user_id));

        $user_roles = $this->get_user_roles($user_id);

        return $this->renderPartial('update', [
            'roles' => $role,
            'user' => $user,
            'role_check' => $user_roles,
        ]);
    }

    /**
     * @desc删除该用户
     * @return mixed|string
     */
    public function actionDelete()
    {

        $user_id = Yii::$app->request->get('user_id');

        $auth_admin_model = new Auth_adminModel();

        $result = $auth_admin_model->deleteAll('user_id = :user_id', [':user_id' => $user_id]);
        if ($result) {
            return json_encode(['statusCode' => 200, 'message' => '删除成功!', 'navTabId' => 'assignment_id_index']);
        } else {
            return json_encode(['statusCode' => 300, 'message' => '删除失败, 请重试!']);
        }

    }


    public function get_user_roles($user_id)
    {
        $auth_assignment_model = new Auth_assignmentModel();
        $query = $auth_assignment_model->find()->where(['user_id' => $user_id]);
        $roles = $query->asArray()->all();
        $user_roles = array_column($roles, 'item_name');
        return $user_roles;
    }

}