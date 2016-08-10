<?php
/**
 * author: chenlong
 * Date: 2016/8/1
 * Time: 10:45
 */
?>
<div class="pageContent">
    <h2 class="contentTitle">编辑渠道</h2>
    <form   method="post" action="index.php?r=goods/index/edit" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone);">
        <div class="pageFormContent" layoutH="100">
            <fieldset>
                <dl class="nowrap">
                    <dt>商品id：</dt>
                    <dd><input   disabled="disabled"  value="<?php echo $data["goods_id"]?>"></dd>
                </dl>
            </fieldset>

            <fieldset>
                <dl class="nowrap">
                    <dt>商品名称</dt>
                    <dd><input   disabled="disabled"   value="<?php echo $data["goods_name"]?>" ></dd>
                </dl>
            </fieldset>

            <fieldset>
                <dl class="nowrap">
                    <dt>商品描述</dt>
                    <dd><input   disabled="disabled"   style="width:60%;" value="<?php echo $data["goods_brief"]?>" ></dd>
                </dl>
            </fieldset>

            <fieldset>
                <dl class="nowrap">
                    <dt>任务等级</dt>
                    <dd><select name="task_level">
<<<<<<< HEAD
                            <?php foreach($task as $value){ ?>
=======
                            <?php foreach($task as  $value){ ?>
>>>>>>> f38e7206b9a1b5bee763e22f8e5af22800554d13
                                <option   <?php  if($data["task_level"]==$value["task_level"]){
                                    echo 'selected="selected"';
                                }?> value="<?php echo $value["task_level"]?>"><?php echo $value["task_name"]?></option>
                            <?php }?>
                        </select></dd>
                </dl>
            </fieldset>

            <fieldset>
                <dl class="nowrap">
                    <dt>奖金</dt>
                    <dd><input name="reward"       value="<?php echo $data["reward"]?>" ></dd>
                </dl>
            </fieldset>
            <fieldset>
                <dl class="nowrap">
                    <dt>佣金</dt>
                    <input  type="hidden"     name="goods_id"  value="<?php echo $data["goods_id"]?>" >
                    <dd><input name="commision"     value="<?php echo $data["commision"]?>" ></dd>
                </dl>
            </fieldset>





            <div class="subBar">
                <ul>
                    <li><div class="buttonActive"><div class="buttonContent"><button type="submit">编辑</button></div></div></li>
                </ul>
            </div>
    </form>
</div>
