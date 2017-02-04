/**
 * Created by youyuan1980 on 17-1-29.
 */
var index = (function () {
    var zTreeOnClick = function(event, treeId, treeNode) {
        Open(treeNode.name, treeNode.myurl);
    };
    var Open = function (text, url) {
        $("#p").panel({
            title:text,
            fit:true
        }).panel('refresh',url);
    };
    var setting = {
        data: {
            simpleData: {
                enable: true
            }
        },
        callback: {
            onClick: zTreeOnClick
        }
    };
    var init = function (url) {
        //alert(url);
        $.ajax({
            url:url,
            async:false,
            type:'get',
            dataType:'json',
            success:function(text)
            {
                $.fn.zTree.init($("#treeDemo"), setting, text);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert(XMLHttpRequest.status);
                alert(XMLHttpRequest.readyState);
                alert(textStatus);
            }
        });
    }
    return {init:init,Open:Open};
})();

