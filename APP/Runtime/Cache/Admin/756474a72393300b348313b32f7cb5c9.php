<?php if (!defined('THINK_PATH')) exit();?><script type="text/javascript">
    $(function () {
        userlist_dataBinder();
    });
    
    function userlist_dataBinder()
    {
        $('#userlist').datagrid({
            url: '<?php echo U('user/UserListForSearch');?>',
            fit:true,
            height: 'auto',
            fitColumns: true,
            singleSelect: true,
            pageSize: 10,
            pageList: [10],
            pagination: true,
            columns: [[
                {field: 'userid', title: '用户ID', width: 200},
                {field: 'username', title: '用户姓名', width: 500}
            ]],
            toolbar:"#userlist_toolbar"
        });
    }
    
    var userlist_toolbar = {
        'add':function(){alert('adfasfdf');},
        'edit':function(){alert('adfasdfsfsdfs');},
        'del':function(){},
        'restpassword':function(){},
        'doSearch':function(){
            $('#userlist').datagrid('load',{
                userlist_userid: $('#userlist_userid').attr("value")
            });
        }
    };


    function del_user(userid) {
        var msg = window.confirm("您确定删除吗?");
        if (msg) {
            var url = '<?php echo U('user / deleteuser');?>';
            $.post(url, {userid: userid}, function (data) {
                alert(data.info);
                $('#userlist').datagrid('reload');
            });
        }
        else {
            return false;
        }
    }
    function restuserpwd(userid) {
        var msg = window.confirm("您确定重置密码吗?");
        if (msg) {
            var url = '<?php echo U('user / restuserpwd ');?>';
            $.post(url, {userid: userid}, function (data) {
                alert(data.info);
                $('#userlist').datagrid('reload');
            });
        }
        else {
            return false;
        }
    }
</script>
<table id="userlist"></table>
<div id = "userlist_toolbar" style="height:55px;">
    <div>
        <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:alert('Add')">添加</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="javascript:alert('Cut')">编辑</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:alert('Save')">删除</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="javascript:alert('Save')">重置密码</a>
    </div>
    <div>
        &nbsp;用户名或用户ID：<input type="text" id = "userlist_userid" />&nbsp;<a href="#" class="easyui-linkbutton" iconCls = "icon-search" plain="true" onclick="javascript:userlist_toolbar.doSearch();" >查询</a>
    </div>
</div>