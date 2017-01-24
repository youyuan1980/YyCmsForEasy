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
        $("#classid").attr("value",treeNode.id);
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

    var articleclasslist_toolBar = {
        'edit':function(){
            var classid = $("#classid").attr("value");
            if(classid == "-1")
            {
                alert('请选择需要编辑的栏目');
                return;
            }
            $('#articleclasslist_edit').show();
            $("#articleclasslist_edit_title").attr("value","");
            $('#articleclasslist_edit').dialog({
                title:'编辑栏目',
                modal:true,
                width:500,
                height:150,
                collapsible:false,
                minimizable:false,
                maximizable:false,
                closable:false,
                onOpen:function(){
                    $.ajax({
                        url:"<?php echo U('articleclass/getarticleclassinfo');?>",
                        async:false,
                        dataType:'json',
                        data:{"classid":classid},
                        type:'get',
                        success:function(json){
                            $("#articleclasslist_edit_title").attr("value",json.title);
                        },
                        error:function(json){
                            alert('加载失败');
                        }
                    });
                },
                buttons:[{
                    text:'保存',
                    handler:function(){
                        var classid = $("#classid").attr("value");
                        var title = $("#articleclasslist_edit_title").attr("value");
                        $.ajax({
                            url:"<?php echo U('articleclass/editarticleclass');?>",
                            data:{"classid":classid,"title":title},
                            async:false,
                            dataType:'json',
                            type:'get',
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
                        $('#articleclasslist_edit').dialog('close');
                        dataBinder();
                    }
                }]
            });
        },
        'add':function(){
            var classid = $("#classid").attr("value");
            $('#articleclasslist_add').show();
            $("#articleclasslist_add_title").attr("value","");
            $('#articleclasslist_add').dialog({
                title:'添加栏目',
                modal:true,
                width:500,
                height:150,
                collapsible:false,
                minimizable:false,
                maximizable:false,
                closable:false,
                onOpen:function(){

                },
                buttons:[{
                    text:'保存',
                    handler:function(){
                        var classid = $("#classid").attr("value");
                        var title = $("#articleclasslist_add_title").attr("value");
                        $.ajax({
                            url:"<?php echo U('articleclass/addarticleclass');?>",
                            data:{"pid":classid,"title":title},
                            async:false,
                            dataType:'json',
                            type:'get',
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
                        $('#articleclasslist_add').dialog('close');
                        dataBinder();
                    }
                }]
            });
        },
        'del':function(){
            var classid = $("#classid").attr("value");;
            if(classid == "-1")
            {
                alert('请选择需要删除的栏目');
                return;
            }
            $.ajax({
                url:"<?php echo U('articleclass/delarticleclass');?>",
                async:false,
                dataType:'json',
                data:{"classid":classid},
                type:'get',
                success:function(text){
                    alert(text);
                    dataBinder();
                },
                error:function(text){
                    alert('删除失败');
                }
            });
        }
    };

</script>
<div id = "toolbar1" style="height:65px;">
    <div>
        <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:articleclasslist_toolBar.add()">添加</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="javascript:articleclasslist_toolBar.edit()">编辑</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:articleclasslist_toolBar.del()">删除</a>
    </div>
    <div><ul id="articleclasslist" class="ztree"></ul></div>
    <input type="hidden" id="classid" value="-1"/>
    <div id="articleclasslist_edit" style="display: none;"  >
        <table style="width:460px;font-size:9pt;margin-top: 10px;margin-left: 10px;" cellspacing="2" border="0" align="left" >
            <tr>
                <td width="15%">栏目名称</td>
                <td>
                    <input type="text" id="articleclasslist_edit_title" width="300" value='' />
                </td>
            </tr>
        </table>
    </div>
    <div id="articleclasslist_add" style="display: none;"  >
        <table style="width:460px;font-size:9pt;margin-top: 10px;margin-left: 10px;" cellspacing="2" border="0" align="left" >
            <tr>
                <td width="15%">栏目名称</td>
                <td>
                    <input type="text" id="articleclasslist_add_title" width="300" value='' />
                </td>
            </tr>
        </table>
    </div>
</div>
</div>