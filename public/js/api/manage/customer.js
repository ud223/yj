function queryCustomerList(page, name) {
    var url = '/api/customer/list';

    var  data = { 'page': page, 'nickname': name }
    //alert(JSON.stringify(data));
    $.ajax({
        url: url,
        dataType: 'json',
        data: data,
        method: 'post',
        success: function (response) {
            //alert(JSON.stringify(response))
            if (response.code == 200) {
                //加载活动集合
                loadCustomerRow(response.data, response.current_page_no, response.page_count, name);
            }
            else {
                alert(response.data);
            }
        },
        error: function () {

        }
    });
}