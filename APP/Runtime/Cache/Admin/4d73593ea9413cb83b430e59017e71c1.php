<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <script type="text/javascript" src="/yycmsforeasy/Public/jqueryeasyui/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="/yycmsforeasy/Public/jqueryeasyui/jquery.easyui.min.js"></script>
    <link rel="stylesheet" href="/yycmsforeasy/Public/zTree/css/zTreeStyle/zTreeStyle.css" type="text/css">
    <script type="text/javascript" src="/yycmsforeasy/Public/zTree/js/jquery.ztree.core-3.5.js"></script>
    <link rel="stylesheet" type="text/css" href="/yycmsforeasy/Public/jqueryeasyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="/yycmsforeasy/Public/jqueryeasyui/themes/icon.css">
    <script type="text/javascript">
        var setting = {
            data: {
                simpleData: {
                    enable: true
                }
            },
            callback: {
                onClick: zTreeOnClick
            }
        };

        $(document).ready(function () {
            $.fn.zTree.init($("#treeDemo"), setting, zNodes);
        });
        var zNodes = <?php echo ($json); ?>;
        function zTreeOnClick(event, treeId, treeNode) {
            Open(treeNode.name, treeNode.myurl);
        }
        ;
        function Open(text, url) {
            if ($("#tabs").tabs('exists', text)) {
                $('#tabs').tabs('select', text);
                refreshTab({tabTitle: text, url: url});
            } else {
                if (url) {
                    $("#tabs").tabs('add', {
                        title: text,
                        closable: true,
                        href: url
                    });
                }
            }
        }

        function refreshTab(cfg) {
            var refresh_tab = cfg.tabTitle ? $('#tabs').tabs('getTab', cfg.tabTitle) : $('#tabs').tabs('getSelected');
            if (refresh_tab && refresh_tab.find('iframe').length > 0) {
                var _refresh_ifram = refresh_tab.find('iframe')[0];
                var refresh_url = cfg.url ? cfg.url : _refresh_ifram.src;
                //_refresh_ifram.src = refresh_url;
                _refresh_ifram.contentWindow.location.href = refresh_url;
            }
        }
    </script>
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
        <div class="easyui-tabs" fit="true" border="false" id="tabs">
            <div data-options="closable:true" title="用户基本信息" style="overflow:hidden">
                <iframe scrolling="yes" frameborder="0" src="<?php echo U('user/main');?>"
                        style="width:100%;height:100%;"></iframe>
            </div>
        </div>
    </div>
</form>
</body>
</html>