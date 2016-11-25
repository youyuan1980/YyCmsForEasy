<?php if (!defined('THINK_PATH')) exit();?><script type="text/javascript">
    $(function () {
        $('#userlist').datagrid({
            url: '<?php echo U('user/UserListForEasy');?>',
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
            toolbar: [{
                text: '添加',
                iconCls: 'icon-add',
                handler: function () {
                    $('#userlist').datagrid('endEdit', lastIndex);
                    $('#userlist').datagrid('appendRow', {
                        itemid: '',
                        productid: '',
                        listprice: '',
                        unitprice: '',
                        attr1: '',
                        status: 'P'
                    });
                    lastIndex = $('#userlist').datagrid('getRows').length - 1;
                    $('#userlist').datagrid('selectRow', lastIndex);
                    $('#userlist').datagrid('beginEdit', lastIndex);
                }
            }, '-', {
                text: '编辑',
                iconCls: 'icon-edit',
                handler: function () {
                    var row = $('#userlist').datagrid('getSelected');
                    if (row) {
                        alert(row.userid);
                    }
                }
            }, '-', {
                text: '删除',
                iconCls: 'icon-remove',
                handler: function () {
                    var row = $('#userlist').datagrid('getSelected');
                    if (row) {
                        var userid = row.userid;
                        del_user(userid);
                    }
                }
            }, '-', {
                text: '查询',
                iconCls: 'icon-search',
                handler: function () {
                    var rows = $('#userlist').datagrid('getChanges');
                    alert('changed rows: ' + rows.length + ' lines');
                }
            }]
        });
    });


    function del_user(userid) {
        var msg = window.confirm("您确定删除吗?");
        if (msg) {
            var url = '<?php echo U('
            user / deleteuser
            ');?>';
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
            var url = '<?php echo U('
            user / restuserpwd
            ');?>';
            var tbuserid = $("#TbUserID").attr("value");
            $.post(url, {userid: userid}, function (data) {
                alert(data.info);
                $('#userlist').datagrid('reload');
            });
        }
        else {
            return false;
        }
    }
    false
</script>
<table id="userlist"></table>