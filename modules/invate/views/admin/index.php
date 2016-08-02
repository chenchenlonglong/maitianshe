<?php
/**
 * Created by PhpStorm.
 * User: chenlong
 * Date: 2016/8/1
 * Time: 22:45
 */
?>

<form id="pagerForm" method="post" action="index.php?r=invate/admin/index_temporary">
    <input type="hidden" name="pageNum" value="<?php isset($data['page'])?$data["page"]:0;?>" />
    <input type="hidden" name="numPerPage" value="<?php echo isset($data['page_num'])?$data['page_num']:50;?>" />
</form>
<div class="pageHeader">
    <form   onsubmit="return navTabSearch(this);" action="index.php?r=invate/admin/get_invate" method="post" class="pageForm required-validate">
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
<script type="text/javascript">
    $(function(){
        $(".sub").click(function(){
            var num =$("#num").val();
            var num_preg=/ "^\\d+$"/;
            if(num=="" || !num_preg.test(num)){
                alert("输入的格式不正确");
                return;
            }
            if(num>5){
                alert("超过邀请码生成最大限制");
                return;
            }
            alertMsg.confirm("您生成邀请码数量为"+num+",是否确认", {
                okCall: function(){
                    $(".pageHeader form").submit();
                }

        })
    });
</script>

