<?php
/**
 * @author oj
 * @data : 2016/3/30
 * @time: 18:40
 */
foreach ($menus as $parent_menu => $menu) {

    ?>
    <div class="accordionHeader">
        <h2><span>Folder</span><?php echo $parent_menu ?></h2>
    </div>
    <div class="accordionContent">
        <ul class="tree treeFolder">

            <?php if(!empty($menu)){?>
                <?php foreach ($menu as $v) { ?>
                    <li><a href="<?php echo "index.php?r=" . $v['url']; ?>" target="navTab" rel="<?php echo $v['rel'] . "_id_index"; ?>"><?php echo $v['name']; ?></a></li>
                <?php } ?>
            <?php }?>

        </ul>
    </div>

<?php } ?>