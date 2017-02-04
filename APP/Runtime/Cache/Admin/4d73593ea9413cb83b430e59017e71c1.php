<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
    <meta charset="utf-8">
    <title></title>
    <script type="text/javascript" src="/yycmsforeasy/Public/jqueryeasyui/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="/yycmsforeasy/Public/jqueryeasyui/jquery.easyui.min.js"></script>
    <link rel="stylesheet" href="/yycmsforeasy/Public/zTree/css/zTreeStyle/zTreeStyle.css" type="text/css">
    <script type="text/javascript" src="/yycmsforeasy/Public/zTree/js/jquery.ztree.core-3.5.js"></script>
    <script type="text/javascript" src="/yycmsforeasy/Public/zTree/js/jquery.ztree.excheck.js"></script>
    <script type="text/javascript" src="/yycmsforeasy/Public/zTree/js/jquery.ztree.exedit.js"></script>
    <link rel="stylesheet" type="text/css" href="/yycmsforeasy/Public/jqueryeasyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="/yycmsforeasy/Public/jqueryeasyui/themes/icon.css">
    <script type="text/javascript" src="/yycmsforeasy/Public/Script/Common.js"></script>
    <script type="text/javascript" src="/yycmsforeasy/Public/Script/user.js"></script>
    <script type="text/javascript" src="/yycmsforeasy/Public/Script/index.js"></script>
    <script type="text/javascript" src="/yycmsforeasy/Public/Script/article.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            index.init("<?php echo U('index/lefttree');?>");
        });
    </script>
    <style type="text/css">
        .ztree li span.button.add {margin-left:2px; margin-right: -1px; background-position:-144px 0; vertical-align:top; *vertical-align:middle}
	</style>

</head>
<body class="easyui-layout">
<form id="form1">
    <div data-options="region:'north',border:false" style="height:40px;">
        <img src="/yycmsforeasy/Public/images/top-l.jpg" align="left" width='85%' height='200'/>
        <?php echo ($username); ?>&nbsp;<a href="<?php echo U('login/logout');?>">退出系统</a><span
            style="margin-right: 30px;"></span>
    </div>
    <div data-options="region:'west',split:true,title:'功能菜单'" style="width:200px;padding:0px;">
        <ul id="treeDemo" class="ztree">
    </div>
    <div data-options="region:'south',border:false" style="height:50px;padding:15px;text-align: center;">版权所有： © 2015
        水云间工作室 CopyRight All Rights Reserved. 技术支持：水云间工作室
    </div>
    <div data-options="region:'center',title:'工作区'">
        <div id="p" class="easyui-panel" title="用户基本信息" data-options="fit:true,href:'<?php echo U('user/main');?>'"></div>
    </div>
</form>
</body>
</html>