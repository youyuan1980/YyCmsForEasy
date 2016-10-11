<?php if (!defined('THINK_PATH')) exit();?><script type="text/javascript">
    $(function () {
        $('#userlist').datagrid({
            url: '<?php echo U('user/UserListForEasy');?>',
            title: '用户列表',
            width: 700,
            height: 'auto',
            fitColumns: true,
            singleSelect:true,
            pageSize:10,
            pageList:[10],
            pagination:true,
            columns: [[
                {field: 'userid', title: '用户ID', width: 200},
                {field: 'username', title: '用户姓名', width: 500}
            ]],
            toolbar:[{
                text:'添加',
                iconCls:'icon-add',
                handler:function(){
                    $('#userlist').datagrid('endEdit', lastIndex);
                    $('#userlist').datagrid('appendRow',{
                        itemid:'',
                        productid:'',
                        listprice:'',
                        unitprice:'',
                        attr1:'',
                        status:'P'
                    });
                    lastIndex = $('#userlist').datagrid('getRows').length-1;
                    $('#userlist').datagrid('selectRow', lastIndex);
                    $('#userlist').datagrid('beginEdit', lastIndex);
                }
            },'-',{
                text:'编辑',
                iconCls:'icon-edit',
                handler:function(){
                    var row = $('#userlist').datagrid('getSelected');
                    if(row) {
                        alert(row.userid);
                    }
                }
            },'-',{
                text:'删除',
                iconCls:'icon-remove',
                handler:function(){
                    var row = $('#userlist').datagrid('getSelected');
                    if (row){
                        var userid = row.userid;
                        del_user(userid);
                    }
                }
            },'-',{
                text:'查询',
                iconCls:'icon-search',
                handler:function(){
                    var rows = $('#userlist').datagrid('getChanges');
                    alert('changed rows: ' + rows.length + ' lines');
                }
            }]
        });
    });



        function del_user(userid)
    	{
        	var msg = window.confirm("您确定删除吗?");
        	if (msg) {
        		var url='<?php echo U('user/deleteuser');?>';
        		$.post(url, {userid:userid}, function(data) {
        			alert(data.info);
                    $('#userlist').datagrid('reload');
                });
        	}
        	else
        	{
        		return false;
        	}
        }
    //    function restuserpwd (userid) {
    //    	var msg = window.confirm("您确定重置密码吗?");
    //    	if (msg) {
    //    		var url='<?php echo U('user/restuserpwd');?>';
    //    		var p='<?php echo I('get.p','');?>';
    //    		var tbuserid=$("#TbUserID").attr("value");
    //    		$.post(url, {p: p,tbuserid:tbuserid,userid:userid}, function(data) {
    //    			alert(data.info);
    //    			location.href=data.url;
    //    		});
    //    	}
    //    	else
    //    	{
    //    		return false;
    //    	}
    //    }
</script>
<div>
    <table id="userlist"></table>
    <!--<div class="PageToolBar">-->
    <!--<img src="/yycmsforeasy/Public/Images/add.gif"><a href="<?php echo U('user/add');?>">添加用户</a>-->
    <!--</div>-->
    <!--<div id="PageTitle">-->
    <!--用户ID或用户姓名：-->
    <!--<input type="text" value="<?php echo ($TbUserID); ?>" id="TbUserID" name="TbUserID" width="83" />-->
    <!--&nbsp;-->
    <!--<img src="/yycmsforeasy/Public/images/search.gif" alt="#" onclick="submit();" style=" cursor: hand; "/>-->
    <!--</div>-->
    <!--<div id="container">-->
    <!--<div id="content">-->
    <!--<table border="0" id='userlist' class="table table-hover table-bordered table-condensed">-->
    <!--<thead><tr><th>用户ID</th><th>用户名</th><th>操作</th></tr></thead>-->
    <!--<tbody>-->
    <!--<?php if(is_array($userlist)): $i = 0; $__LIST__ = $userlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>-->
    <!--<tr><td><?php echo ($item["userid"]); ?></td><td><?php echo ($item["username"]); ?></td>-->
    <!--<td><a href="<?php echo U('user/edit',array('userid'=>$item[userid]));?>" >编辑</a>&nbsp;&nbsp;<a href="#" onclick="restuserpwd('<?php echo ($item["userid"]); ?>')">重置密码</a>&nbsp;&nbsp;<a href="#" onclick="del_user('<?php echo ($item["userid"]); ?>')">删除</a>&nbsp;&nbsp;</td>-->
    <!--</tr>-->
    <!--<?php endforeach; endif; else: echo "" ;endif; ?>-->
    <!--</tbody>-->
    <!--</table>-->
    <!--<table id="pager"><tr><td><div class="pages"><?php echo ($page); ?></div></td></tr>-->
    <!--</table>-->
    <!--</div>-->
    <!--</div>-->
</div>