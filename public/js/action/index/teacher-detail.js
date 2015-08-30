function initWeek() {
    var date = new Date();

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

        if (week_html == "") {
            week_html = week_html + '<div class="td week-td selected" val="'+ full_date +'">'+ month +'月'+ day +'日</div>';
            //给提交的选择日期赋初值
            $("#select_date").val(full_date);
        }
        else {
            week_html = week_html + '<div class="td  week-td" val="'+ full_date +'">'+ month +'月'+ day +'日</div>';
        }


        date.setDate(date.getDate() + 1);
    }

    $(".time-day-select").find(".table").html(week_html);

    var order = new Order();

    order.getByDay(teacher_id, today, setUseTime);
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

    selected_time = $("#time-panel").find(".selected");

    if (selected_time.length == 0) {
        $("#show-view-time").val("");
        $("#time_range").val("");
    }
    else {
        if (selected_time.length == 1) {
            var first_html = $(selected_time[0]).html();
            var first_time = $(selected_time[0]).attr("val");
            var last_time = $(selected_time[selected_time.length - 1]).attr("val");

            var date = $(".time-day-select").find(".table").find(".selected").html();

            $("#show-view-time").html(date +" "+ first_html);
            $("#time_range").val(first_html + "|" + first_time);
        }
        else if (selected_time.length > 1) {
            var first_html = $(selected_time[0]).html();
            var last_html = $(selected_time[selected_time.length - 1]).html();
            var first_time = $(selected_time[0]).attr("val");
            var last_time = $(selected_time[selected_time.length - 1]).attr("val");

            var date = $(".time-day-select").find(".table").find(".selected").html();

            $("#show-view-time").html(date +" "+ first_html +" - "+ last_html);
            $("#time_range").val(first_html +" - "+ last_html + "|" + first_time +"-"+last_time);
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

function chooseDay(week) {
    if ($(week).hasClass("selected")) {
        return;
    }

    $(".time-day-select").find(".table").find(".selected").removeClass("selected");

    $(week).addClass("selected");
    $(".time-space").removeClass("selected");
    $(".time-space").removeClass("unclickable");
    $("#select_date").val($(week).attr("val"));
    $("#show-view-time").html(dateToMonthAndDay($(week).attr("val")))

    var order = new Order();

    order.getByDay(teacher_id, $(week).attr("val"), setUseTime);
}

function setUseTime(response) {
    var tmp_now = new Date();

    $.each(response.data, function() {
        var tmp_time = this.time.split("|")[1];
        var time_value = tmp_time.split("-");
        var list = $("#time-panel").find(".time-space");
        var tmp_date_time_1 = this.created_date;
        var tmp_date_time_2 = this.updated_at;

        if (this.state > 10) {
            $.each(list, function() {
                var value = parseInt($(this).attr("val"));

                if (value + 1 == time_value[0] || value - 1 == time_value[1]) {
                    $(this).addClass("unclickable")
                }

                if (value >= time_value[0] && value <= time_value[1]) {
                    $(this).addClass("unclickable")
                }
            })
        }
        else {
            if (tmp_date_time_2) {
                var t_time = new Date(tmp_date_time_2);

                alert(tmp_now - t_time);
            }
            else {
                var t_time = new Date(tmp_date_time_1);

                alert(tmp_now - t_time);
            }
        }
    });
}

function submitOrder() {
    var order = new Order();
    //获取提交参数
    var customer_id = localStorage.getItem('user_id');

    var rundate = $("#select_date").val();
    var hour = $("#time_range").val();
    var price = $("#price").val();

    order.add(customer_id, teacher_id, rundate, hour, price, addOrderSuccess);
}

function addOrderSuccess(response) {
    location.href = "/confirmation/order/"+ response.data;
}

