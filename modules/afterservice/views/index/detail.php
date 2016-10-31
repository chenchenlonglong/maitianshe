<?php
/**
 * author: chenlong
 * Date: 2016/10/28
 * Time: 15:03
 */
use yii\widgets\ActiveForm;
?>

<div class="pageContent">
    <h2 class="contentTitle">售后详情</h2>
    <div class="pageFormContent" layoutH="100">
        <fieldset>
            <dl class="nowrap">
                <dt>订单编号：</dt>
                <dd><input type="text" name="order_id" readonly="readonly" value="<?php echo isset($data["order_id"])?$data["order_id"]:""?>" class="required"></dd>
            </dl>
        </fieldset>
        <fieldset>
            <dl class="nowrap">
                <dt>商品编号：</dt>
                <dd><input type="text" name="goods_sn"  readonly="readonly"value="<?php echo isset($data["goods_sn"])?$data["goods_sn"]:""?>"></dd>
            </dl>
        </fieldset>
        <fieldset>
            <dl class="nowrap">
                <dt>商品名称：</dt>
                <dd><input type="text" name="goods_name"  readonly="readonly" style="width: 400px" value="<?php echo isset($data["goods_name"])?$data["goods_name"]:""?>" class="required"></dd>
            </dl>
        </fieldset>
        <fieldset>
            <dl class="nowrap">
                <dt>收件人姓名：</dt>
                <dd><input type="text" name="receive_name"  readonly="readonly" value="<?php echo isset($data["receive_name"])?$data["receive_name"]:""?>" class="required"></dd>
            </dl>
        </fieldset>

        <fieldset>
            <dl class="nowrap">
                <dt>电话：</dt>
                <dd><input type="text" name="mobile" readonly="readonly"  value="<?php echo isset($data["phone"])?$data["phone"]:""?>" class="required"></dd>
            </dl>
        </fieldset>

        <fieldset>
            <dl class="nowrap">
                <dt>快递公司和运单号：</dt>
                <dd><input type="text" name="invoice_no" value="<?php echo isset($data["invoice_no"])?$data["invoice_no"]:""?>" class="required"></dd>
            </dl>
        </fieldset>

        <fieldset>
            <dl class="nowrap">
                <dt>售后微信名称：</dt>
                <dd><input type="text" name="wx_name" readonly="readonly"  value="<?php echo isset($data["wx_name"])?$data["wx_name"]:""?>"></dd>
            </dl>
        </fieldset>

        <fieldset>
            <dl class="nowrap">
                <dt>赔偿金额</dt>
                <dd><input type="text"  name="compensate_money"  readonly="readonly" value="<?php echo isset($data["compensate_money"])?$data["compensate_money"]:""?>" class="number"/></dd>
            </dl>
        </fieldset>

        <fieldset>
            <dl class="nowrap">
                <dt>售后起始日期</dt>
                <dd><input type="text" value="<?php echo !empty($data["start_time"])?date("Y:m:d H:i:s",$data["start_time"]):""?>" readonly="readonly"/></dd>
            </dl>
        </fieldset>
        <?php if($data["image_1_url"]){?>
        <fieldset>
            <dl class="nowrap">
                <dt>售后图片1：</dt>

                    <dd><img src="<?php echo $data["image_1_url"]?>" style="width: 400px;height: 400px;"></dd>

            </dl>
        </fieldset>
        <?php }?>

        <?php if($data["image_2_url"]){?>
        <fieldset>
            <dl class="nowrap">
                <dt>售后图片2：</dt>

                    <dd><img src="<?php echo $data["image_2_url"]?>" style="width: 400px;height: 400px;"></dd>

            </dl>
        </fieldset>
        <?php }?>
        <?php if($data["image_3_url"]){?>
        <fieldset>
            <dl class="nowrap">
                <dt>售后图片3：</dt>
                    <dd><img src="<?php echo $data["image_3_url"]?>" style="width: 400px;height: 400px;"></dd>
            </dl>
        </fieldset>
        <?php }?>
        <fieldset>
            <dl class="nowrap">
                <dt>情况描述</dt>
                <dd>
                    <div class="unit">
                        <textarea class="editor" name="description" rows="8" cols="100" tools="mini">
                            <?php echo isset($data["description"])?$data["description"]:""?>
                        </textarea>
                    </div>
                </dd>
            </dl>
        </fieldset>


        <fieldset>
            <dl class="nowrap">
                <dt>备注</dt>
                <dd><div class="unit">
                        <textarea class="editor" name="remark" rows="6" cols="100" tools="mini"><?php echo isset($data["remark"])?$data["remark"]:""?></textarea>
                    </div></dd>
            </dl>
        </fieldset>

        <fieldset>
            <dl class="nowrap">
                <dt>售后完成时间</dt>
                <dd><input type="text" value="<?php echo !empty($data["finish_time"])?date("Y:m:d H:i:s",$data["finish_time"]):""?>" readonly="readonly"/></dd>
            </dl>
        </fieldset>


        <div class="subBar">
            <ul>
                <li><div class="buttonActive"><div class="buttonContent"><button class="close">关闭</button></div></div></li>
            </ul>
        </div>
    </div>

