<?php if (!defined('THINK_PATH')) exit();?><script type="text/javascript">
    $(document).ready(function () {
       userlist_dataBinder();
    });
    function userlist_dataBinder()
    {
        user.dataBinder("<?php echo U('user/userlistdata');?>");
    }

    var userlist_toolbar = {
        'add':function(){
            user.edit('',"<?php echo U('user/add');?>","<?php echo U('user/adduser');?>");
        },
        'edit':function(){
            var rowdata = $('#userlist').datagrid("getSelected");
            if(rowdata)
            {
                user.edit(rowdata.userid,"<?php echo U('user/edit');?>","<?php echo U('user/edituser');?>");                
            }
        },
        'del':function(){
            var row = $('#userlist').datagrid("getSelected");
            if(row)
            {
                del_user(row.userid);
            }
        },
        'restpassword':function(){
            var row = $('#userlist').datagrid("getSelected");
            if(row)
            {
                restuserpwd(row.userid);
            }
        },
        'doSearch':function(){
            user.doSearch();            
        }
    };

    function del_user(userid) {
        user.delorrest('del',"<?php echo U('user/deleteuser');?>");
    }
    
    function restuserpwd(userid) {
        user.delorrest('rest',"<?php echo U('user/restuserpwd');?>");
    }
</script>
<table id="userlist"></table>
<div id = "userlist_toolbar" style="height:55px;">
    <div>
        <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:userlist_toolbar.add();">添加</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="javascript:userlist_toolbar.edit()">编辑</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:userlist_toolbar.del();">删除</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="javascript:userlist_toolbar.restpassword();">重置密码</a>
    </div>
    <div>
        &nbsp;用户名或用户ID：<input type="text" id = "userlist_userid" />&nbsp;<a href="#" class="easyui-linkbutton" iconCls = "icon-search" plain="true" onclick="javascript:userlist_toolbar.doSearch();" >查询</a>
    </div>
</div>
<div id = "useredit">
</div>