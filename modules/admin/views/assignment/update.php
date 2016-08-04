    <?php
/**
 * @Author: oj
 * @Date: 2016/3/16
 * @Time: 17:30
 */
use yii\widgets\ActiveForm;
use yii\bootstrap\Html;

?>

<div class="pageContent">
    <?php $form = ActiveForm:: begin(['options' => ['class' => 'pageForm required-validate', 'onsubmit' => 'return validateCallback(this, dialogAjaxDone);']]); ?>
    <div class="pageFormContent" layoutH="56">
        <div class="auth-item-model-form">

            <input name="user_id" type="hidden" size="30" value="<?php echo isset($user->user_id) ? $user->user_id : ''; ?>"/>

            <p>
                <label>账户 名字：</label>
                <input name="user_name" type="text" size="30" value="<?php echo isset($user->user_name) ? $user->user_name : ''; ?>"/>
            </p>

            <p>
                <label>用户名：</label>
                <input name="customer_name" type="text" size="30" value="<?php echo isset($user->customer_name) ? $user->customer_name : ''; ?>"/>
            </p>
            <?php if (!$user->is_super) { ?>

                <p>
                    <label style="float:left;">用户 角色：</label>
                <span style="float:left;display:block;">
                <?php foreach ($roles as $role): ?>
                    <input type="checkbox" name="roles[]" value="<?php echo $role['name']; ?>" <?php if (in_array($role['name'], $role_check)) echo 'checked="checked"' ?> />&nbsp;&nbsp;&nbsp;
                       <?= Html::encode($role['name']); ?>&nbsp;&nbsp;&nbsp; <br/>
                <?php endforeach; ?>
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



