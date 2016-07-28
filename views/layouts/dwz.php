<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\common\Tools;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language; ?>">
<head>
    <meta charset="<?= Yii::$app->charset; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags(); ?>
    <title>麦田社后台管理系统</title>
    <?php $this->head(); ?>
    <link href="dwz/themes/default/style.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="dwz/themes/css/core.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="dwz/themes/css/print.css" rel="stylesheet" type="text/css" media="print"/>
    <link href="dwz/uploadify/css/uploadify.css" rel="stylesheet" type="text/css" media="screen"/>
    <!--[if IE]>
    <link href="dwz/themes/css/ieHack.css" rel="stylesheet" type="text/css" media="screen"/>
    <![endif]-->

    <!--[if lt IE 9]><script src="dwz/js/speedup.js" type="text/javascript"></script><script src="js/jquery-1.11.3.min.js" type="text/javascript"></script><![endif]-->
    <!--[if gte IE 9]><!--><script src="dwz/js/jquery-2.1.4.min.js" type="text/javascript"></script><!--<![endif]-->

    <script src="dwz/js/jquery.cookie.js" type="text/javascript"></script>
    <script src="dwz/js/jquery.validate.js" type="text/javascript"></script>
    <script src="dwz/js/jquery.bgiframe.js" type="text/javascript"></script>
    <script src="dwz/xheditor/xheditor-1.2.2.min.js" type="text/javascript"></script>
    <script src="dwz/xheditor/xheditor_lang/zh-cn.js" type="text/javascript"></script>
    <script src="dwz/uploadify/scripts/jquery.uploadify.js" type="text/javascript"></script>

    <!-- svg图表  supports Firefox 3.0+, Safari 3.0+, Chrome 5.0+, Opera 9.5+ and Internet Explorer 6.0+ -->
    <script type="text/javascript" src="dwz/chart/raphael.js"></script>
    <script type="text/javascript" src="dwz/chart/g.raphael.js"></script>
    <script type="text/javascript" src="dwz/chart/g.bar.js"></script>
    <script type="text/javascript" src="dwz/chart/g.line.js"></script>
    <script type="text/javascript" src="dwz/chart/g.pie.js"></script>
    <script type="text/javascript" src="dwz/chart/g.dot.js"></script>

    <script src="dwz/js/dwz.core.js" type="text/javascript"></script>
    <script src="dwz/js/dwz.util.date.js" type="text/javascript"></script>
    <script src="dwz/js/dwz.validate.method.js" type="text/javascript"></script>
    <script src="dwz/js/dwz.barDrag.js" type="text/javascript"></script>
    <script src="dwz/js/dwz.drag.js" type="text/javascript"></script>
    <script src="dwz/js/dwz.tree.js" type="text/javascript"></script>
    <script src="dwz/js/dwz.accordion.js" type="text/javascript"></script>
    <script src="dwz/js/dwz.ui.js" type="text/javascript"></script>
    <script src="dwz/js/dwz.theme.js" type="text/javascript"></script>
    <script src="dwz/js/dwz.switchEnv.js" type="text/javascript"></script>
    <script src="dwz/js/dwz.alertMsg.js" type="text/javascript"></script>
    <script src="dwz/js/dwz.contextmenu.js" type="text/javascript"></script>
    <script src="dwz/js/dwz.navTab.js" type="text/javascript"></script>
    <script src="dwz/js/dwz.tab.js" type="text/javascript"></script>
    <script src="dwz/js/dwz.resize.js" type="text/javascript"></script>
    <script src="dwz/js/dwz.dialog.js" type="text/javascript"></script>
    <script src="dwz/js/dwz.dialogDrag.js" type="text/javascript"></script>
    <script src="dwz/js/dwz.sortDrag.js" type="text/javascript"></script>
    <script src="dwz/js/dwz.cssTable.js" type="text/javascript"></script>
    <script src="dwz/js/dwz.stable.js" type="text/javascript"></script>
    <script src="dwz/js/dwz.taskBar.js" type="text/javascript"></script>
    <script src="dwz/js/dwz.ajax.js" type="text/javascript"></script>
    <script src="dwz/js/dwz.pagination.js" type="text/javascript"></script>
    <script src="dwz/js/dwz.database.js" type="text/javascript"></script>
    <script src="dwz/js/dwz.datepicker.js" type="text/javascript"></script>
    <script src="dwz/js/dwz.effects.js" type="text/javascript"></script>
    <script src="dwz/js/dwz.panel.js" type="text/javascript"></script>
    <script src="dwz/js/dwz.checkbox.js" type="text/javascript"></script>
    <script src="dwz/js/dwz.history.js" type="text/javascript"></script>
    <script src="dwz/js/dwz.combox.js" type="text/javascript"></script>
    <script src="dwz/js/dwz.print.js" type="text/javascript"></script>

    <!-- 可以用dwz.min.js替换前面全部dwz.*.js (注意：替换时下面dwz.regional.zh.js还需要引入)
    <script src="bin/dwz.min.js" type="text/javascript"></script>
    -->
    <script src="dwz/js/dwz.regional.zh.js" type="text/javascript"></script>

    <script type="text/javascript">
    $(function(){
        DWZ.init("dwz/js/dwz.frag.xml", {
            loginUrl:"login_dialog.html", loginTitle:"登录",  // 弹出登录对话框
    //      loginUrl:"login.html",  // 跳到登录页面
            statusCode:{ok:200, error:300, timeout:301}, //【可选】
            pageInfo:{pageNum:"pageNum", numPerPage:"numPerPage", orderField:"orderField", orderDirection:"orderDirection"}, //【可选】
            keys: {statusCode:"statusCode", message:"message"}, //【可选】
            ui:{hideMode:'offsets'}, //【可选】hideMode:navTab组件切换的隐藏方式，支持的值有’display’，’offsets’负数偏移位置的值，默认值为’display’
            debug:false,    // 调试模式 【true|false】
            callback:function(){
                initEnv();
                $("#themeList").theme({themeBase:"themes"}); // themeBase 相对于index页面的主题base路径
            }
        });
    });
    </script>
</head>
<body>
<?php #$this->beginBody(); ?>

<div id="layout">
        <div id="header">
            <div class="headerNav">
                <ul class="nav">
                        <li style="background: none;"><a>欢迎:
                                <?php  echo Tools::get_user_name();?>
                                 使用本系统</a></li>
                    <li><a href="index.php?r=admin/login/login_out">退出</a></li>
                </ul>
            </div>

            <!-- navMenu -->
            
        </div>

        <div id="leftside">
            <div id="sidebar_s">
                <div class="collapse">
                    <div class="toggleCollapse"><div></div></div>
                </div>
            </div>
            <div id="sidebar">
                <div class="toggleCollapse"><h2>主菜单</h2><div>收缩</div></div>

                <div class="accordion" fillSpace="sidebar">
				<?php echo \app\components\MenuWidget::widget();?>
                </div>

            </div>
        </div>
        <div id="container">
            <div id="navTab" class="tabsPage">
                <div class="tabsPageHeader">
                    <div class="tabsPageHeaderContent"><!-- 显示左右控制时添加 class="tabsPageHeaderMargin" -->
                        <ul class="navTab-tab">
                            <li tabid="main" class="main"><a href="javascript:;"><span><span class="home_icon">我的主页</span></span></a></li>
                        </ul>
                    </div>
                    <div class="tabsLeft">left</div><!-- 禁用只需要添加一个样式 class="tabsLeft tabsLeftDisabled" -->
                    <div class="tabsRight">right</div><!-- 禁用只需要添加一个样式 class="tabsRight tabsRightDisabled" -->
                    <div class="tabsMore">more</div>
                </div>
                <ul class="tabsMoreList">
                    <li><a href="javascript:;">我的主页</a></li>
                </ul>
                <div class="navTab-panel tabsPageContent layoutBox">
                    <div class="page unitBox">
                        <div class="accountInfo">
                            <div class="right">
                                <p style="color:red">官方网站 <a href="" target="_blank"></a></p>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
        </div>        
    <div id="footer">Copyright &copy; 2016 <a href="demo_page2.html" target="dialog">chenlong - 2016-07-20</div>

<?php #$this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
