<?php
/**
 * author: chenlong
 * Date: 2016/8/8
 * Time: 14:35
 */
?>
<form id="pagerForm" method="post" action="index.php?r=audit/reduce/index">
    <input type="hidden" name="pageNum" value="<?php isset($data['page'])?$data["page"]:0;?>" />
    <input type="hidden" name="numPerPage" value="<?php echo isset($data['page_num'])?$data['page_num']:50;?>" />
</form>
<div class="pageHeader">
</div>

<div class="pageContent trainListPage">
    <div id="w_list_print">
        <table class="list" width="100%" targetType="navTab" layoutH=38 style="text-align: center">
            <thead style="text-align: center">
            <tr>
                <th width="80">序号</th>
                <th width="100">用户名称</th>
                <th width="125">用户微信号</th>
                <th width="80">提现金额</th>
                <th width="125">提现状态</th>
                <th width="100">提现原因</th>
                <th width="100">申请时间</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php  foreach($data["data"] as $value){?>
                <tr>
                    <td><?php echo $value["id"]?></td>
                    <td><?php echo $value["user_name"]?></td>
                    <td><?php echo $value["wx_name"]?></td>
                    <td><?php echo $value["amount"]?>元</td>
                    <td><?php echo Yii::$app->params["audit_status"][$value["flag"]];?></td>
                    <td><?php echo $value["reason"]?></td>
                    <td><?php echo date("Y-m-d",$value["time"]);?></td>
                    <td> <a  href="/index.php?r=audit/reduce/reduce_show&user_id=<?php echo $value["user_id"]?>&id=<?php echo $value["id"];?>"  target="dialog" rel="reduce_id_index_reduce" title="提现审批" >
                            <span>提现</span></a></td>
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
