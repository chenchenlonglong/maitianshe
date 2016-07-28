<?php
/**
 * @Author: oj
 * @Date: 2016/3/16
 * @Time: 17:30
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>

<div class="auth-item-model-index">

    <div class="panelBar">
        <ul class="toolBar">
            <?php if (in_array('admin/assignment/create', $data['user_actions'])) { ?>
                    <li><a class="add" href="index.php?r=admin/assignment/create" target="dialog" rel="assignment_id_create"><span>添加用户</span></a></li>
            <?php } ?>
        </ul>
    </div>
    <div class="pageContent">

        <div class="summary">

            <table class="table table-striped table-bordered table_base" width="100%" layoutH="75">
                <thead>
                <tr>

                    <th style="width: 20px"> #</th>
                    <th style="width: 200px">账户名称</th>
                    <th style="width: 200px">用户名</th>
                    <th style="width: 200px">用户角色</th>
                    <th style="width: 200px">是否是超级管理员</th>
                    <th style="width: 200px">创建时间</th>
                    <th style="width: 100px">编辑角色的权限</th>
                </tr>
                </thead>
                <tbody>

                <?php
                if ($data) {

                    $i = $data['start']; ?>
                    <?php foreach ($data['data'] as $list): ?>
                        <tr data-key="<?php echo $list['user_name']; ?>">
                            <!--                 <td> -->
                            <!--                     <div class="checker"><span><input type="checkbox" value="158" name="select"></span></div> -->
                            <!--                 </td> -->
                            <td><?= $i++ ?> </td>
                            <td><?= Html::encode($list['user_name']); ?></td>
                            <td><?= Html::encode($list['customer_name']); ?></td>
                            <td><?= Html::encode($list['user_roles']); ?></td>

                            <td><?= Html::encode($list['is_super']?'是':'否'); ?></td>
                            <td><?= Html::encode($list['created_at'] ? date('Y-m-d', time($list['created_at'])) : '未设置'); ?></td>
                            <td>
                                <?php if (in_array('admin/assignment/update', $data['user_actions'])) { ?>
                                    <a class="btnEdit" href="<?= Url::to(['update', 'user_id' => urlencode($list['user_id'])]); ?>" target="dialog" mask="true" rel="assignment_id_update" title="编辑"></a>
                                <?php } ?>
                                <?php if (!$list['is_super'] && in_array('admin/assignment/delete', $data['user_actions'])) { ?>
                                    <a class="del btnDel" href="<?= Url::to(['delete', 'user_id' => urlencode($list['user_id'])]); ?>" target="ajaxTodo" rel="assignment_id_delete" title="删除!"></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php } ?>
                </tbody>
            </table>
        </div>


    </div>
</div>

