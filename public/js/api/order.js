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
                alert(response.data);
            }
        },
        error: function () {

        }
    });
}

function confirmOrder(rundate, time, hour, amount, pay_amount, customer_name, address, phone, fun) {
    var url = '/api/order/confirm';

    var  data = { 'id':order_id, 'pay_amount':pay_amount, 'rundate':rundate, 'time':time, 'hour':hour, 'price': order_price, 'amount':amount, 'customer_name':customer_name, 'address':address, 'phone':phone }
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
                alert(response.data);
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
                alert("删除成功!");

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
            //alert(JSON.stringify(response)); //return;
            if (response.code == 200) {
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