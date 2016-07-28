<?php
/**
 * @Author: oj
 * @Date: 2016/3/16
 * @Time: 17:30
 */

use yii\helpers\Html;
use \yii\widgets\ActiveForm;

?>
<div class="pageContent">
    <?php $form = ActiveForm:: begin(['options' => ['class' => 'pageForm required-validate', 'onsubmit' => 'return validateCallback(this, dialogAjaxDone);']]); ?>
    <div class="pageFormContent" layoutH="56">
        <div class="auth-item-model-form">

            <input name="type" type="hidden" size="30" value="<?php echo $model->type; ?>"/>

            <?php if ($model->type == 1) { ?>
                <p>
                    <label><?php echo $title; ?> 名字：</label>
                    <input name="name" type="text" size="30" value="<?php echo $model->name ?>"/>
                </p>
                <p>
                    <label><?php echo $title; ?> 描述：</label>
                    <textarea name="description" rows="5" cols="32"><?php echo $model->description ?></textarea>
                </p>
                <p></p>
                <p></p>
                <p>
                    <label style="float:left;"><?php echo $title; ?> 权限：</label>
            <span style="float:left;">
                <ul class="tree treeFolder treeCheck expand" oncheck="kkk">
                    <?php
                    if(isset($parent_menus)) {
                        foreach ($parent_menus as $parent_menu) { ?>
                            <li><a tname=""
                                   tvalue="<?php echo $parent_menu->name; ?>"><?php echo $parent_menu->name; ?></a>
                                <ul>
                                    <?php
                                    if (isset($menus[$parent_menu->name])) {

                                        foreach ($menus[$parent_menu->name] as $k => $v) { ?>
                                            <li><a tname="permissions[]" tvalue="<?php echo $v['name']; ?>"
                                                    <?php if (in_array($v['name'], $permission_check)) {
                                                        echo 'checked=""checked';
                                                    } ?>><?php echo $v['show_name']; ?></a>
                                                <ul>
                                                    <?php if (isset($actions[$v['name']])) { ?>
                                                        <li><a tname="permissions[]"
                                                               tvalue="<?php echo $v['name']; ?>" <?php if (in_array($actions[$v['name']][0]['url'], $permission_check)) echo 'checked=""checked'; ?>><?php echo $v['show_name'] . '列表'; ?></a>
                                                        <?php foreach ($actions[$v['name']] as $key => $value) { ?>
                                                            <li><a tname="permissions[]"
                                                                   tvalue="<?php echo $value['name']; ?>"
                                                                    <?php if (in_array($value['name'], $permission_check)) {
                                                                        echo 'checked=""checked';
                                                                    } ?>><?php echo $value['show_name']; ?></a>
                                                            </li>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php }
                                    } ?>
                                </ul>
                            </li>
                        <?php }
                    }?>
                </ul>
            </span>
                </p>

            <?php } elseif ($model->type == 2) { ?>
                <p>
                    <label><?php echo $title; ?> url：</label>
                    <input name="name" readonly="readonly" type="text" size="30" value="<?php echo $model->name ?>"/>
                </p>
                <p>
                    <label><?php echo $title; ?> 名字：</label>
                    <input name="show_name"  type="text" size="30" value="<?php echo $model->show_name ?>"/>
                </p>
                <p>
                    <label><?php echo $title; ?> 描述：</label>
                    <textarea name="description" rows="5" cols="32"><?php echo $model->description ?></textarea>
                </p>
                <p></p>
                <p></p>
                <p>
                    <label><?php echo $title; ?> 父菜单：</label>
                     <span style="float:left;">
                <ul class="tree treeFolder treeCheck expand" oncheck="kkk">
                    <?php foreach ($parent_menus as $parent_menu) { ?>
                        <li><a tname="parent_menu[]"
                               tvalue="<?php echo $parent_menu->name; ?>" <?php if (($parent_menu->name == $model->parent_menu)) {
                                echo 'checked="checked"';
                            } ?>><?php echo $parent_menu->name; ?></a>

                        </li>
                    <?php } ?>
                </ul>
            </span>
                </p>

            <?php } elseif ($model->type == 3) { ?>
                <p>
                    <label><?php echo $title; ?> 名字：</label>
                    <input name="name" readonly="readonly" type="text" size="30" value="<?php echo $model->name ?>"/>
                </p>

                    <input name="show_name" type="hidden" size="30" value="<?php echo $model->show_name ?>"/>

                <p>
                    <label><?php echo $title; ?> 描述：</label>
                    <textarea name="description" rows="5" cols="32"><?php echo $model->description ?></textarea>
                </p>

            <?php } elseif ($model->type == 4) { ?>
                <p>
                    <label><?php echo $title; ?> url：</label>
                    <input name="name" readonly="readonly" type="text" size="30" value="<?php echo $model->name ?>"/>
                </p>
                <p>
                    <label><?php echo $title; ?> 名字：</label>
                    <input name="show_name"  type="text" size="30" value="<?php echo $model->show_name ?>"/>
                </p>
                <p>
                    <label><?php echo $title; ?> 描述：</label>
                    <textarea name="description" rows="5" cols="32"><?php echo $model->description ?></textarea>
                </p>
                <p></p>
                <p></p>
                <p>
                    <label><?php echo $title; ?> 父菜单：</label>
                     <span style="float:left;">
                <ul class="tree treeFolder treeCheck expand" oncheck="kkk">
                    <?php foreach ($parent_menus as $parent_menu) { ?>
                        <li><a tname=""
                               tvalue="<?php echo $parent_menu->name; ?>" <?php if (($parent_menu->name == $model->parent_menu)) {
                                echo 'checked="checked"';
                            } ?>><?php echo $parent_menu->name; ?></a>
                            <ul>
                                <?php if (isset($menus[$parent_menu->name])) { ?>
                                    <?php foreach ($menus[$parent_menu->name] as $k => $v) { ?>
                                        <li><a tname="parent_menu[]"
                                               tvalue="<?php echo $v['name']; ?>" <?php if (($v['name'] == $model->parent_menu)) {
                                                echo 'checked="checked"';
                                            } ?>><?php echo $v['show_name']; ?></a>
                                        </li>
                                    <?php } ?>
                                <?php } ?>

                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            </span>
                </p>

            <?php } ?>


        </div>
    </div>
    <div class="formBar">
        <ul>
            <li>
                <div class="buttonActive">
                    <div class="buttonContent">
                        <button type="submit">保存</button>
                    </div>
                </div>
            </li>
            <li>
                <div class="button">
                    <div class="buttonContent">
                        <button type="button" class="close">取消</button>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <?php ActiveForm::end(); ?>
</div>


