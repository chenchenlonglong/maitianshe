<?php
/**
 * author: chenlong
 * Date: 2016/7/26
 * Time: 9:32
 */
?>
<form id="pagerForm" method="post" action="index.php?r=invate/index/index">
    <input type="hidden" name="pageNum" value="<?php isset($data['page'])?$data["page"]:0;?>" />
    <input type="hidden" name="numPerPage" value="<?php echo isset($data['page_num'])?$data['page_num']:50;?>" />
</form>
<div class="pageHeader">
<!--    <div class="panelBar">-->
<!--        <ul class="toolBar">-->
<!--            <li><a class="add" href="index.php?r=admin/assignment/create" target="dialog" rel="assignment_id_create"><span>新增邀请码</span></a></li>-->
<!--        </ul>-->
<!--    </div>-->
        <div class="searchBar">
            <ul class="searchContent" style="margin-top: 10px;">
                <li>
                    <span>新增邀请码数量:</span>
                </li>
                <li>
                    <span>剩余邀请码数量:</span>
                </li>
                <li>
                    <span>系统分配邀请码:</span>
                </li>
            </ul>
        </div>

</div>
<div class="pageContent trainListPage">
    <div id="w_list_print">
        <table class="list" width="100%" targetType="navTab" layoutH="70" style="text-align: center">
            <thead style="text-align: center">
            <tr>
                <th width="80">序号</th>
                <th width="100">生成时间</th>
                <th width="125">有效期</th>
                <th width="125">邀请码</th>
                <th width="100">状态</th>
                <th width="100">种类</th>
                <th width="80">获得途径</th>
                <th width="80">所属会员</th>
                <th width="80">所属团队</th>
                <th width="80">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($data["data"] as $value){?>
            <tr>
                <td><?php echo $value["invition_id"];?></td>
                <td><?php echo date("Y-m-d",$value["start_time"]);?></td>
                <td><?php echo date("Y-m-d",$value["end_time"]);?></td>
                <td><?php echo $value["invition_code"];?></td>
                <td><?php echo Yii::$app->params["invate_status_group"][$value["invition_status"]];?></td>
                <td><?php echo Yii::$app->params["invate_type"][$value["invition_flag"]];?></td>
                <td><?php echo $value["user_by_id"];?></td>
                <td><?php echo $value["invition_id"];?></td>
                <td><?php echo $value["invition_id"];?></td>
                <td><?php echo $value["invition_id"];?></td>
            </tr>
            <?php }?>
            </tbody>
        </table>
    </div>

    <div class="panelBar" >
        <div class="pages">
            <span>显示</span>
            <select name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
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
