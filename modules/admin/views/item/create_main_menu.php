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
                <label><?php echo $title; ?>名字：</label>
                <input class="required" name="name" type="text" size="30" value="<?php echo $model->name ?>"/>
            </p>

            <input name="type" type="hidden" size="30" value="<?php echo $type; ?>"/>

            <p>
                <label><?php echo $title; ?> 描述：</label>
                <textarea name="description" rows="5" cols="32">
                    <?php echo $model->description ?>
                </textarea>
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



