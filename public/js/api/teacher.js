function queryTeacherList(search, sort, page) {
    var url = '/api/teacher/get';

    var  data = { 'page': page, 'search': search, 'sort': sort }
    //alert(JSON.stringify(data));
    $.ajax({
        url: url,
        dataType: 'json',
        data: data,
        method: 'post',
        success: function (response) {
            //alert(JSON.stringify(response)); //return;
            if (response.code == 200) {
                //加载活动集合
                loadTeacher(response.data, response.current_page_no, response.page_count);
            }
            else {
                alert(response.data);
            }
        },
        error: function () {

        }
    });
}