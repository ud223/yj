//----------------------地址------------------------------------------
//深圳 114.081278 22.531413
//武汉 114.308168,30.646992l

function initAddress() {
    //如果没有添加地址，就获取gps当前位置
    if (!is_address) {
        var cell = localStorage.getItem("cell");
        var lat = localStorage.getItem("lat");
        var lng = localStorage.getItem("lng");

        if (!lat) {
            getLocal();
        }
        else {
            $("#address-view").html(cell);
            $("#address-view").attr("lat", lat);
            $("#address-view").attr("lng", lng);
        }
    }
}

function chooseAddr(node) {
    ///$("#edit-addr").val(text);
    $("#address-view").html(node.find(".t1").html());

    $("#address-view").attr("lat", node.find(".t1").attr("lat"));
    $("#address-view").attr("lng", node.find(".t1").attr("lng"));

    localStorage.setItem("cell",node.find(".t1").html());
    localStorage.setItem("lat", node.find(".t1").attr("lat"));
    localStorage.setItem("lng", node.find(".t1").attr("lng"));

    closePopup($("#pp-change-addr").find('.cd-slidepopupback'));
}

function setAddressList(response) {
    var addresses = response.result.pois;
    var list = $("#addr-list");

    list.html("");

    $("#address-view").html(addresses[0].name);

    $.each(addresses, function() {
        var node = $("#div-addr-node").find(".loc-ddl-itm").clone();

        node.find(".t1").html(this.name);
        node.find(".t1").attr("lng", this.point.x);
        node.find(".t1").attr("lat", this.point.y);

        node.find(".t2").html(this.addr);

        addrClick(node);

        list.append(node);
    });
}

function applyAddress() {
    $("#address-view").html($("#edit-addr").val());
}

//function applyAddressDetail() {
//    //$("#address-detail-view").html($("#address-detail").val());
//}

//-----------------------手机短信验证------------------------------------------

var countdown=60;
var is_count = false;

function settime(val) {
    if (!is_count)
        return;

    if (countdown == 0) {
        $(val).removeAttr("disabled");
        $(val).html("发送验证码");
        countdown = 60;
        is_count = false
    } else {
        $(val).attr("disabled", "true");
        $(val).html("重新发送(" + countdown + ")");
        countdown--;
    }
    setTimeout(function() { settime(val) },1000)
}

function setPhoneCode(response) {
    $("#phone-num").attr("code", response.data);
}

function getPhoneValidCode() {
    if (is_count) {
        return;
    }

    var phone_num = $("#phone-num").val();

    if (!phone_num || phone_num.length != 11) {
        $.toastMsg("请输入正确手机号码!", 1500);

        return;
    }
    is_count = true;
    settime(document.getElementById("send-code"));

    //return;

    getPhoneValid(phone_num, setPhoneCode);
}

function validPhoneCode() {
    var tmp_1 = $("#phone-code").val();
    var tmp_2 = $("#phone-num").attr("code");

    if ($("#phone-num").val() == "") {
        $.toastMsg("请输入电话号码!", 1500);

        return;
    }

    if (tmp_1 != tmp_2) {
        $.toastMsg("验证码输入错误!", 1500);

        return;
    }

    $("#customer-phone").html($("#phone-num").val());

    //$("#pp-change-tel").find(".cd-slidepopupback").tap();

    closePopup($("#pp-change-tel").find('.cd-slidepopupback'));
}

//----------选择日期和时间段-----------------------------------------------------

function initWeek() {
    var date = null;

    //if (rundate) {
    //    date = new Date(rundate);
    //}
    //else {
    //    date = new Date();
    //}

    date = new Date();

    var t_year = date.getFullYear();
    var t_month = date.getMonth() + 1;
    var t_day = date.getDate();

    var today = t_year + "-" + singleDateCheck(t_month) + "-" + singleDateCheck(t_day);

    var week_html = "";

    for (var i = 0; i < 7; i++) {
        var year = date.getFullYear();
        var month = date.getMonth() + 1;
        var day = date.getDate();
        var  full_date = year + "-" + singleDateCheck(month) + "-" + singleDateCheck(day);

        if (full_date == rundate) {
            week_html = week_html + '<div class="td  week-td selected" val="'+ full_date +'">'+ month +'月'+ day +'日</div>';
        }
        else {
            week_html = week_html + '<div class="td  week-td" val="'+ full_date +'">'+ month +'月'+ day +'日</div>';
        }
        //if (week_html == "") {
        //    week_html = week_html + '<div class="td week-td selected" val="'+ full_date +'">'+ month +'月'+ day +'日</div>';
        //    //给提交的选择日期赋初值
        //    $("#select_date").val(full_date);
        //}
        //else {

        //}
        date.setDate(date.getDate() + 1);
    }

    $(".time-day-select").find(".table").html(week_html);

    if ($(".time-day-select").find(".selected").length == 0) {
        $($(".time-day-select").find(".week-td")[0]).addClass("selected");
    }
}

function timeChoose(time) {
    var val = $(time).attr("val");
    var selected_time = $("#time-panel").find(".selected");

    if (selected_time.length == 0) {
        if (!checkMaxHour()) {
            return;
        }

        $(time).addClass("selected");

        var date = $(".time-day-select").find(".table").find(".selected").html();

        $("#show-view-time").html(date +" "+$(time).html());
        $("#time_range").val($(time).html() + "|" + $(time).attr("val"));
    }
    else if (selected_time.length == 1) {
        if ($(time).hasClass("selected")) {
            $(time).removeClass("selected");
        }
        else {
            checkTime(selected_time, $(time));
        }
    }
    else {
        checkTime(selected_time, $(time));
    }
}

function acceptTime() {
    selected_time = $("#time-panel").find(".selected");

    if (selected_time.length == 0) {
        $("#date-time").val("");
        $("#time_range").val("");
        $("#hour").html("0");
        $("#amount").html("0");
        $("#pay-amount").html("0");
    }
    else {
        if (selected_time.length == 1) {
            var first_html = $(selected_time[0]).html();
            var last_html = (parseInt($(selected_time[0]).attr("val")) + 1) + ":00";
            var first_time = $(selected_time[0]).attr("val");
            var last_time = $(selected_time[selected_time.length - 1]).attr("val");

            var date = $(".time-day-select").find(".table").find(".selected").html();

            $("#date-time").html(date +" "+ first_html);
            $("#time_range").val(first_html + "|" + first_time);
            $("#hour").html("1");
            $("#amount").html(order_price);
            $("#pay-amount").html(order_price - 200);
        }
        else if (selected_time.length > 1) {
            var first_html = $(selected_time[0]).html();
            //var last_html = $(selected_time[selected_time.length - 1]).html();
            var last_html = (parseInt($(selected_time[selected_time.length - 1]).attr("val")) + 1) + ":00";
            var first_time = $(selected_time[0]).attr("val");
            var last_time = $(selected_time[selected_time.length - 1]).attr("val");

            var date = $(".time-day-select").find(".table").find(".selected").html();

            $("#date-time").html(date +" "+ first_html +"-"+ last_html);
            $("#time_range").val(first_html +"-"+ last_html + "|" + first_time +"-"+last_time);

            var hour = parseInt(last_time) - parseInt(first_time) + 1;

            $("#hour").html(hour);
            $("#amount").html(order_price * hour);
            $("#pay-amount").html(order_price * hour);
        }

        $("#select-timespan").show();

        //$("#pp-change-time").find(".cd-slidepopupback").tap();

        closePopup($("#pp-change-time").find('.cd-slidepopupback'));
    }
}

function checkMaxHour() {
    var selected_time = $("#time-panel").find(".selected");

    if (selected_time.length > 2) {
        $.toastMsg("单次预约不能超过3小时!", 1500);

        return false;
    }

    if (tmp_max_hours - selected_time.length < 1) {
        $.toastMsg("已超出最大预约数!", 1500);

        return false;
    }

    return true;
}

function checkTime(use_times, time) {
    var first_time = parseInt($(use_times[0]).attr("val"));
    var last_time = parseInt($(use_times[use_times.length - 1]).attr("val"));
    var tmp_time = parseInt($(time).attr("val"));

    if (first_time - 1 == tmp_time || last_time + 1 == tmp_time) {
        if (!checkMaxHour()) {
            return;
        }

        $(time).addClass("selected");
    }
    else {
        modifyClass(use_times, time);
    }
}

function modifyClass(use_times, time) {
    var first_time = parseInt($(use_times[0]).attr("val"));
    var last_time = parseInt($(use_times[use_times.length - 1]).attr("val"));
    var tmp_time = parseInt($(time).attr("val"));

    if (first_time - 1 > tmp_time || last_time + 1 < tmp_time) {
        $(".time-space").removeClass("selected");

        $(time).addClass("selected");
    }
    else {
        if (first_time == tmp_time || last_time == tmp_time) {
            $(time).removeClass("selected");
        }
        else {
            var isDelete = false;

            for (var i = 0; i < use_times.length; i++) {
                var t_time = parseInt($(use_times[i]).attr("val"));

                if (t_time == tmp_time) {
                    isDelete = true;
                }

                if (isDelete) {
                    $(use_times[i]).removeClass("selected");
                }
            }
        }
    }
}

function initSelectTime() {
    var rundate = $("#date-time").attr("rundate");
    var time = $("#date-time").attr("time");

    var weeks = $(".time-day-select").find(".table").find(".week-td");

    $.each(weeks, function() {
       if ($(this).attr("val") == rundate) {
           $(this).addClass("selected");
       }
    });

    var hour = time.split("-");

    if (hour.length == 1) {
        setTimeSelected(hour[0]);
    }
    else {
        var max = parseInt(hour[1]) + 1;

        for (var i = hour[0]; i < max; i++) {
            setTimeSelected(i);
        }
    }

    var order = new Order();

    order.getByDay(teacher_id, rundate, setUseTime);
}

function setTimeSelected(time) {
    var times = $(".time-tb").find(".td");

    $.each(times, function() {
       if ($(this).attr("val") == time) {
           $(this).addClass("selected");

           return;
       }
    });
}

function toPay() {
    //var url = '/order/pay/' + order_id + '?showwxpaytitle=1';
    var url = '/pay/success/'+ order_id;

    location.href = url;
}

function chooseDay(week) {
    if ($(week).hasClass("selected")) {
        return;
    }

    $(".time-day-select").find(".table").find(".selected").removeClass("selected");

    $(week).addClass("selected");
    $(".time-space").removeClass("selected");
    $(".time-space").removeClass("unclickable");
    $(".time-space").removeClass("use-time");
    $("#select_date").val($(week).attr("val"));
    $("#show-view-time").html(dateToMonthAndDay($(week).attr("val")))

    var order = new Order();

    order.getByDay(teacher_id, $(week).attr("val"), setUseTime);

    var tmp_rundate = $(week).attr("val");
    var rundate = $("#date-time").attr("rundate");

    if (rundate == tmp_rundate) {
        initSelectTime();
    }
}

function setUseTime(response) {
    var tmp_now = new Date();
    var user_id = localStorage.getItem('user_id');

    $.each(response.data, function() {
        var tmp_time = this.time.split("|")[1];
        var time_value = tmp_time.split("-");
        var list = $("#time-panel").find(".time-space");
        var tmp_date_time_1 = this.created_date;
        var tmp_date_time_2 = this.updated_at;

        if (this.state > 10) {
            $.each(list, function() {
                var value = parseInt($(this).attr("val"));

                if (time_value.length == 1) {
                    if (value + 1 == time_value[0] || value - 1 == time_value[0]) {
                        $(this).addClass("unclickable")
                    }

                    if (value == time_value[0]) {
                        $(this).addClass("unclickable");
                        $(this).addClass("unclickable use-time");
                    }
                }
                else {
                    if (value + 1 == time_value[0] || value - 1 == time_value[1]) {
                        $(this).addClass("unclickable")
                    }

                    if (value >= time_value[0] && value <= time_value[1]) {
                        $(this).addClass("unclickable");
                        $(this).addClass("use-time");
                    }
                }
            })
        }
        else {//判断修改订单时间跟现在的时间差
            if (tmp_date_time_2) {
                if ($(this).hasClass("selected") && user_id == customer_id) {
                    return;
                }

                var t_time = new Date(tmp_date_time_2);

                var diff_time = parseInt((tmp_now - t_time) / (60 * 1000));

                if (diff_time < 3) {
                    $.each(list, function () {
                        if ($(this).hasClass("selected") && user_id == customer_id) {
                            return;
                        }

                        var value = parseInt($(this).attr("val"));

                        if (time_value.length == 1) {
                            if (value + 1 == time_value[0] || value - 1 == time_value[0]) {
                                $(this).addClass("unclickable")
                            }

                            if (value == time_value[0]) {
                                $(this).addClass("unclickable");
                                $(this).addClass("unclickable use-time");
                            }
                        }
                        else {
                            if (value + 1 == time_value[0] || value - 1 == time_value[1]) {
                                if (user_id != customer_id) {
                                    $(this).addClass("unclickable")
                                }
                            }

                            if (value >= time_value[0] && value <= time_value[1]) {
                                $(this).addClass("unclickable");
                                $(this).addClass("use-time");
                            }
                        }
                    })
                }
            }
            else {//判断创建订单时间跟现在的时间差
                var t_time = new Date(tmp_date_time_1);

                var diff_time = parseInt((tmp_now - t_time) / (60 * 1000));

                if (diff_time < 3) {
                    $.each(list, function () {
                        if ($(this).hasClass("selected") && user_id == customer_id) {
                            return;
                        }

                        var value = parseInt($(this).attr("val"));

                        if (value + 1 == time_value[0] || value - 1 == time_value[1]) {
                            if (user_id != customer_id) {
                                $(this).addClass("unclickable")
                            }
                        }

                        if (value >= time_value[0] && value <= time_value[1]) {
                            $(this).addClass("unclickable");
                            $(this).addClass("use-time");
                        }
                    })
                }
            }
        }
    });

    initUseHours();
}

function initUseHours() {
    var select_date = $(".time-day-select").find(".selected").attr("val");
    var tmp_today = new Date();
    var t_year = tmp_today.getFullYear();
    var t_month = tmp_today.getMonth() + 1;
    var t_day = tmp_today.getDate();
    var str_Today = t_year + "-" + singleDateCheck(t_month) + "-" + singleDateCheck(t_day);

    var use_hours = $("#time-panel").find(".use-time");

    tmp_max_hours = max_hours;

    tmp_max_hours = tmp_max_hours - use_hours.length;


    var tmp_date = new Date();

    var cur_hour = tmp_date.getHours() + 1;

    var td =  $("#time-panel").find(".td");

    if (tmp_max_hours < 1) {
        $(td).addClass("unclickable");
    }
    else {
        if (select_date != str_Today) {
            $.each(td, function() {
                if ($(this).attr('val') <= cur_hour) {
                    $(this).addClass("unclickable");
                }
            });
        }
    }
}

function submitOrder() {
    var order = new Order();

    var customer_name = $("#customer_name").val();
    var phone = $("#customer-phone").html();
    var address = $("#address-view").html();
    var address_detail = $("#address-detail").val();
    var rundate = $("#select_date").val();
    var hour = $("#hour").html();
    var time = $("#time_range").val();
    var amount = $("#amount").html();
    var pay_amount = $("#pay-amount").html();
    var lat = $("#address-view").attr("lat");
    var lng = $("#address-view").attr("lng");

    order.confrim(rundate, time, hour, amount, pay_amount, address, address_detail, phone, customer_name, lat, lng, toPay);
}


function busyDay() {
    $(".time-space").addClass("unclickable");
}




