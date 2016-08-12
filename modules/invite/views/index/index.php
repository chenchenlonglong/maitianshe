<?php
/**
 * author: chenlong
 * Date: 2016/7/26
 * Time: 9:32
 */
?>
<form id="pagerForm" method="post" action="index.php?r=invite/index/index">
    <input type="hidden" name="pageNum" value="<?php isset($data['page'])?$data["page"]:0;?>" />
    <input type="hidden" name="numPerPage" value="<?php echo isset($data['page_num'])?$data['page_num']:30;?>" />
</form>
<div class="pageHeader">
    <form   onsubmit="return navTabSearch(this);" action="index.php?r=invite/index/index" method="post" class="pageForm required-validate">
            <div class="searchBar">
                <table class="searchContent">
                    <tr>
                        <td>
                            今日生成邀请码条数:<span style="color: red"><?php echo $data["today"];?></span> 条
                        </td>
                        <td>
                            昨日生成邀请码条数:<span style="color: red"><?php echo $data["yesterday"];?></span> 条
                        </td>
                    </tr>
                    <tr>
                        <td>
                            所属管理员: <input type="text" name="user_name" value="<?php echo  isset($post['user_name'])?$post["user_name"]:"";?>">
                        </td>
                        <td>
                            所属团长: <input type="text" name="user_by_name" value="<?php echo  isset($post['user_by_name'])?$post["user_by_name"]:"";?>">
                        </td>
                        <td>
                            状态: <select name="invition_flag">
                                <option value="">请选择状态</option>
                                <?php foreach($data["invite_status"] as $key=>$value){?>
                                    <option  <?php if(isset($post["invition_flag"])){if($post["invition_flag"]==$key){echo 'selected="selected"';}}?> value="<?php echo $key ?>"><?php echo $value?></option>
                                <?php }?>
                            </select>
                        </td>
                        <td>
                            种类: <select name="invition_status">
                                <option value="">请选择种类</option>
                                <?php foreach($data["invite_status_group"] as $key=>$value){?>
                                    <option  <?php if(isset($post["invition_status"])){if($post["invition_status"]==$key){echo 'selected="selected"';}}?> value="<?php echo $key ?>"><?php echo $value?></option>
                                <?php }?>
                            </select>
                        </td>
                        <td>
                            生成时间：<input type="text"  name="start_time" value="<?php echo  isset($post['start_time'])?$post["start_time"]:"";?>" class="date" dateFmt="yyyy-MM-dd" readonly="true"/>

                        </td>
                        <td>
                            有效期：<input type="text"   name="end_time" value="<?php echo  isset($post['end_time'])?$post["end_time"]:"";?>" class="date" dateFmt="yyyy-MM-dd" readonly="true"/>
                        </td>
                        <td>
                            <div class="buttonActive"><div class="buttonContent"><button type="submit">查询</button></div></div>
                        </td>
                    </tr>
                </table>


            </div>
    </form>
</div>
<div class="pageContent trainListPage">
    <div id="w_list_print">
        <table class="list" width="100%" targetType="navTab" layoutH="88" style="text-align: center">
            <thead style="text-align: center">
            <tr>
                <th width="80">序号</th>
                <th width="125">邀请码</th>
                <th width="80">所属管理员名称</th>
                <th width="80">所属管理员微信号</th>
                <th width="80">所属团长名称</th>
                <th width="100">状态</th>
                <th width="100">种类</th>
                <th width="100">生成时间</th>
                <th width="125">有效期</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($data["data"] as $value){?>
                <tr>
                    <td><?php echo $value["invition_id"];?></td>
                    <td style="color: red"><?php echo $value["invition_code"];?></td>
                    <td><?php echo $value["e_user_name"];?></td>
                    <td><?php echo $value["e_user_wx_number"];?></td>
                    <td><?php echo $value["e_user_by_name"];?></td>
                    <td><?php echo Yii::$app->params["invate_status_group"][$value["invition_status"]];?></td>
                    <td><?php echo Yii::$app->params["invate_type"][$value["invition_flag"]];?></td>
                    <td><?php echo date("Y-m-d",$value["start_time"]);?></td>
                    <td><?php echo date("Y-m-d",$value["end_time"]);?></td>
                </tr>
            <?php }?>
            </tbody>
        </table>
    </div>

    <div class="panelBar" >
        <div class="pages">
            <span>显示</span>
            <select name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
                <option value="30"<?php if(isset($data['page_num']) && $data['page_num'] == 30){echo ' selected="selected"';}else{}?>>30</option>
                <option value="50"<?php if(isset($data['page_num']) && $data['page_num'] == 50){echo ' selected="selected"';}else{}?>>50</option>
                <option value="100"<?php if(isset($data['page_num']) && $data['page_num'] == 100){echo ' selected="selected"';}else{}?>>100</option>
                <option value="200"<?php if(isset($data['page_num']) && $data['page_num'] == 200){echo ' selected="selected"';}else{}?>>200</option>
            </select>
            <span>条，共<?php echo isset($data['total'])?$data['total']:0;?>条</span>
        </div>

        <div class="pagination" targetType="navTab" totalCount="<?php echo isset($data['total'])?$data['total']:0;?>"
             numPerPage="<?php echo isset($data['page_num'])?$data['page_num']:0;?>"
             pageNumShown="10" currentPage="<?php echo isset($data['page'])?$data['page']:0;?>"></div>

    </div>

</div>

