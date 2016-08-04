<?php
/**
 * author: chenlong
 * Date: 2016/7/26
 * Time: 9:32
 */
?>
<form id="pagerForm" method="post" action="index.php?r=task/index/index">
    <input type="hidden" name="pageNum" value="<?php isset($data['page'])?$data["page"]:0;?>" />
    <input type="hidden" name="numPerPage" value="<?php echo isset($data['page_num'])?$data['page_num']:30;?>" />
</form>
<div class="pageHeader">
    <div class="panelBar">
        <ul class="toolBar">
                <li><a class="add" href="index.php?r=task/index/add" target="dialog" rel="assignment_id_create"><span>添加任务</span></a></li>
        </ul>
    </div>
</div>
<div class="pageContent trainListPage">
    <div id="w_list_print">
        <table class="list" width="100%" targetType="navTab" layoutH="88" style="text-align: center">
            <thead style="text-align: center">
            <tr>
                <th width="80">序号</th>
                <th width="125">任务等级</th>
                <th width="80">任务名称</th>
                <th width="80">任务描述</th>
                <th width="80">拼团描述</th>
                <th width="80">操作</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach($data["data"] as $value){?>
                    <tr>
                        <td><?php  echo $value["id"];?></td>
                        <td><?php  echo $value["task_level"];?></td>
                        <td><?php  echo $value["task_name"];?></td>
                        <td><?php  echo $value["commission_describe"];?></td>
                        <td><?php  echo $value["team_describe"];?></td>
                        <td>
                           <a  href="/index.php?r=task/index/edit&id=<?php echo $value["id"]?>"  target="dialog" rel="index_id_index_edit" title="任务编辑" >
                               <span>编辑</span></a>/
                           <a href="/index.php?r=task/index/delete&id=<?php echo $value["id"]?>"  class="del" target="ajaxTodo"    title="确定删除？">
                            <span>删除</span>
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

