<?php if (!defined('THINK_PATH')) exit();?><script type="text/javascript">
    $(document).ready(function(){
        article.init("<?php echo U('articleclass/datalist');?>",
                         "<?php echo U('articleclass/addarticleclass');?>",
                         "<?php echo U('articleclass/editarticleclass');?>",
                          "<?php echo U('articleclass/delarticleclass');?>",
                    "<?php echo U('article/articlelistdata');?>");
    });
    
     var articlelist_toolbar = {
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
            article.doSearch();            
        }
    };
</script>
<div class="easyui-layout" data-options="fit:true">
    <div data-options="region:'west',split:true,title:'栏目管理'" style="width:250px;padding:0px;">
        <ul id="articleclasslist" class="ztree"></ul>
    </div>
    <div data-options="region:'center',title:'信息管理'">
        <table id="articlelist"></table>
        <div id = "articlelist_toolbar" style="height:55px;">
            <div>
                <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:articlelist_toolbar.add();">添加</a>
                <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="javascript:articlelist_toolbar.edit()">编辑</a>
                <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:articlelist_toolbar.del();">删除</a>
            </div>
            <div>
                &nbsp;标题：<input type="text" id = "articlelist_title" />&nbsp;<a href="#" class="easyui-linkbutton" iconCls = "icon-search" plain="true" onclick="javascript:articlelist_toolbar.doSearch();" >查询</a>
            </div>
        </div>
    </div>
</div>