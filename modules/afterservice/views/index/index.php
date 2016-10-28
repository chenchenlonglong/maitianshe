<?php
/**
 * author: chenlong
 * Date: 2016/8/1
 * Time: 9:41
 */
?>
<form id="pagerForm" method="post" action="index.php?r=afterservice/index/index">
    <input type="hidden" name="pageNum" value="<?php isset($data['page'])?$data["page"]:0;?>" />
    <input type="hidden" name="numPerPage" value="<?php echo isset($data['page_num'])?$data['page_num']:20;?>" />
</form>
<div class="pageHeader">
    <form   onsubmit="return navTabSearch(this);" action="index.php?r=afterservice/index/add" method="post" class="pageForm required-validate">
    <div class="panelBar">
        <ul class="toolBar">
            <li><input type="text" name="order_id" id="order_id" value="请输入订单编号"/></li>
            <li><div class="buttonActive"><div class="buttonContent"><button type="submit">添加售后</button></div></div></li>
        </ul>
    </div>
    </form>
    <hr/>


    <form   onsubmit="return navTabSearch(this);" action="index.php?r=afterservice/index/index" method="post" class="pageForm required-validate">
        <div class="searchBar">
            <table class="searchContent">
                <tr>
                    <td>
                        电话号码：<input type="text" name="phone" value="<?php  echo isset($data['phone'])?$data['phone']:"";?>" />
                    </td>
                    <td>
                        订单编号：<input type="text" name="order_id" value="<?php  echo isset($data['order_id'])?$data['order_id']:"";?>" />
                    </td>
                    <td>
                       处理结果
                        <select name="result">
                            <option value="">请选择</option>
                            <option value="0">正在处理</option>
                            <option value="1">售后完毕</option>
                        </select>
                    </td>
                    <td><div class="buttonActive"><div class="buttonContent"><button type="submit">查询</button></div></div></td>
                </tr>
            </table>
        </div>
    </form>
</div>

<div class="pageContent trainListPage">
    <div id="w_list_print">
        <table class="list" width="100%" targetType="navTab"  layoutH="105" style="text-align: center">
            <thead style="text-align: center">
            <tr>
                <th width="60">售后id</th>
                <th width="100">订单编号</th>
                <th width="125">商品编号</th>
                <th width="125">商品名称</th>
                <th width="80">收件人姓名</th>
                <th width="80">收件人电话号码</th>
                <th width="125">快递公司和运单号</th>
                <th width="100">赔偿金额</th>
                <th width="100">售后起始时间</th>
                <th width="100">处理结果</th>
                <th width="80">操作</th>
            </tr>
            </thead>
            <tbody>
                <?php  if($data["data"]){
                    foreach($data["data"] as $value){
                ?>
            <tr>
                <td> <?php echo $value["id"]?></a></td>
                <td><?php echo $value["order_id"]?></td>
                <td><?php echo $value["goods_sn"]?></td>
                <td><?php echo $value["goods_name"]?></td>
                <td><?php echo $value["receive_name"]?></td>
                <td><?php echo $value["phone"]?></td>
                <td><?php echo $value["invoice_no"]?></td>
                <td><?php echo $value["compensate_money"]?></td>
                <td><?php echo date("Y-m-m H:i:s",$value["start_time"]);?></td>
                <td><?php echo Yii::$app->params["after_service"][$value["result"]];?></td>
                <td><?php if(!$value["result"]){?>
                    <a  href="<?php echo  \yii\helpers\Url::toRoute(["index/change"])."&id=".$value["id"];?>"  max="true"  target="navTab">
                        <span>修改</span>
                    </a>
                    &nbsp;
                    <a  href="<?php echo  \yii\helpers\Url::toRoute(["index/push"])."&id=".$value["id"];?>"  class="del"  target="ajaxTodo" title="提交过后不能修改，是否提交？">
                      <span>提交</span>
                     </a>
                     <?php }else{?>
                   <a  href="<?php echo  \yii\helpers\Url::toRoute(["index/push"])."&id=".$value["id"];?>"    max="true"  target="navTab">
                       <span>详情</span>
                   </a>
                     <?php }?>
                 </td>

            </tr>
            <?php }}?>
            </tbody>
        </table>
    </div>

    <div class="panelBar" >
        <div class="pages">
            <span>显示</span>
            <select name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
                <option value="20"<?php if(isset($data['page_num']) && $data['page_num'] == 20){echo ' selected="selected"';}else{}?>>20</option>
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

<script type="text/javascript">
    $(function(){
        $("#order_id").click(function(){
            $("#order_id").val("");
        })
    })
</script>