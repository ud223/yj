function modifyValie(id, model, key, value, fun) {
    var url= "/api/set/value";

    var  data = { 'id':id, 'model':model, 'key':key, 'value':value }
    //alert(JSON.stringify(data)); //return;
    $.ajax({
        url: url,
        dataType: 'json',
        data: data,
        method: 'post',
        success: function (response) {
            //alert(JSON.stringify(response)); //return;
            if (response.code == 200) {
                alert("操作成功!");
                if (fun) {
                    fun(response);
                }
            }
            else {
                alert(response.data);
            }
        },
        error: function () {

        }
    });
}