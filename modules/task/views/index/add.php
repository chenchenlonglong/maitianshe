<?php
/**
 * author: chenlong
 * Date: 2016/8/4
 * Time: 16:53
 */
?>
<div class="pageContent">
    <form   method="post" action="index.php?r=task/index/add" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone);">
        <div class="pageFormContent" layoutH="56">
            <div class="auth-item-model-form">
                <p>
                    <label>任务名称：</label>
                    <input name="task_name" type="text" size="30" class="required" />

                </p>

                <p>
                    <label>任务等级：</label>
                    <select name="task_level">
                        <option value="">请选择任务等级</option>
                        <?php foreach($data["level"] as $key=>$value){?>
                            <option value="<?php echo $key?>"><?php echo $value?></option>
                        <?php }?>
                    </select> <label style="color: red">必选</label>
                </p>
                <p>
                    <label>任务描述：</label>
                    <input name="commission_describe" type="text" size="30" class="required" />
                </p>
                <p>
                    <label>拼团描述：</label>
                    <input name="team_describe" type="text" size="30" class="required"/>
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
    </form>
</div>