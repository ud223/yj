//----------------------地址------------------------------------------

function initAddress() {
    var lng = "114.308585";
    var lat = "30.646429";

    getAddressByCoordinate(lng, lat, setAddressList);
}

function chooseAddr(text) {
    $("#edit-addr").val(text);
}

function setAddressList(response) {
    var addresses = response.result.pois;
    var list = $("#addr-list");

    list.html("");

    $("#address-view").html(addresses[0].name);

    $.each(addresses, function() {
        var node = $("#div-addr-node").find(".loc-ddl-itm").clone();

        node.find(".t1").html(this.name);
        node.find(".t2").html(this.addr);

        addrClick(node);

        list.append(node);
    });
}

function applyAddress() {
    $("#address-view").html($("#edit-addr").val());
}

//-----------------------手机短信验证------------------------------------------

function setPhoneCode(response) {
    $("#phone-num").attr("code", response.data);
}

function getPhoneValidCode() {
    var phone_num = $("#phone-num").val();

    if (!phone_num || phone_num.length != 11) {
        alert("请输入正确手机号码!");

        return;
    }

    getPhoneValid(phone_num, setPhoneCode);
}

function validPhoneCode() {
    var tmp_1 = $("#phone-code").val();
    var tmp_2 = $("#phone-num").attr("code");

    if (tmp_1 != tmp_2) {
        alert("验证码输入错误!");

        return;
    }

    $("#customer-phone").html($("#phone-num").val());
}

//----------选择日期和时间段-----------------------------------------------------

function initWeek() {
    var date = new Date();
    var week_html = "";

    for (var i = 0; i < 7; i++) {
        var year = date.getFullYear();
        var month = date.getMonth() + 1;
        var day = date.getDate();
        var  full_date = year + "-" + singleDateCheck(month) + "-" + singleDateCheck(day);

        //if (week_html == "") {
        //    week_html = week_html + '<div class="td week-td selected" val="'+ full_date +'">'+ month +'月'+ day +'日</div>';
        //    //给提交的选择日期赋初值
        //    $("#select_date").val(full_date);
        //}
        //else {
            week_html = week_html + '<div class="td  week-td" val="'+ full_date +'">'+ month +'月'+ day +'日</div>';
        //}


        date.setDate(date.getDate() + 1);
    }

    $(".time-day-select").find(".table").html(week_html);
}

function timeChoose(time) {
    var val = $(time).attr("val");
    var selected_time = $("#time-panel").find(".selected");

    if (selected_time.length == 0) {
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
        $("#show-view-time").val("");
        $("#time_range").val("");
        $("#hour").html("0");
        $("#amount").html("0");
        $("#pay-amount").html("0");
    }
    else {
        if (selected_time.length == 1) {
            var first_html = $(selected_time[0]).html();
            var first_time = $(selected_time[0]).attr("val");
            var last_time = $(selected_time[selected_time.length - 1]).attr("val");

            var date = $(".time-day-select").find(".table").find(".selected").html();

            $("#show-view-time").html(date +" "+ first_html);
            $("#time_range").val(first_html + "|" + first_time);
            $("#hour").html("1");
            $("#amount").html(order_price);
            $("#pay-amount").html(order_price - 200);
        }
        else if (selected_time.length > 1) {
            var first_html = $(selected_time[0]).html();
            var last_html = $(selected_time[selected_time.length - 1]).html();
            var first_time = $(selected_time[0]).attr("val");
            var last_time = $(selected_time[selected_time.length - 1]).attr("val");

            var date = $(".time-day-select").find(".table").find(".selected").html();

            $("#show-view-time").html(date +" "+ first_html +" - "+ last_html);
            $("#time_range").val(first_html +" - "+ last_html + "|" + first_time +"-"+last_time);

            var hour = parseInt(last_time) - parseInt(first_time) + 1;

            $("#hour").html(hour);
            $("#amount").html(order_price * hour);
            $("#pay-amount").html(order_price * hour - 200);
        }

        $("#select-timespan").show();
    }
}

function checkTime(use_times, time) {
    var first_time = parseInt($(use_times[0]).attr("val"));
    var last_time = parseInt($(use_times[use_times.length - 1]).attr("val"));
    var tmp_time = parseInt($(time).attr("val"));

    if (first_time - 1 == tmp_time || last_time + 1 == tmp_time) {
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
    location.href = "/pay/success/"+ order_id;
}

function submitOrder() {
    var order = new Order();

    var customer_name = $("#customer_name").val();
    var phone = $("#customer-phone").html();
    var address = $("#address-view").html();
    var rundate = $("#select_date").val();
    var hour = $("#hour").html();
    var time = $("#time_range").val();
    var amount = $("#amount").html();
    var pay_amount = $("#pay-amount").html();

    order.confrim(rundate, time, hour, amount, pay_amount, address, phone, customer_name, address, phone, toPay);
}




