<?php
/**
 * Created by PhpStorm.
 * User: chenlong
 * Date: 2016/8/1
 * Time: 23:13
 */
?>
<form id="pagerForm" method="post" action="index.php?r=invate/admin/index_temporary">
    <input type="hidden" name="pageNum" value="<?php isset($data['page'])?$data["page"]:0;?>" />
    <input type="hidden" name="numPerPage" value="<?php echo isset($data['page_num'])?$data['page_num']:50;?>" />
</form>
<div class="pageHeader">

</div>
<div class="pageContent trainListPage">
    <div id="w_list_print">
        <table class="list" width="100%" targetType="navTab" layoutH="62" style="text-align: center">
            <thead style="text-align: center">
            <tr>
                <th width="80">序号</th>
                <th width="80">羊皮卷显示姓名</th>
                <th width="80">微信号</th>
                <th width="80">年龄阶段</th>
                <th width="80">注册电话号</th>
                <th width="80">用户邮箱</th>
                <th width="80">团队名称</th>
                <th width="80">外交官徽章数</th>
                <th width="80">超级组徽章数</th>
                <th width="80">支付宝账户</th>
                <th width="80">激活日期</th>
                <th width="80">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($data["data"] as $value){?>
                <tr>
                    <td><?php  echo $value["user_id"];?></td>
                    <td><?php  echo $value["e_user_name"];?></td>
                    <td><?php  echo $value["e_user_wx_number"];?></td>
                    <td><?php  echo $value["e_age_group"];?></td>
                    <td><?php  echo $value["e_register_phone"];?></td>
                    <td><?php  echo $value["e_register_email"];?></td>
                    <td><?php  echo $value["e_admin_team_name"];?></td>
                    <td><?php  echo $value["e_diplomat_medal_number"];?></td>
                    <td><?php  echo $value["e_super_medal_number"];?></td>
                    <td><?php  echo $value["e_alipay_number"];?></td>
                    <td><?php  echo $value["e_active_time"];?></td>
                    <td><a href="/index.php?r=sys/product/edit_show&app_id=<?php echo $value["user_id"]?>"  max="true"  target="navTab" title="用户详情" >
                            <span>生成邀请码</span>
                        </a></td>
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
