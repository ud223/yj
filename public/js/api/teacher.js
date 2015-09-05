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
            //alert(JSON.stringify(response));
            // return;
            if (response.code == 200) {
                //加载活动集合
                loadTeacher(response.data, response.current_page_no, response.page_count);
            }
            else {
                $.toastMsg(response.data, 3000);
            }
        },
        error: function () {

        }
    });
}

function getTeacherBusy(teacher_id, date, control, fun, fun1) {
    var url = '/api/teacher/is/busy';

    var  data = { 'teacher_id':teacher_id, 'date':date }
    //alert(JSON.stringify(data));
    $.ajax({
        url: url,
        dataType: 'json',
        data: data,
        method: 'post',
        success: function (response) {
            //alert(JSON.stringify(response)); //return;
            if (response.code == 200) {
                if (fun) {
                    fun(control);
                }
            }
            else {
                if (fun1) {
                    fun1(control);
                }
            }
        },
        error: function () {

        }
    });
}