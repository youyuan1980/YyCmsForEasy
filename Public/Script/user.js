var user = (function () {
    var main_html_id = {
        main_userid : '#main_userid',
        main_username : '#main_username',
        main_userroles : '#main_userroles'
    };
    var user_edit_id = {
        useredit_userid : '#useredit_userid',
        useredit_username : '#useredit_username',
        useredit_rolelist : '#useredit_rolelist'
    };
    var user_list_id = {
        userlist : '#userlist',
        useredit : '#useredit',
        userlist_userid : '#userlist_userid',
        userlist_toolbar : '#userlist_toolbar'
    };
    var user_list_columns = [
        {field: 'userid', title: '用户ID', width: 200},
        {field: 'username', title: '用户姓名', width: 500}
    ];
    //显示用户信息页面
    var main = function (url) {
        $.ajax({
            url:url,
            async:false,
            type:'get',
            dataType:'json',
            success:function(text){
                $(main_html_id.main_userid).html(text.userid);
                $(main_html_id.main_username).html(text.username);
                $(main_html_id.main_userroles).html(text.userrolesname);
            },
            error:function(text){
                alert(text);
            }
        });
    };
    
    var loadeditHtml = function ()
    {
        $(user_list_id.useredit).html('');
        var htmlbase = '<table style="width:460px;font-size:9pt;margin-top: '
        + '10px;margin-left: 10px;" cellspacing="2" border="0" align="left" > '
        + '<tr><td width="15%">用户ID</td><td><input type="text" ' +  'id="useredit_userid" width="300" value="" /></td></tr> '
        +'<tr><td>用户名称</td><td><input type="text" id="useredit_username" '+ 'width="300" value="" /></td></tr><tr><td>权限</td><td><div id="useredit_rolelist"></div> '+'</td></tr></table>';
        $(user_list_id.useredit).html(htmlbase);
    };
    
    var dataBinder = function (url) {   
      var queryParams = {};  Common.loadDataGrid(url,user_list_columns,user_list_id.userlist,user_list_id.userlist_toolbar,queryParams);
    };
    
    var loadadd = function(load_url){
        $.ajax({
            url:load_url,
            async:false,
            dataType:'json',
            type:'get',
            success:function(json){
                $(user_edit_id.useredit_rolelist).html('');
                var rolelisthtml = '';
                $.each(json,function(index,item){
                    rolelisthtml += '<input type=\"checkbox\" name = \"useredit_chkroles\" value=\"'+item.roleid+'\" id=\"useredit_chkroles\"/>'+item.rolename+'</br>';
                });
                $(user_edit_id.useredit_rolelist).html(rolelisthtml);
            },
            error:function(json){
                alert('加载失败');
            }
        });
    };
    
    var loadedit = function(userid,load_url)
    {
        $.ajax({
            url:load_url,
            data:{"userid":userid},
            async:false,
            dataType:'json',
            type:'get',
            success:function(json){
                $(user_edit_id.useredit_userid).attr("value",json.userid);
                $(user_edit_id.useredit_username).attr("value",json.username);
                $(user_edit_id.useredit_rolelist).html('');
                var rolelisthtml = '';
                $.each(json.roles,function(index,item){
                        rolelisthtml += '<input type=\"checkbox\" '+item.ischecked+' name = \"useredit_chkroles\"';
                        rolelisthtml += 'value=\"'+item.roleid+'\" id=\"useredit_chkroles\"/>'+item.rolename+'</br>';
                    });
                $(user_edit_id.useredit_rolelist).html(rolelisthtml);
                $(user_edit_id.useredit_userid).attr("readonly","readonly");
            },
            error:function(json){
                alert('加载失败');
            }
        });
    }
    
    var doaction = function(do_url){
        var userid = $(user_edit_id.useredit_userid).attr("value");
        var username = $(user_edit_id.useredit_username).attr("value");
        if (userid == "" || username == "")
        {
            alert('请输入帐号或用户名');
            return;
        }
        var rolesids = '';
        $("[name = 'useredit_chkroles']").each(function(){
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
            url:do_url,
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
    
    var edit = function(userid,load_url,do_url){
        var title = userid == '' ? '添加用户':'编辑用户';
        loadeditHtml();
        $(user_list_id.useredit).dialog({
                title:title,
                modal:true,
                width:500,
                height:250,
                collapsible:false,
                minimizable:false,
                maximizable:false,
                closable:false,
                onOpen:function(){
                    if(userid == '')
                    {
                       loadadd(load_url);         
                    }
                    else
                    {
                        loadedit(userid,load_url);
                    }
                },
                buttons:[{
                    text:'保存',
                    handler:function(){
                        doaction(do_url);
                        $(user_list_id.useredit).dialog('close');
                        $(user_list_id.userlist).datagrid('reload');
                    }
                },{
                    text:'关闭',
                    handler:function(){
                        $(user_list_id.useredit).dialog('close');
                        $(user_list_id.userlist).datagrid('reload');
                    }
                }]
            });
    };
    
    var delorrest = function (type,url){
        var row = $(user_list_id.userlist).datagrid("getSelected");
        if(row)
        {
            var caption = '';
            if (type == 'del'){
                caption = '您确定删除吗?';
            }
            else
            {
                caption = '您确定重置密码吗?';
            }
            var msg = window.confirm(caption);
            if (msg) {
                $.post(url, {userid: row.userid}, function (data) {
                    alert(data);
                    $(user_list_id.userlist).datagrid('reload');
                });
            }
            else {
                return false;
            }
        }
    };
    
    var doSearch = function (){
        $(user_list_id.userlist).datagrid('load',{
            userlist_userid: $(user_list_id.userlist_userid).attr("value")
        });
    }
    return {main : main,dataBinder:dataBinder,edit : edit,delorrest : delorrest,doSearch:doSearch};
})();
