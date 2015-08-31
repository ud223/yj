var Order = function() {
    var obj = new Object();

    obj.message = false;

    obj.check = function(rundate, time) {
        if (!rundate) {
            obj.message = "授课日期不能为空!";

            return false;
        }

        if (!time) {
            obj.message = "授课时间段不能为空!";

            return false;
        }

        return true;
    }

    obj.confrimCheck = function(rundate, time, customer_name, phone, address) {
        if (!rundate) {
            obj.message = "授课日期不能为空!";

            return false;
        }

        if (!time) {
            obj.message = "授课时间段不能为空!";

            return false;
        }

        if (!customer_name) {
            obj.message = "联系姓名不能为空!!";

            return false;
        }

        if (!phone) {
            obj.message = "联系电话不能为空!";

            return false;
        }

        if (!address) {
            obj.message = "授课地址不能为空!";

            return false;
        }

        return true;
    }

    obj.add = function(customer_id, teacher_id, rundate, time, price, fun) {
        if (!obj.check(rundate, time)) {
            $.toastMsg(obj.message, 3000);

            return;
        }

        var hour = obj.getHour(time);

        if (hour == 0) {
            $.toastMsg(obj.message, 3000);

            return;
        }

        var amount = hour * price;

        addOrder(customer_id, teacher_id, rundate, time, hour, price, amount, fun);
    }


    obj.confrim = function(rundate, time, hour, amount, pay_amount, address, phone, customer_name, address, phone,  fun) {
        if (!obj.confrimCheck(rundate, time, customer_name, phone, address)) {
            $.toastMsg(obj.message, 3000);

            return;
        }

        confirmOrder(rundate, time, hour, amount, pay_amount, customer_name, address, phone, fun);
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