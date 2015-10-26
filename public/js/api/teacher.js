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
                $.toastMsg(response.data, 1500);
            }
        },
        error: function () {

        }
    });
}

function queryTeacherByName(search) {
    var url = '/api/teacher/name/get';

    var  data = { 'search': search }
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
                $.toastMsg(response.data, 1500);
            }

            closePopup($("#pp-change-loc").find('.cd-slidepopupback'));
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

function applyTeacher(customer_id, sex, birthday, code, email, wechat, region_id, category_id, bank, bank_code, description, location, cer, show, fun) {
    var url = '/api/teacher/apply';
    //alert(show);
    var  data = { 'teacher_id':customer_id, 'sex':sex, 'birthday':birthday, 'code':code, 'email':email, 'wechat':wechat, 'region_id':region_id, 'category_id':category_id, 'bank':bank, 'bank_code':bank_code, 'description':description, 'location': location, 'cer': cer, 'show':show }
    //alert(JSON.stringify(data));
    //return;
    $.ajax({
        url: url,
        dataType: 'json',
        data: data,
        method: 'post',
        success: function (response) {
            //alert(JSON.stringify(response)); //return;
            if (response.code == 200) {
                if (fun) {
                    fun();
                }
            }
            else {
                $.toastMsg(response.data, 1500);
            }
        },
        error: function () {

        }
    });
}

function setRange(teacher_id, cell, range, lat, lng,  fun) {
    var url = '/api/set/range';

    var  data = { 'teacher_id':teacher_id, 'cell':cell, 'range':range, 'lat':lat, 'lng':lng }
    //alert(JSON.stringify(data)); return;
    $.ajax({
        url: url,
        dataType: 'json',
        data: data,
        method: 'post',
        success: function (response) {
            //alert(JSON.stringify(response)); return;
            if (response.code == 200) {
                if (fun) {
                    fun();
                }
            }
            else {
                $.toastMsg(response.data, 1500);
            }
        },
        error: function () {

        }
    });
}
