<?php if (!defined('THINK_PATH')) exit();?>    <table style="margin-left:70px;margin-top:10px;" border="0">
        <tr>
            <td style="width:180px;" height="23">
                父栏目：
            </td>
            <td style="width:300px;" height="23">
                &nbsp;<?php echo ($ptitle); ?>
            </td>
        </tr>
        <tr>
            <td  height="23">
                栏目ID：
            </td>
            <td  height="23">
                &nbsp;<input class="easyui-validatebox" value="<?php echo ($classid); ?>" <?php echo ($classidreadonly); ?> type="text" id="classid" data-options="required:true" />
            </td>
        </tr>
        <tr>
            <td height="23">
                栏目名称：
            </td>
            <td height="23">
                &nbsp;<input class="easyui-validatebox" value="<?php echo ($title); ?>" type="text" id="alertclass_title" data-options="required:true" />
            </td>
        </tr>
    </table>
<script>
    function articleclass_save()
    {
        var pid = '<?php echo ($pid); ?>';
        var classid = '<?php echo ($classid); ?>';
        var title = '<?php echo ($title); ?>';
        $.ajax({
            url: '<?php echo ($actionurl); ?>',
            type: 'post',
            dataType: 'text',
            data: {'pid': pid:'classid':classid,'title':title},
            success:function (text) {
                // body...
                alert(text);
            }
        });
    }
</script>