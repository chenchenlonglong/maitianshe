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
            <p>
                <label>账户 名称：</label>
                <input name="user_name" type="text" size="30" value="<?php echo isset($data['user_name'])?:'';?>"/>
            </p>

            <p>
                <label>用户 密码：</label>
                <input name="password" type="text" size="30" value="<?php echo isset($data['password'])?:'';?>"/>
            </p>
            <p>
                <label>用户名：</label>
                <input name="customer_name" type="text" size="30" value="<?php echo isset($data['password'])?:'';?>"/>
            </p>

            <p>
                <label  style="float:left;">用户 角色：</label>
                 <span style="float:left;display:block;">
                <?php foreach ($roles as $role): ?>
                    <input type="checkbox" name="roles[]" value="<?php echo $role['name']; ?>"/>&nbsp;&nbsp;&nbsp;
                    <?= Html::encode($role['name']); ?>&nbsp;&nbsp;&nbsp;<br/>
                <?php endforeach; ?>
                     </span>
            </p>
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



