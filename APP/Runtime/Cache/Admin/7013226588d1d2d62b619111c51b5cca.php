<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE>
<html>
<head>
    <title></title>
    <meta charset="utf-8"/>
    <script type="text/javascript" src="/yycmsforeasy/Public/jqueryeasyui/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="/yycmsforeasy/Public/jqueryeasyui/jquery.easyui.min.js"></script>
    <link rel="stylesheet" href="/yycmsforeasy/Public/zTree/css/zTreeStyle/zTreeStyle.css" type="text/css">
    <script type="text/javascript" src="/yycmsforeasy/Public/zTree/js/jquery.ztree.core-3.5.js"></script>
    <link rel="stylesheet" type="text/css" href="/yycmsforeasy/Public/jqueryeasyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="/yycmsforeasy/Public/jqueryeasyui/themes/icon.css">
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        $("#login").window({
            title:'登陆',
            width:500,
            height:250,
            collapsible:false,
            minimizable:false,
            maximizable:false,
            closable:false
        });
        $("#form1").form({
            url:"<?php echo U('login/dologin');?>",
            onSubmit:function(){
                return $(this).form('validate');
            },
            success:function(data){
                var dataObj = eval("("+data+")");
                alert(dataObj.msg);
                location.href = dataObj.url;
            }
        });
    });

    </script>
</head>
<body>
<div id="login">
    <form method="post" id="form1" >
        <div style="margin-top:50px;text-align:left;">
            <div style="margin-left:120px;">
                <label for="name">用户名：</label>
                <input type="text" name="txt_userid" class="easyui-validatebox" data-options="required:true" />
            </div>
            <div style="margin-top:20px;margin-left:120px;">
                <label for="password">密码：</label><span style="margin-left:12px;"></span>
                <input type="password" name="txt_pwd" class="easyui-validatebox" data-options="required:true" />
            </div>
            <div style="margin-top:20px;text-align:center">
                <input type="submit" value="登陆"/>&nbsp;&nbsp;<input type="reset" value="重置" />
            </div>
        </div>
    </form>
</div>
</body>
</html>