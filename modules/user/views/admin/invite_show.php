<?php
/**
 * Created by PhpStorm.
 * User: chenlong
 * Date: 2016/8/10
 * Time: 23:19
 */
?>
<div class="pageContent">
    <form   method="post" action="index.php?r=invite/user/get_invite_admin" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone);">
        <div class="pageFormContent" layoutH="56">
            <div class="auth-item-model-form">
                <p>
                    <label>管理员名称：</label>
                    <?php  echo $user_name;?>
                    <input  name="user_id" type="hidden" value="<?php echo $user_id;?>"/>
                </p>

                <p>
                    <label>生成团长邀请码数量：</label>
                    <input name="num" type="text" size="30" value="" class="requi   red"/>
                </p>
            </div>

        </div>
        <div class="formBar">
            <ul>
                <li>
                    <div class="buttonActive">
                        <div class="buttonContent">
                            <button type="submit">生成邀请码</button>
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
</div>
