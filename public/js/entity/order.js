var Order = function() {
    var obj = new Object();

    obj.message = false;

    obj.check = function(rundate, time) {
        if (!rundate) {
            obj.message = "请选择授课日期!";

            return false;
        }

        if (!time) {
            obj.message = "请选择授课时间段!";

            location.href = "#teacher-time";

            return false;
        }

        return true;
    }

    obj.confrimCheck = function(rundate, time, customer_name, phone, address, address_detail) {
        if (!rundate) {
            obj.message = "请选择授课日期!";

            return false;
        }
        else {
            var tmp_rundate = new Date(rundate);
            var tmp_today = new Date();

            if (tmp_today.getTime() - tmp_rundate.getTime() > 72000000) {
                obj.message = "订单日期已经过期!";

                return false;
            }
        }

        if (!time) {
            obj.message = "请选择授课时间段!";

            return false;
        }

        if (!customer_name) {
            obj.message = "请输入联系人姓名!!";

            return false;
        }

        if (!phone) {
            obj.message = "请输入联系电话!";

            return false;
        }

        if (!address) {
            obj.message = "请输入授课地址!";

            return false;
        }

        if (!address_detail) {
            obj.message = "请输入授课地址详细地址!";

            return false;
        }

        return true;
    }

    obj.add = function(customer_id, teacher_id, rundate, time, price, fun) {
        if (!obj.check(rundate, time)) {
            $.toastMsg(obj.message, 1500);

            return;
        }

        var hour = obj.getHour(time);

        if (hour == 0) {
            $.toastMsg(obj.message, 1500);

            return;
        }

        var amount = hour * price;

        addOrder(customer_id, teacher_id, rundate, time, hour, price, amount, fun);
    }


    obj.confrim = function(rundate, time, hour, amount, pay_amount, address, address_detail, phone, customer_name, lat, lng, fun) {
        if (!obj.confrimCheck(rundate, time, customer_name, phone, address, address_detail)) {
            $.toastMsg(obj.message, 1500);

            return;
        }

        confirmOrder(rundate, time, hour, amount, pay_amount, address, address_detail, phone, customer_name, lat, lng, fun);
    }

    obj.getHour = function(hour) {
        var tmp_time = hour.split("|");

        if (tmp_time.length == 1) {
            obj.message = "选择时间错误!";

            return 0;
        }

        var tmp_hour = tmp_time[1].split("-");
        //只选择了一个小时
        if (tmp_hour.length == 1) {
            return 1;
        }
        else {
            var tmp1 = parseInt(tmp_hour[0]);
            var tmp2 = parseInt(tmp_hour[1]);

            return tmp2 - tmp1 + 1;
        }
    }

    obj.remove = function(id, fun) {
        removeOrder(id, fun);
    }

    obj.getByDay = function(teacher_id, rundate, fun) {
        getOrderBy(teacher_id, rundate, fun);
    }

    return obj;
}