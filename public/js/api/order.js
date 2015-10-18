function addOrder(customer_id, teacher_id, rundate, time, hour, price, amount, fun) {
    var url = '/api/order/add';

    var  data = { 'customer_id':customer_id, 'teacher_id':teacher_id, 'rundate':rundate, 'time':time, 'hour':hour, 'price': price, 'amount':amount }
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
                    fun(response);
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

function confirmOrder(rundate, time, hour, amount, pay_amount, address, address_detail, phone, customer_name, lat, lng, fun) {
    var url = '/api/order/confirm';

    var  data = { 'id':order_id, 'pay_amount':pay_amount, 'rundate':rundate, 'time':time, 'hour':hour, 'price': order_price, 'amount':amount, 'customer_name':customer_name, 'address':address, 'address_detail':address_detail, 'phone':phone, 'lat':lat, 'lng':lng }
    //alert(JSON.stringify(data)); //return;
    $.ajax({
        url: url,
        dataType: 'json',
        data: data,
        method: 'post',
        success: function (response) {
            //alert(JSON.stringify(response)); //return;
            if (response.code == 200) {
                if (fun) {
                    fun(response);
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

function removeOrder(id, fun) {
    var url = '/remove/order';

    var  data = { 'id':id }
    //alert(JSON.stringify(data)); //return;
    $.ajax({
        url: url,
        dataType: 'json',
        data: data,
        method: 'post',
        success: function (response) {
            //alert(JSON.stringify(response)); //return;
            if (response.code == 200) {
                $.toastMsg("删除成功!");

                if (fun) {
                    fun(response);
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

function getOrderBy(teacher_id, rundate, fun) {
    var url = '/api/get/order/by';

    var  data = { 'teacher_id':teacher_id, 'rundate':rundate }
    //alert(JSON.stringify(data)); //return;
    $.ajax({
        url: url,
        dataType: 'json',
        data: data,
        method: 'post',
        success: function (response) {
            alert(JSON.stringify(response)); //return;
            if (response.code == 200) {
                if (fun) {
                    fun(response);
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

function submitScore(order_id, time_score, content_score, way_score, teacher_appraise, fun) {
    var url = '/api/rating/order';

    var  data = { 'id':order_id, 'time_score':time_score, 'content_score':content_score, 'way_score':way_score, 'teacher_appraise':teacher_appraise }
    //alert(JSON.stringify(data));
    // return;
    $.ajax({
        url: url,
        dataType: 'json',
        data: data,
        method: 'post',
        success: function (response) {
            //alert(JSON.stringify(response)); //return;
            if (response.code == 200) {
                if (fun) {
                    fun(order_id);
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