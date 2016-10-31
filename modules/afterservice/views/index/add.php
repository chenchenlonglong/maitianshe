<?php
/**
 * author: chenlong
 * Date: 2016/10/28
 * Time: 15:03
 */
use yii\widgets\ActiveForm;
?>

<div class="pageContent">
    <h2 class="contentTitle">添加售后</h2>
<!--    <form   method="post" action="index.php?r=afterservice/index/edit"    class="pageForm required-validate"   enctype="multipart/form-data" onsubmit="return validateCallback(this, dialogAjaxDone);">-->
<!--        -->
    <?php $form = ActiveForm::begin(["options" => ['enctype' => 'multipart/form-data',"onsubmit"=>"return iframeCallback(this);"],
            "action"=>"index.php?r=afterservice/index/edit",
            "class"=>"pageForm required-validate"]) ?>
        <div class="pageFormContent" layoutH="100">
            <fieldset>
                <dl class="nowrap">
                    <dt>订单编号：</dt>
                    <dd><input type="text" name="order_id" readonly="readonly" value="<?php echo isset($order_id)?$order_id:""?>" class="required"></dd>
                </dl>
            </fieldset>
            <fieldset>
                <dl class="nowrap">
                    <dt>商品编号：</dt>
                    <dd><input type="text" name="goods_sn" readonly="readonly" value="<?php echo isset($goods_sn)?$goods_sn:""?>"></dd>
                </dl>
            </fieldset>
            <fieldset>
                <dl class="nowrap">
                    <dt>商品名称：</dt>
                    <dd><input type="text" name="goods_name" readonly="readonly"  style="width: 400px" value="<?php echo isset($goods_name)?$goods_name:""?>" class="required"></dd>
                </dl>
            </fieldset>
            <fieldset>
                <dl class="nowrap">
                    <dt>收件人姓名：</dt>
                    <dd><input type="text" name="receive_name" readonly="readonly" value="<?php echo isset($receive_name)?$receive_name:""?>" class="required"></dd>
                </dl>
            </fieldset>

            <fieldset>
                <dl class="nowrap">
                    <dt>电话：</dt>
                    <dd><input type="text" name="mobile" readonly="readonly" value="<?php echo isset($mobile)?$mobile:""?>" class="required"></dd>
                </dl>
            </fieldset>

            <fieldset>
                <dl class="nowrap">
                    <dt>快递公司和运单号：</dt>
                    <dd><input type="text" name="invoice_no" readonly="readonly" value="<?php echo isset($invoice_no)?$invoice_no:""?>" class="required"></dd>
                </dl>
            </fieldset>

            <fieldset>
                <dl class="nowrap">
                    <dt>售后微信名称：</dt>
                    <dd><input type="text" name="wx_name"></dd>
                </dl>
            </fieldset>

            <fieldset>
                <dl class="nowrap">
                    <dt>赔偿金额</dt>
                    <dd><input type="text"  name="compensate_money" class="number"/></dd>
                </dl>
            </fieldset>

            <fieldset>
                <dl class="nowrap">
                    <dt>售后起始日期</dt>
                   <dd><input type="text"  name="start_time" class="date" dateFmt="yyyy-MM-dd HH:mm:ss" readonly="true" required="required"/></dd>
                </dl>
            </fieldset>

            <fieldset>
                <dl class="nowrap">
                    <dt>售后图片1：</dt>
                    <dd><?= $form->field($model, "image_1_url")->fileInput() ?></dd>
                </dl>
            </fieldset>
            <fieldset>
                <dl class="nowrap">
                    <dt>售后图片2：</dt>
                    <dd><?= $form->field($model, "image_2_url")->fileInput() ?></dd>
                </dl>
            </fieldset>
            <fieldset>
                <dl class="nowrap">
                    <dt>售后图片3：</dt>
                    <dd><?= $form->field($model, "image_3_url")->fileInput() ?></dd>
                </dl>
            </fieldset>

            <fieldset>
                <dl class="nowrap">
                    <dt>情况描述</dt>
                    <dd>
                        <div class="unit">
                            <textarea class="editor" name="description" rows="8" cols="100" tools="mini"></textarea>
                        </div>
                    </dd>
                </dl>
            </fieldset>


            <fieldset>
                <dl class="nowrap">
                    <dt>备注</dt>
                    <dd><div class="unit">
                            <textarea class="editor" name="remark" rows="6" cols="100" tools="mini"></textarea>
                        </div></dd>
                </dl>
            </fieldset>


            <div class="subBar">
                <ul>
                    <li><div class="buttonActive"><div class="buttonContent"><button type="submit">添加售后</button></div></div></li>
                </ul>
            </div>
            <?php ActiveForm::end() ?>
</div>

