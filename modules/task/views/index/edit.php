<?php
/**
 * author: chenlong
 * Date: 2016/8/4
 * Time: 16:53
 */
?>
<div class="pageContent">
    <form   method="post" action="index.php?r=task/index/edit" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone);">
        <div class="pageFormContent" layoutH="56">
            <div class="auth-item-model-form">
                <p>
                    <label>任务名称：</label>
                    <input name="task_name" type="text" size="30" value="<?php echo $data["task_name"];?>"/>
                    <input  name="id" type="hidden" value="<?php echo $data["id"];?>"/>
                </p>
                <p>
                    <label>任务等级：</label>
                    <select name="task_level">
                        <?php foreach($data["level"] as $key=>$value){?>
                        <option    <?php  if($data["task_level"]==$key){ echo "selected='selected'";}?>  value="<?php echo $key?>"><?php echo $value?></option>
                        <?php }?>
                    </select>
                </p>

                <p>
                    <label>任务描述：</label>
                    <input name="commission_describe" type="text" size="30" value="<?php echo $data["commission_describe"];?>"/>
                </p>
                <p>
                    <label>拼团描述：</label>
                    <input name="team_describe" type="text" size="30" value="<?php echo $data["team_describe"];?>"/>
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