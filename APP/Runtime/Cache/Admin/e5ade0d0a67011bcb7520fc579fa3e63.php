<?php if (!defined('THINK_PATH')) exit();?><table style="margin-left:20px;margin-top:10px;" border="0" id='userlist'>
    <tr>
        <td style="width:80px;" height="23">
            用户名：
        </td>
        <td style="width:400px;" height="23">
            &nbsp;<?php echo ($UserID); ?>
        </td>
    </tr>
    <tr>
        <td  height="23">
            用户姓名：
        </td>
        <td  height="23">
            &nbsp;<?php echo ($UserName); ?>
        </td>
    </tr>
    <tr>
        <td height="23">
            拥有权限：
        </td>
        <td height="23">
            &nbsp;<?php echo ($UserRoles); ?>
        </td>
    </tr>
</table>