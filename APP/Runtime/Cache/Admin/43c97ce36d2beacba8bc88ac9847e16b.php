<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE>
<script type="text/javascript">
    var articleclasslist_setting = {
        data: {
            simpleData: {
                enable: true
            }
        },
        callback: {
            onClick: zTreeOnClick_articleclass
        }
    };
    $(function(){
        dataBinder();
    });

    function zTreeOnClick_articleclass(event, treeId, treeNode)
    {
        alert(treeNode.pId);
        alert(treeNode.id);
        alert(treeNode.name);
    }

    function dataBinder()
    {
        $.ajax({
            url:"<?php echo U('articleclass/datalist');?>",
            async:false,
            dataType:'json',
            type:'get',
            success:function(json){
                $.fn.zTree.init($("#articleclasslist"), articleclasslist_setting, json);
            },
            error:function(json){
                alert('加载失败');
            }
        });
    }

</script>
<div id = "toolbar1" style="height:65px;">
    <div>
        <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:alert('Add')">添加</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="aticleclasslist_edit()">编辑</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:alert('Save')">删除</a>
    </div>
    <div><ul id="articleclasslist" class="ztree"></ul></div>
    <div id="aticleclasslist_edit_dialog"></div>
    <div id="bb" style="display: none;">
        <a href="#" class="easyui-linkbutton" onclick="articleclass_save();">保存</a>
        <a href="#" class="easyui-linkbutton" onclick="dialog_close();">关闭</a>
    </div>
</div>
</div>