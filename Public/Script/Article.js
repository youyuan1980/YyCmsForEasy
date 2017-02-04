var article = (function(){  
    var beforeRemove = function(treeId, treeNode) {
        if(confirm('确认删除此栏目吗？'))
        {
            var classid = treeNode.id;
            $.ajax({
                url:configUrl.articleclasslist_delUrl,
                async:false,
                dataType:'json',
                data:{"classid":classid},
                type:'get',
                success:function(text){
                    articleclasslist_dataBinder();
                },
                error:function(text){
                    alert('删除失败');
                }
            });
        }
        return false;
    }
    
    var beforeRename = function(treeId, treeNode, newName, isCancel) {
        var classid = treeNode.id;
        var title = newName;
        $.ajax({
            url:configUrl.articleclasslist_editUrl,
            data:{"classid":classid,"title":title},
            async:false,
            dataType:'json',
            type:'get',
            success:function(json){
                articleclasslist_dataBinder();
            },
            error:function(json){
                alert('保存失败');
            }
        });
        return true;
    }
    
    var showRemoveBtnOrRenameBtn = function(treeId, treeNode) {
        if (treeNode.id != "-1")
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    
    var addHoverDom = function(treeId, treeNode) {
        if (treeNode.id != "-1")
        {
            var sObj = $("#" + treeNode.tId + "_span");
			if (treeNode.editNameFlag || $("#addBtn_"+treeNode.tId).length>0) return;
			var addStr = "<span class='button add' id='addBtn_" + treeNode.tId
				+ "' title='添加' onfocus='this.blur();'></span>";
			sObj.after(addStr);
			var btn = $("#addBtn_"+treeNode.tId);
			if (btn) btn.bind("click", function(){
				$.ajax({
                    url:configUrl.articleclasslist_addUrl,
                    data:{"pid":treeNode.id,"title":'新栏目'},
                    async:false,
                    dataType:'json',
                    type:'get',
                    success:function(json){
                        articleclasslist_dataBinder();
                    },
                    error:function(json){
                        alert('保存失败');
                    }
                });
				return false;
			});
        }
    }
    
    var removeHoverDom = function(treeId, treeNode) {
        $("#addBtn_"+treeNode.tId).unbind().remove();
    };  

    var zTreeOnClick_articleclass = function(event, treeId, treeNode)
    {
        $(article_html_id.articlelist_title).attr("value","");
        article_html_id.classid = treeNode.id;
        articlelist_dataBinder();
    }
    
    var articleclasslist_setting = {
        data: {
            simpleData: {
                enable: true
            }            
        },
        edit: {
            enable: true,
            showRemoveBtn : showRemoveBtnOrRenameBtn,
            showRenameBtn : showRemoveBtnOrRenameBtn,
            removeTitle : "删除",
            renameTitle : "编辑",
            editNameSelectAll: true
        },
        view: {
            addHoverDom: addHoverDom,
            removeHoverDom: removeHoverDom
        },
        callback: {
            beforeDrag: false,
            onClick: zTreeOnClick_articleclass,
            beforeEditName: true,
            beforeRemove: beforeRemove,
            beforeRename: beforeRename
        }
    };

    var articleclasslist_dataBinder = function()
    {
        $.ajax({
            url:configUrl.articleclasslist_dataBinderUrl,
            async:false,
            dataType:'json',
            type:'get',
            success:function(json){
                $.fn.zTree.init($(articleclass_html_id.articleclasslist), articleclasslist_setting, json);
            },
            error:function(json){
                alert('加载失败');
            }
        });
    }
    
    var articleclass_html_id = {
        articleclasslist : "#articleclasslist"
    }
    
    var article_html_id = {
        articlelist : "#articlelist",
        articlelist_title : "#articlelist_title",
        articlelist_toolbar : "#articlelist_toolbar",
        classid : null
    }
    
    var configUrl = {
        articleclasslist_dataBinderUrl : null,
        articleclasslist_addUrl : null,
        articleclasslist_editUrl : null,
        articleclasslist_delUrl : null,
        articlelist_dataBinderUrl : null
    };
    
    var init = function(articleclasslist_dataBinderUrl,articleclasslist_addUrl,articleclasslist_editUrl,articleclasslist_delUrl,articlelist_dataBinderUrl)
    {
        configUrl.articleclasslist_dataBinderUrl = articleclasslist_dataBinderUrl;
        configUrl.articleclasslist_addUrl = articleclasslist_addUrl;
        configUrl.articleclasslist_editUrl = articleclasslist_editUrl;
        configUrl.articleclasslist_delUrl = articleclasslist_delUrl;
        configUrl.articlelist_dataBinderUrl = articlelist_dataBinderUrl;
        articleclasslist_dataBinder();
    }
    
    var article_list_columns = [
        {field: 'title', title: '标题', width: 500}
    ];
    
    //信息管理
    var articlelist_dataBinder = function () { 
        var title = $(article_html_id.articlelist_title).attr("value");  
      var queryParams = {classid:article_html_id.classid,title:title};
        
        Common.loadDataGrid(configUrl.articlelist_dataBinderUrl,article_list_columns,article_html_id.articlelist,article_html_id.articlelist_toolbar,queryParams);
    };
    
    var doSearch = function (){
        $(article_html_id.articlelist).datagrid('load',{
            title: $(article_html_id.articlelist_title).attr("value"),
            classid : article_html_id.classid
        });
    }
    return {init:init,doSearch:doSearch};
})();


    
    

