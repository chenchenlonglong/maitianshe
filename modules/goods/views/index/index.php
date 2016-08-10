<?php
/**
 * author: chenlong
 * Date: 2016/8/1
 * Time: 9:41
 */
use yii\helpers\Url;
?>
<form id="pagerForm" method="post" action="index.php?r=invate/index/index">
    <input type="hidden" name="pageNum" value="<?php isset($data['page'])?$data["page"]:0;?>" />
    <input type="hidden" name="numPerPage" value="<?php echo isset($data['page_num'])?$data['page_num']:50;?>" />
</form>
<div class="pageHeader">
    <form   onsubmit="return navTabSearch(this);" action="index.php?r=goods/index/index" method="post" class="pageForm required-validate">
        <div class="searchBar">
            <table class="searchContent">
                <tr>
                    <td>
                        商品编号：<input type="text" name="goods_id" value="<?php  echo isset($data['goods_id'])?$data['goods_id']:"";?>" />
                    </td>
                    <td><div class="buttonActive"><div class="buttonContent"><button type="submit">查询</button></div></div></td>
                </tr>
            </table>
        </div>
    </form>
</div>

</div>
<div class="pageContent trainListPage">
    <div id="w_list_print">
        <table class="list" width="100%" targetType="navTab" layoutH="62" style="text-align: center">
            <thead style="text-align: center">
            <tr>
                <th width="80">编号</th>
                <th width="100">商品名称</th>
                <th width="125">货号</th>
                <th width="80">价格</th>
                <th width="125">参团人数</th>
                <th width="100">团购价格</th>
                <th width="100">团购销量</th>
                <th width="80">精品</th>
                <th width="80">新品</th>
                <th width="80">热销</th>
                <th width="80">上架</th>
                <th width="80">推荐排序</th>
                <th width="80">库存</th>
                <th width="80">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($data["data"] as $value){?>
                <tr>
                    <td><?php echo $value["goods_id"];?></td>
                    <td><?php echo $value["goods_name"];?></td>
                    <td><?php echo $value["goods_sn"];?></td>
                    <td><?php echo $value["shop_price"];?></td>
                    <td><?php echo $value["team_num"];?></td>
                    <td><?php echo $value["team_price"];?></td>
                    <td><?php echo $value["sales_num"];?></td>
                    <td><?php echo $value["is_best"];?></td>
                    <td><?php echo $value["is_new"];?></td>
                    <td><?php echo $value["is_hot"];?></td>
                    <td><?php echo $value["is_on_sale"];?></td>
                    <td><?php echo $value["sort_order"];?></td>
                    <td><?php echo $value["goods_number"];?></td>
                    <td>
                        <a href="/index.php?r=goods/index/edit&goods_id=<?php echo $value["goods_id"]?>"  max="true"  target="navTab" title="编辑" >编辑</a>
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