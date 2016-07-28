<?php
/**
 * @Author: oj
 * @Date: 2016/3/16
 * @Time: 17:30
 */
use yii\helpers\Html;
use \yii\widgets\ActiveForm;
?>

<div class="auth-item-model-form">

    <?php $form = ActiveForm::begin();?>

    <?= $form->field($model,'name')->textInput(['maxlength' => true]); ?>

    <?= $form->field($model,'type')->dropDownList(['1' => '角色','2' => '权限']); ?>

    <?= $form->field($model,'description')->textArea(['rows' => 6]); ?>

    <div class="form-group">

        <?= Html::submitButton('保存',['class' => 'btn btn-success green'])?>

    </div>
    <?php ActiveForm::end();?>


</div>



