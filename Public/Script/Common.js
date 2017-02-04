var Common = (function(){
    loadDataGrid = function(url,columns,listid,toolbarid,queryParams){
        $(listid).datagrid({
            url: url,
            fit:true,
            queryParams:queryParams,
            height: 'auto',
            fitColumns: true,
            singleSelect: true,
            pageSize: 10,
            pageList: [10],
            pagination: true,
            columns: [columns],
            toolbar:toolbarid
        });
    }
    return {loadDataGrid : loadDataGrid};
})();
