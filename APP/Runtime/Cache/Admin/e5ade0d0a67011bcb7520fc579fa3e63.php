<?php if (!defined('THINK_PATH')) exit();?><table style="margin-left:20px;margin-top:10px;" border="0">
    <tr>
        <td style="width:80px;" height="23">
            用户名：
        </td>
        <td style="width:400px;" height="23">
            &nbsp;<label id="main_userid"></label>
        </td>
    </tr>
    <tr>
        <td  height="23">
            用户姓名：
        </td>
        <td  height="23">
            &nbsp;<label id="main_username"></label>
        </td>
    </tr>
    <tr>
        <td height="23">
            拥有权限：
        </td>
        <td height="23">
            &nbsp;<label id="main_userroles"></label>
        </td>
    </tr>
</table>
<script>
    $(function(){        
        $.ajax({
            url:"<?php echo U('user/getuserinfo');?>",
            async:false,
            type:'get',
            dataType:'json',
            success:function(text){
                $("#main_userid").html(text.userid);
                $("#main_username").html(text.username);
                $("#main_userroles").html(text.userrolesname);
            },
            error:function(text){
                alert(text);
            }
        });
    });
</script>