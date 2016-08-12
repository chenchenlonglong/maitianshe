<?php
/**
 * author: chenlong
 * Date: 2016/8/10
 * Time: 17:04
 */
?>
<form id="pagerForm" method="post" action="index.php?r=audit/reduce/reduce_history">
    <input type="hidden" name="pageNum" value="<?php isset($data['page'])?$data["page"]:0;?>" />
    <input type="hidden" name="numPerPage" value="<?php echo isset($data['page_num'])?$data['page_num']:50;?>" />
</form>
<div class="pageHeader">
    <form   onsubmit="return navTabSearch(this);" action="index.php?r=audit/reduce/reduce_history" method="post" class="pageForm required-validate">
        <div class="searchBar">
            <table class="searchContent">
                <tr>
                    <td>
                        用户名称：<input type="text" name="user_name" value="<?php echo isset($post["user_name"])?$post["user_name"]:"";?>" />
                    </td>
                    <td>
                        提现状态：<select name="flag">
                            <option value="">全部状态</option>
                             <?php  foreach($data["audit_status"] as $key=>$value){?>
                            <option  <?php  if(isset($post["flag"])){if ($post["flag"]==$key){ echo "selected='selected'";}}?>    value="<?php echo $key?>"><?php echo $value?></option>
                            <?php }?>
                        </select>
                    </td>
                    <td>

                        申请时间：<input type="text"  name="start_time"
                                    value="<?php if(!empty($post["start_time"])){echo $post["start_time"]; }?>"
                                    class="date" dateFmt="yyyy-MM-dd" readonly="true"/>
                    </td>
                    <td>
                        处理时间：<input type="text"  name="audit_time"
                                    value="<?php if(!empty($post["audit_time"])){echo $post["audit_time"]; }?>"
                                    class="date" dateFmt="yyyy-MM-dd" readonly="true"/>
                    </td>

                    <td><div class="buttonActive"><div class="buttonContent"><button type="submit">查询</button></div></div></td>
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
                <th width="100">用户名称</th>
                <th width="125">用户微信号</th>
                <th width="80">提现金额</th>
                <th width="125">提现状态</th>
                <th width="100">提现原因</th>
                <th width="100">申请时间</th>
                <th width="100">处理时间</th>
                <th width="100">处理用户</th>
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
                    <td><?php echo empty($value["audit_time"])?"":date("Y-m-d",$value["audit_time"]);?></td>
                    <td><?php echo $value["audit_name"];?></td>
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

