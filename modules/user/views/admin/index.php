<?php
/**
 * Created by PhpStorm.
 * User: chenlong
 * Date: 2016/8/1
 * Time: 23:13
 */
use app\common\Statistics;
use app\common\User;
use app\common\Invite;
?>
<form id="pagerForm" method="post" action="index.php?r=user/admin/index">
    <input type="hidden" name="pageNum" value="<?php isset($data['page'])?$data["page"]:0;?>" />
    <input type="hidden" name="numPerPage" value="<?php echo isset($data['page_num'])?$data['page_num']:50;?>" />
</form>
<div class="pageHeader">
    <form   onsubmit="return navTabSearch(this);" action="index.php?r=user/admin/index" method="post" class="pageForm required-validate">
        <div class="searchBar">
            <table class="searchContent">
                <tr>
                    <td>
                        管理员姓名：<input type="text" name="admin_name" value="<?php  echo isset($data['admin_name'])?$data['admin_name']:"";?>" />
                    </td>
                    <td><div class="buttonActive"><div class="buttonContent"><button type="submit">查询</button></div></div></td>
                    <td >
                        普通用户人数:<span style="color: red; margin-left: 10px;"><?php echo $data["common_user"];?>人</span>
                    </td>      <td >
                        团长用户人数:<span style="color: red; margin-left: 10px;"><?php echo $data["user"];?>人</span>
                    </td>
                    <td >
                        管理员用户人数为:<span style="color: red; margin-left: 10px;"><?php echo $data['admin'];?>人</span>
                    </td>
                    <td>|||</td>
                    <td >
                        今日新加管理员人数为:<span style="color: red; margin-left: 10px;"><?php echo $data['today_admin'];?>人</span>
                    </td>
                    <td >
                        今日新加团长人数为:<span style="color: red; margin-left: 10px;"><?php echo $data['today_user'];?>人</span>
                    </td>
                    <td >
                        今日新加普通用户人数为:<span style="color: red; margin-left: 10px;"><?php echo $data['today_common_user'];?>人</span>
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
                <th width="80">管理员姓名</th>
                <th width="80">微信号</th>
                <th width="80">年龄阶段</th>
                <th width="80">注册电话号</th>
                <th width="80">用户邮箱</th>
                <th width="80">团队名称</th>
                <th width="80">团队人数</th>
                <th width="80">团队成单数</th>
                <th width="80">剩余邀请码数</th>
                <th width="80">外交官徽章数</th>
                <th width="80">超级组徽章数</th>
                <th width="80">支付宝账户</th>
                <th width="80">支付宝收款姓名</th>
                <th width="80">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($data["data"] as $value){?>
                <tr>
                    <td><?php  echo $value["user_id"];?></td>
                    <td><?php  echo $value["e_user_name"];?></td>
                    <td><?php  echo $value["e_user_wx_number"];?></td>
                    <td><?php  echo Yii::$app->params["age_group"][$value["e_age_group"]];?></td>
                    <td><?php  echo $value["e_register_phone"];?></td>
                    <td><?php  echo $value["e_register_email"];?></td>
                    <td>
                        <a href="/index.php?r=user/admin/team_show&team_name=<?php echo $value["e_admin_team_name"]?>"  max="true"  target="navTab" title="团队详情" >
                        <?php  echo   $value["e_admin_team_name"];?>
                        </a>
                    </td>
                    <td><?php  echo  User::admin_team_num($value["user_id"])."人";?></td>
                    <td><?php  echo  Statistics::get_admin_team_num($value["user_id"]);?></td>
                    <td><?php  echo  Invite::get_residue_invite($value["user_id"]);?></td>
                    <td><?php  echo $value["e_diplomat_medal_number"];?></td>
                    <td><?php  echo $value["e_super_medal_number"];?></td>
                    <td><?php  echo $value["e_alipay_number"];?></td>
                    <td><?php  echo $value["e_beneficiary_name"];?></td>
                    <td>
                        <a href="/index.php?r=user/admin/edit&user_id=<?php echo $value["user_id"]?>"  max="true"  target="navTab" title="管理员修改" >
                            <span>修改</span>
                        </a>/
                        <a href="/index.php?r=user/admin/create_invite_show&user_id=<?php echo $value["user_id"]?>&user_name=<?php echo $value["e_user_name"];?>" rel="admin_id_index" target="dialog" title="生成邀请码" >
                            <span>生成邀请码</span>
                        </a>

                    </td>
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
