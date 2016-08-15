<?php
/**
 * author: chenlong
 * Date: 2016/8/10
 * Time: 9:51
 */
?>
<div class="pageContent">
    <?php if(!empty($data)){?>
    <form   method="post" action="index.php?r=audit/reduce/reduce" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone);">
        <div class="pageFormContent" layoutH="56">
            <div class="auth-item-model-form">
                <input type="hidden" value="<?php  echo $data["id"]?>"       name="id">
                <input type="hidden" value="<?php  echo $data["user_id"]?>"  name="user_id">
                <p>
                    <label>提现用户：</label>
                    <?php  echo $data["user_name"]?>
                </p>
                <p>
                    <label>用户联系电话：</label>
                    <?php  echo $data["telephone"]?>
                </p>
                <p>
                    <label>用户所在组名称：</label>
                    <?php  echo $data["team_name"]?>
                </p>
                <p>
                    <label>用户微信号：</label>
                    <?php  echo $data["wx_name"]?>
                </p>
                <p>
                    <label>提现原因：</label>
                    <?php  echo $data["reason"]?>
                </p>
                <p>
                    <label>提现金额：</label>
                    <span style="color: red"> <?php  echo $data["amount"]?>元</span>
                </p>
                <p>
                    <label>用户可提现总金额：</label>
                    <span style="color: red"> <?php  echo $data["reduce_all_money"]?>元</span>
                </p>

            </div>

        </div>
        <div class="formBar">
            <ul>
                <li>
                    <div class="buttonActive">
                        <div class="buttonContent">
                            <button type="submit">确定提现</button>
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
    </form>
    <?php }else{
        echo "数据异常";
    }?>
</div>
