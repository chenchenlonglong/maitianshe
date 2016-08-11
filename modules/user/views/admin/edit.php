<?php
/**
 * author: chenlong
 * Date: 2016/8/11
 * Time: 14:37
 */
use yii\widgets\ActiveForm;
?>
<div class="pageContent">
    <?php $form = ActiveForm::begin(["options" => ['enctype' => 'multipart/form-data',"onsubmit"=>"return iframeCallback(this);"],
        "action"=>"index.php?r=user/admin/edit",
        "class"=>"pageForm required-validate"]) ?>
    <div class="pageFormContent" layoutH="100">
            <h2 class="contentTitle">管理员信息修改</h2>
            <fieldset>
                <dl class="nowrap">
                    <input type="hidden" name="user_id" value="<?php echo $data["user_id"]?>">
                    <dt>管理员名称：</dt>
                    <dd><input name="e_user_name" class="required" style="width:30%" value="<?php  echo $data["e_user_name"]?>"></dd>
                </dl>
            </fieldset>

            <fieldset>
                <dl class="nowrap">
                    <dt>微信号</dt>
                    <dd><input name="e_user_wx_number" class="required"  style="width:30%" value="<?php  echo $data["e_user_wx_number"]?>"></dd>
                </dl>
            </fieldset>

            <fieldset>
                <dl class="nowrap">
                    <dt>年龄段：</dt>
                    <dd> <select name="e_age_group">
                            <?php foreach($data["age_group"] as $key=>$value){?>
                            <option <?php if($data["e_age_group"]==$key){ echo "selected='selected'";}?> value="<?php echo $key?>"><?php echo $value?></option>
                            <?php }?>
                        </select></dd>
                </dl>
            </fieldset>

        <fieldset>
            <dl class="nowrap">
                <dt>团队名称</dt>
                <dd><input name="e_admin_team_name" class="required"  style="width:30%" value="<?php  echo $data["e_admin_team_name"]?>"></dd>
            </dl>
        </fieldset>

        <fieldset>
            <dl class="nowrap">
                <dt>注册电话号码</dt>
                <dd><input name="e_register_phone" class="required"  style="width:30%" value="<?php  echo $data["e_register_phone"]?>"></dd>
            </dl>
        </fieldset>

        <fieldset>
            <dl class="nowrap">
                <dt>注册邮箱</dt>
                <dd><input name="e_register_email" class="required"  style="width:30%" value="<?php  echo $data["e_register_email"]?>"></dd>
            </dl>
        </fieldset>

        <fieldset>
            <dl class="nowrap">
                <dt>管理员支付宝账户</dt>
                <dd><input name="e_alipay_number" class="required"  style="width:30%" value="<?php  echo $data["e_alipay_number"]?>"></dd>
            </dl>
        </fieldset>

        <fieldset>
            <dl class="nowrap">
                <dt>支付宝收款姓名</dt>
                <dd><input name="e_beneficiary_name" class="required"  style="width:30%" value="<?php  echo $data["e_beneficiary_name"]?>"></dd>
            </dl>
        </fieldset>


            <fieldset>
                <dl class="nowrap">
                    <dt>管理员二维码文件名：</dt>
                    <dd><input name="e_admin_wx_code_img" class="required" style="width:60%"  disabled="true" value="<?php  echo $data["e_admin_wx_code_img"]?>">
                    只能上传png,jpg,bmp格式的图片
                    </dd>
                    <dd><?= $form->field($model, "e_admin_wx_code_img")->fileInput() ?></dd>
                </dl>
            </fieldset>
        <div class="subBar">
            <ul>
                <li><div class="buttonActive"><div class="buttonContent"><button type="submit">编辑员工</button></div></div></li>
            </ul>
        </div>
        <?php ActiveForm::end() ?>
    </div>
