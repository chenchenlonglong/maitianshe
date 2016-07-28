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

    <div class="pageContent">
        <div class="panelBar">
            <ul class="toolBar">
                <?php if (in_array('admin/item/create', $data['user_actions'])){ ?>
                <li><a class="add" href="index.php?r=admin/item/create&type=1" target="dialog" rel="item_id_role_add"><span>添加角色</span></a>
                    <?php } ?>
                    <?php if (in_array('admin/item/create_main_menu', $data['user_actions'])){ ?>
                <li><a class="add" href="index.php?r=admin/item/create_main_menu&type=3" target="dialog" rel="item_id_menu_add"><span>添加主菜单</span></a>
                    <?php } ?>
                    <?php if (in_array('admin/item/create', $data['user_actions'])){ ?>
                <li><a class="add" href="index.php?r=admin/item/create&type=2" target="dialog" rel="item_id_permission_add"><span>添加权限</span></a>
                    <?php } ?>
                    <?php if (in_array('admin/item/create_action', $data['user_actions'])){ ?>
                <li><a class="add" href="index.php?r=admin/item/create_action&type=4" target="dialog" rel="item_id_action_add"><span>添加功能</span></a>
                    <?php } ?>
                </li>
            </ul>
        </div>
        <div class="summary">

            <table class="table table-striped table-bordered table_base" width="100%" layoutH="75">
                <thead>
                <tr>
                    <th style="width: 250px">名称</th>
                    <th style="width: 250px">类型</th>
                    <th style="width: 250px">显示名字</th>
                    <th style="width: 250px">创建时间</th>
                    <th style="width: 80px">操作</th>
                </tr>
                </thead>
                <tbody>
                <tr><td ><b>------------角色------------</b></td><td></td><td></td><td></td><td></td></tr>
                <?php foreach ($data['roles'] as $role) { ?>
                    <tr>
                        <td><b><?php echo $role['name']; ?></b></td>
                        <td><b><?php echo '角色'; ?></b></td>
                        <td><b><?php echo $role['show_name']; ?></b></td>
                        <td><b><?php echo $role['created_at'] == 0 ? '未设置' : date('Y-m-d', $role['created_at']); ?></b></td>
                        <td>
                            <?php if (in_array('admin/item/update', $data['user_actions'])) { ?>
                                <a class="btnEdit" href="<?= Url::to(['update', 'name' => urlencode($role['name'])]); ?>" target="dialog" mask="true" rel="item_id_edit" title="编辑"></a>
                            <?php } ?>
                            <?php if (in_array('admin/item/delete', $data['user_actions'])) { ?>
                                <a class="del btnDel" target="ajaxTodo" href="<?= Url::to(['delete', 'name' => urlencode($role['name'])]); ?>" rel="item_id_delete" title="删除"></a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
                <tr><td colspan="5"></td></tr>
                <tr><td><b>------权限------</b></td></tr>
                <?php $i = $data['start']; ?>

                <?php foreach ($data['parent_menus'] as $parent_menu): ?>
                    <tr>
                        <td><b><?php echo $parent_menu->name; ?></b></td>
                        <td><b><?php echo '主菜单'; ?></b></td>
                        <td><b><?php echo $parent_menu['show_name']; ?></b></td>
                        <td>
                            <b><?php echo $parent_menu['created_at'] == 0 ? '未设置' : date('Y-m-d', $parent_menu['created_at']); ?></b>
                        </td>
                        <td>
                            <?php if (in_array('admin/item/update', $data['user_actions'])) { ?>
                                <a class="btnEdit" href="<?= Url::to(['update', 'name' => urlencode($parent_menu->name)]); ?>" target="dialog" mask="true" rel="item_id_edit" title="编辑"></a>
                            <?php } ?>
                            <?php if (in_array('admin/item/delete', $data['user_actions'])) { ?>
                                <a class="del btnDel" target="ajaxTodo" href="<?= Url::to(['delete', 'name' => urlencode($parent_menu->name)]); ?>" rel="item_id_delete" title="删除"></a>
                            <?php } ?>
                        </td>
                    </tr>

                    <?php if (isset($data['menus'][$parent_menu->name])) { ?>
                        <?php foreach ($data['menus'][$parent_menu->name] as $menu): ?>
                            <tr>
                                <td><?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|--' . $menu['name']; ?></td>
                                <td><?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|--权限菜单'; ?></td>
                                <td><?php echo $menu['show_name']; ?></td>
                                <td><?php echo $menu['created_at'] == 0 ? '未设置' : date('Y-m-d', $menu['created_at']); ?></td>
                                <td>
                                    <?php if (in_array('admin/item/update', $data['user_actions'])) { ?>
                                        <a class="btnEdit" href="<?= Url::to(['update', 'name' => urlencode($menu['name'])]); ?>" target="dialog" mask="true" rel="item_id_edit" title="编辑"></a>
                                    <?php } ?>
                                    <?php if (in_array('admin/item/delete', $data['user_actions'])) { ?>
                                        <a class="del btnDel" target="ajaxTodo" href="<?= Url::to(['delete', 'name' => urlencode($menu['name'])]); ?>" rel="item_id_delete" title="删除"></a>
                                    <?php } ?>
                                </td>
                            </tr>

                            <?php if (isset($data['actions'][$menu['name']])) { ?>
                                <?php foreach ($data['actions'][$menu['name']] as $action): ?>
                                    <tr>
                                        <td><?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;||--' . $action['name']; ?></td>
                                        <td><?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;||--操作菜单'; ?></td>
                                        <td><?php echo $action['show_name']; ?></td>
                                        <td><?php echo $action['created_at'] == 0 ? '未设置' : date('Y-m-d', $action['created_at']); ?></td>
                                        <td>
                                            <?php if (in_array('admin/item/update', $data['user_actions'])) { ?>
                                                <a class="btnEdit" href="<?= Url::to(['update', 'name' => urlencode($action['name'])]); ?>" target="dialog" mask="true" rel="item_id_edit" title="编辑"></a>
                                            <?php } ?>
                                            <?php if (in_array('admin/item/delete', $data['user_actions'])) { ?>
                                                <a class="del btnDel" target="ajaxTodo" href="<?= Url::to(['delete', 'name' => urlencode($action['name'])]); ?>" rel="item_id_delete" title="删除"></a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php } ?>
                        <?php endforeach; ?>
                    <?php } ?>
                <?php endforeach; ?>

                </tbody>
            </table>
            <input type="hidden" name="delUrl" value="<?= Url::to(['delete']) ?>">
        </div>


    </div>
</div>


