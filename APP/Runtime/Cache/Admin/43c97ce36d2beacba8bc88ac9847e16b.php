<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE>
<script type="text/javascript">
    $(function () {
        $('#articleclasslist').datagrid({
            url: '<?php echo U('articleclass/ArticleClassListForSearch');?>',
            fit:true,
            height: 'auto',
            fitColumns: true,
            singleSelect: true,
            pageSize: 10,
            pageList: [10],
            pagination: true,
            columns: [[
                {field: 'id', title: '栏目ID', width: 200},
                {field: 'title', title: '栏目名称', width: 500}
            ]],
            toolbar:"#toolbar1"
        });
    });

    function doSearch()
    {
         $('#articleclasslist').datagrid('load',{
             title: $('#title').attr("value")
         });
    }

    function jumpchild()
    {
        var row = $('#articleclasslist').datagrid('getSelected');
        if (row){
            var url = "<?php echo U('articleclass/articleclasslist',array('pid'=>'class_id'));?>";
            url = url.replace('class_id',row.id);
            alert(url);
            Open('栏目列表',url);
        }
    }

    // function del_user(userid) {
    //     var msg = window.confirm("您确定删除吗?");
    //     if (msg) {
    //         var url = '<?php echo U('user / deleteuser');?>';
    //         $.post(url, {userid: userid}, function (data) {
    //             alert(data.info);
    //             $('#userlist').datagrid('reload');
    //         });
    //     }
    //     else {
    //         return false;
    //     }
    // }
    // function restuserpwd(userid) {
    //     var msg = window.confirm("您确定重置密码吗?");
    //     if (msg) {
    //         var url = '<?php echo U('
    //         user / restuserpwd
    //         ');?>';
    //         var tbuserid = $("#TbUserID").attr("value");
    //         $.post(url, {userid: userid}, function (data) {
    //             alert(data.info);
    //             $('#userlist').datagrid('reload');
    //         });
    //     }
    //     else {
    //         return false;
    //     }
    // }
</script>
<table id="articleclasslist"></table>
<div id = "toolbar1" style="height:65px;">
    <div>
        <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:alert('Add')">添加</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="javascript:alert('Cut')">编辑</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:alert('Save')">删除</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:jumpchild()">项目管理</a>
    </div>
    <div>
        &nbsp;<?php echo ($articleclassherf); ?><br>
        &nbsp;栏目名称：<input type="text" id = "title" />&nbsp;<a href="#" class="easyui-linkbutton" iconCls = "icon-search" plain="true" onclick="javascript:doSearch();" >查询</a>
    </div>
</div>