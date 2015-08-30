function initWeek() {
    var date = new Date();

    var t_year = date.getFullYear();
    var t_month = date.getMonth() + 1;
    var t_day = date.getDate();

    var today = t_year + "-" + singleDateCheck(t_month) + "-" + singleDateCheck(t_day);
    var week_html = '<div class="row">';

    date.setDate(date.getDate() + 1);

    $("#week-day").html("");

    for (var i = 0; i < 14; i++) {
        if (i == 7) {
            week_html = week_html + '</div> <div class="row">';
        }

        var year = date.getFullYear();
        var month = date.getMonth() + 1;
        var day = date.getDate();
        var full_date = year + "-" + singleDateCheck(month) + "-" + singleDateCheck(day);
        var week_day = date.getDay();
        var week_text = "";

        switch (week_day) {
            case 1 :{
                week_text = "MON";
                break;
            }
            case 2 :{
                week_text = "TUE";
                break;
            }
            case 3 :{
                week_text = "WED";
                break;
            }
            case 4 :{
                week_text = "THU";
                break;
            }
            case 5 :{
                week_text = "FRI";
                break;
            }
            case 6 :{
                week_text = "SAT";
                break;
            }
            default :{
                week_text = "SUN";
                break;
            }
        }

        week_html = week_html + '<div class="td" val="'+ full_date +'"><div class="t1">'+ week_text +'</div> <div class="t2">'+ day +'</div> <div class="frm"></div> </div>';

        date.setDate(date.getDate() + 1);
    }

    week_html = week_html + '</div> ';

    $("#week-day").html(week_html);
}

function getBusy() {
    getBusyOpt(teacher_id, updateCalendarCss);
}

function updateCalendarCss(response) {
    $("#week-day").removeClass(".unselectable");
    $("#week-day").removeClass(".selected");

    var week_days = $("#week-day").find('.td');

    $.each(response.data, function() {
        var tmp_busy = this.busy_date;

        $.each(week_days, function() {
            if (tmp_busy == $(this).attr("val")) {
                $(this).addClass("unselectable");
            }
        })
    })
}

function setDay(opt) {
    var choose_days = $("#week-day").find(".selected");
    var dates = "";

    if (choose_days.length == 0)
        return;

    //这里后面改循环提交为一次性提交
    for (var i = 0; i < choose_days.length; i++) {
        var date = $(choose_days[i]).attr("val");

        if (opt == 1 && !$(choose_days[i]).hasClass("unselectable")) {
            if (dates != "") {
                dates = dates + ",";
            }

            dates = dates + date;
        }
        else if (opt == 0 && $(choose_days[i]).hasClass("unselectable")) {
            if (dates != "") {
                dates = dates + ",";
            }

            dates = dates + date;
        }
    }

    setDayOpt(teacher_id, dates, opt, getBusy)
}

