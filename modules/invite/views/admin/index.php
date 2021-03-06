<?php
/**
 * Created by PhpStorm.
 * User: chenlong
 * Date: 2016/8/1
 * Time: 22:45
 */
?>

<form id="pagerForm" method="post" action="index.php?r=invite/admin/index_temporary">
    <input type="hidden" name="pageNum" value="<?php isset($data['page'])?$data["page"]:0;?>" />
    <input type="hidden" name="numPerPage" value="<?php echo isset($data['page_num'])?$data['page_num']:30;?>" />
</form>
<div class="pageHeader">
    <form  action="index.php?r=invite/admin/get_invite" method="post" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone);">
        <div class="searchBar">
            <table class="searchContent">
                <tr>
                    <td>
                        管理员临时邀请码生成数量：
                        <input type="text" name="num"  id="num"/>
                    </td>
                    <td style="color: red"> 单次生成数量不超过5条</td>
                    <td>
                        <div class="buttonActive">
                            <div class="buttonContent">
                                <button class="sub">生成</button>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </form>
</div>
<div class="pageContent trainListPage">
    <div id="w_list_print">
        <table class="list" width="100%" targetType="navTab" layoutH="62" style="text-align: center">
            <thead style="text-align: center">
            <tr>
                <th width="80">序号</th>
                <th width="125">邀请码</th>
                <th width="80">所属管理员名称</th>
                <th width="80">所属管理员微信号</th>
                <th width="80">所属团长名称</th>
                <th width="80">所属团长微信号</th>
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


