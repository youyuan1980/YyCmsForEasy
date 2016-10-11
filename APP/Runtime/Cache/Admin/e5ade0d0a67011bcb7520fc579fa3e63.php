<?php if (!defined('THINK_PATH')) exit();?><div>
    <table border="0" id='userlist'>
        <tr>
            <td width="126" height="23">
                用户名：
            </td>
            <td width="580" height="23">
                &nbsp;<?php echo ($UserID); ?>
            </td>
        </tr>
        <tr>
            <td width="126" height="23">
                用户姓名：
            </td>
            <td width="580" height="23">
                &nbsp;<?php echo ($UserName); ?>
            </td>
        </tr>
        <tr>
            <td width="126" height="23">
                拥有权限：
            </td>
            <td width="580" height="23">
                &nbsp;<?php echo ($UserRoles); ?>
            </td>
        </tr>
    </table>
</div>