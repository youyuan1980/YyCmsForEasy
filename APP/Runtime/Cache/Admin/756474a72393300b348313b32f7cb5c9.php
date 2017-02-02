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
            $('#userlist_add').dialog({
                title:'添加用户',
                modal:true,
                width:500,
                height:250,
                collapsible:false,
                minimizable:false,
                maximizable:false,
                closable:false,
                onOpen:function(){
                    $.ajax({
                        url:"<?php echo U('user/add');?>",
                        async:false,
                        dataType:'json',
                        type:'get',
                        success:function(json){
                            $("#userlist_add_rolelist").html('');
                            var rolelisthtml = '';
                            $.each(json,function(index,item){
                                rolelisthtml += '<input type=\"checkbox\" name = \"userlist_add_chkroles\" value=\"'+item.roleid+'\" id=\"userlist_add_chkroles\"/>'+item.rolename+'</br>';
                            });
                            $("#userlist_add_rolelist").html(rolelisthtml);
                        },
                        error:function(json){
                            alert('加载失败');
                        }
                    });
                },
                buttons:[{
                    text:'保存',
                    handler:function(){
                        var userid = $('#userlist_add_userid').attr("value");
                        var username = $('#userlist_add_username').attr("value");
                        if (userid == "" || username == "")
                        {
                            alert('请输入帐号或用户名');
                            return;
                        }
                        var rolesids = '';
                        $("[name = 'userlist_add_chkroles']").each(function(){
                            if($(this).attr("checked")=="checked")
                            {
                                if(rolesids != "")
                                {
                                    rolesids += ","
                                }
                                rolesids += $(this).attr("value");
                            }
                        });
                        $.ajax({
                            url:"<?php echo U('user/adduser');?>",
                            data:{"userid":userid,"username":username,"roles":rolesids},
                            async:false,
                            dataType:'json',
                            type:'post',
                            success:function(json){
                                alert(json);
                            },
                            error:function(json){
                                alert('保存失败');
                            }
                        });
                    }
                },{
                    text:'关闭',
                    handler:function(){
                        $('#userlist_add').dialog('close');
                        $('#userlist').datagrid('reload');
                    }
                }]
            });
        },
        'edit':function(){
            var rowdata = $('#userlist').datagrid("getSelected");
            if(rowdata)
            {
                $('#userlist_edit').dialog({
                    title:'编辑用户',
                    modal:true,
                    width:500,
                    height:250,
                    collapsible:false,
                    minimizable:false,
                    maximizable:false,
                    closable:false,
                    onOpen:function(){
                        $.ajax({
                            url:"<?php echo U('user/edit');?>",
                            data:{"userid":rowdata.userid},
                            async:false,
                            dataType:'json',
                            type:'get',
                            success:function(json){
                                $("#userlist_edit_userid").attr("value",json.userid);
                                $("#userlist_edit_username").attr("value",json.username);
                                $("#userlist_edit_rolelist").html('');
                                var rolelisthtml = '';
                                $.each(json.roles,function(index,item){
                                    rolelisthtml += '<input type=\"checkbox\" '+item.ischecked+' name = \"userlist_edit_chkroles\"';
                                    rolelisthtml += 'value=\"'+item.roleid+'\" id=\"userlist_edit_chkroles\"/>'+item.rolename+'</br>';
                                });
                                $("#userlist_edit_rolelist").html(rolelisthtml);
                            },
                            error:function(json){
                                alert('加载失败');
                            }
                        });
                    },
                    buttons:[{
                        text:'保存',
                        handler:function(){
                            var userid = $('#userlist_edit_userid').attr("value");
                            var username = $('#userlist_edit_username').attr("value");
                            if (userid == "" || username == "")
                            {
                                alert('请输入帐号或用户名');
                                return;
                            }
                            var rolesids = '';
                            $("[name = 'userlist_edit_chkroles']").each(function(){
                                if($(this).attr("checked")=="checked")
                                {
                                    if(rolesids != "")
                                    {
                                        rolesids += ","
                                    }
                                    rolesids += $(this).attr("value");
                                }
                            });
                            $.ajax({
                                url:"<?php echo U('user/edituser');?>",
                                data:{"userid":userid,"username":username,"roles":rolesids},
                                async:false,
                                dataType:'json',
                                type:'post',
                                success:function(json){
                                    alert(json);
                                },
                                error:function(json){
                                    alert('保存失败');
                                }
                            });
                        }
                    },{
                        text:'关闭',
                        handler:function(){
                            $('#userlist_edit').dialog('close');
                            $('#userlist').datagrid('reload');
                        }
                    }]
                });
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
            $('#userlist').datagrid('load',{
                userlist_userid: $('#userlist_userid').attr("value")
            });
        }
    };

    function del_user(userid) {
        var msg = window.confirm("您确定删除吗?");
        if (msg) {
            var url = "<?php echo U('user/deleteuser');?>";
            $.post(url, {userid: userid}, function (data) {
                alert(data);
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
            var url = "<?php echo U('user/restuserpwd');?>";
            $.post(url, {userid: userid}, function (data) {
                alert(data);
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
        <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:userlist_toolbar.add();">添加</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="javascript:userlist_toolbar.edit()">编辑</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:userlist_toolbar.del();">删除</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="javascript:userlist_toolbar.restpassword();">重置密码</a>
    </div>
    <div>
        &nbsp;用户名或用户ID：<input type="text" id = "userlist_userid" />&nbsp;<a href="#" class="easyui-linkbutton" iconCls = "icon-search" plain="true" onclick="javascript:userlist_toolbar.doSearch();" >查询</a>
    </div>
</div>

<div id = "userlist_add">
    <table style="width:460px;font-size:9pt;margin-top: 10px;margin-left: 10px;" cellspacing="2" border="0" align="left" >
        <tr>
            <td width="15%">用户ID</td>
            <td>
                <input type="text" id="userlist_add_userid" width="300" value='' />
            </td>
        </tr>
        <tr>
            <td>用户名称</td>
            <td>
                <input type="text" id="userlist_add_username" width="300" value='' />
            </td>
        </tr>
        <tr>
            <td>权限</td>
            <td>
                <div id="userlist_add_rolelist"></div>
            </td>
        </tr>
    </table>
</div>
<div id = "userlist_edit">
    <table style="width:460px;font-size:9pt;margin-top: 10px;margin-left: 10px;" cellspacing="2" border="0" align="left" >
        <tr>
            <td width="15%">用户ID</td>
            <td>
                <input type="text" id="userlist_edit_userid" width="300" value='' />
            </td>
        </tr>
        <tr>
            <td>用户名称</td>
            <td>
                <input type="text" id="userlist_edit_username" width="300" value='' />
            </td>
        </tr>
        <tr>
            <td>权限</td>
            <td>
                <div id="userlist_edit_rolelist"></div>
            </td>
        </tr>
    </table>
</div>