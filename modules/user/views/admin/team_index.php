<?php
/**
 * author: chenlong
 * Date: 2016/8/15
 * Time: 10:39
 */
use app\common\Statistics;
?>
<form id="pagerForm" method="post" action="index.php?r=user/admin/team_show">
    <input type="hidden" name="pageNum" value="<?php isset($data['page'])?$data["page"]:0;?>" />
    <input type="hidden" name="numPerPage" value="<?php echo isset($data['page_num'])?$data['page_num']:50;?>" />
</form>
<div class="pageHeader">
    <form   onsubmit="return navTabSearch(this);" action="index.php?r=user/admin/team_show" method="post" class="pageForm required-validate">
        <div class="searchBar">
            <table class="searchContent">
                <tr>
                    <td>
                        团长姓名：<input type="text" name="user_name" value="<?php echo isset($data["user_name"])?$data["user_name"]:"";?>">
                    </td>
                    <td><div class="buttonActive"><div class="buttonContent"><button type="submit">查询</button></div></div></td>
                    <td >
                        团队总人数为:<span style="color: red; margin-left: 10px;"><?php  echo isset($data['total'])?$data["total"]:0?>人</span>
                    </td>
                    <td >
                        今日新加入数为:<span style="color: red; margin-left: 10px;"><?php echo $data["reg_today"]?>人</span>
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
                <th width="80">用户id</th>
                <th width="80">团长姓名</th>
                <th width="80">微信号</th>
                <th width="80">年龄阶段</th>
                <th width="80">注册电话号</th>
                <th width="80">用户邮箱</th>
                <th width="80">外交官徽章数</th>
                <th width="80">超级组徽章数</th>
                <th width="80">支付宝账户</th>
                <th width="80">支付宝收款姓名</th>
                <th width="80">历史成单数</th>
            </tr>
            </thead>
            <tbody>
            <?php  foreach($data["data"] as $value){?>
                <tr>
                    <td><?php echo $value["user_id"];?></td>
                    <td><?php  echo $value["e_user_name"];?></td>
                    <td><?php  echo $value["e_user_wx_number"];?></td>
                    <td><?php  echo Yii::$app->params["age_group"][$value["e_age_group"]];?></td>
                    <td><?php  echo $value["e_register_phone"];?></td>
                    <td><?php  echo $value["e_register_email"];?></td>
                    <td><?php  echo $value["e_diplomat_medal_number"];?></td>
                    <td><?php  echo $value["e_super_medal_number"];?></td>
                    <td><?php  echo $value["e_alipay_number"];?></td>
                    <td><?php  echo $value["e_beneficiary_name"];?></td>
                    <td><?php  echo Statistics::count_finish_team($value["user_id"])."单";?></td>
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

