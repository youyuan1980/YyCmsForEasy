var user = (function () {
    //显示用户信息页面
    var main = function (url) {
        $.ajax({
            url:url,
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
    };
    //用户列表绑定
    var dataBinder = function (url) {
        $('#userlist').datagrid({
            url: url,
            fit:true,
            height: 'auto',
            fitColumns: true,
            singleSelect: true,
            pageSize: 10,
            pageList: [10],
            pagination: true,
            columns: [[
                {field: 'userid', title: '用户ID', width: 200},
                {field: 'username', title: '用户姓名', width: 500}
            ]],
            toolbar:"#userlist_toolbar"
        });
    }
    return {main : main,dataBinder:dataBinder};
})();
