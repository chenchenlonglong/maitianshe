<?php
/**
 * author: chenlong
 * Date: 2016/8/1
 * Time: 9:41
 */
use yii\helpers\Url;
?>
<form id="pagerForm" method="post" action="index.php?r=goods/index/index">
    <input type="hidden" name="pageNum" value="<?php isset($data['page'])?$data["page"]:0;?>" />
    <input type="hidden" name="numPerPage" value="<?php echo isset($data['page_num'])?$data['page_num']:30;?>" />
</form>
<div class="pageHeader">
    <form   onsubmit="return navTabSearch(this);" action="index.php?r=goods/index/index" method="post" class="pageForm required-validate">
        <div class="searchBar">
            <table class="searchContent">
                <tr>
                    <td>
                        商品货号：<input type="text" name="goods_sn" value="<?php  echo isset($data['goods_sn'])?$data['goods_sn']:"";?>" />
                    </td>

                    <td>
                        任务组:
                        <select name="task_level">
                            <option value="" <?php if($data["task_level"]===""){echo "selected='selected'";}?>>请选择</option>
                            <option value="0" <?php if($data["task_level"]==="0"){echo "selected='selected'";}?>>无任务组</option>
                            <?php foreach($task as $key=>$value){
                                ?>
                                <option value="<?php echo $value["task_level"]?>" <?php if($data["task_level"]==$value["task_level"]){echo "selected='selected'";}?>><?php echo $value["task_name"]?></option>
                            <?php
                            }?>
                        </select>
                    </td>
                    <td>
                        参团人数：<input type="text"  style="width: 60px;" name="team_num" value="<?php  echo isset($data['team_num'])?$data['team_num']:"";?>" />
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
                <th width="80">编号</th>
                <th width="100">商品名称</th>
                <th width="125">货号</th>
                <th width="125">麦田商品货号</th>
                <th width="80">价格</th>
                <th width="80">参团人数</th>
                <th width="125">任务组</th>
                <th width="100">团购价格</th>
                <th width="100">团购销量</th>
                <th width="80">精品</th>
                <th width="80">新品</th>
                <th width="80">热销</th>
                <th width="80">上架</th>
                <th width="80">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($data["data"] as $value){?>
                <tr>
                    <td><?php echo $value["goods_id"];?></td>
                    <td><?php echo $value["goods_name"];?></td>
                    <td><?php echo $value["goods_sn"];?></td>
                    <td><?php echo $value["maitian_goods_sn"];?></td>
                    <td><?php echo $value["shop_price"];?></td>
                    <td><?php echo $value["team_num"];?></td>
                    <td><?php  if(!empty($value["task_level"])){ echo $task[$value["task_level"]-1]["task_name"]; }else{ echo "";} ;?></td>
                    <td><?php echo $value["team_price"];?></td>
                    <td><?php echo $value["sales_num"];?></td>
                    <td><?php echo empty($value["is_best"])?"-":"是";?></td>
                    <td><?php echo empty($value["is_new"])?"-":"是";?></td>
                    <td><?php echo empty($value["is_hot"])?"-":"是";;?></td>
                    <td><?php echo empty($value["is_on_sale"])?"-":"是";;?></td>
                    <td>
                        <a href="/index.php?r=goods/index/edit&goods_id=<?php echo $value["goods_id"]?>"  max="true"  target="navTab" title="编辑" >编辑</a>/
                        <a href="/index.php?r=goods/index/pull&goods_id=<?php echo $value["goods_id"]?>" class="del" target="ajaxTodo"  title="确认置顶？" >置顶</a>
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