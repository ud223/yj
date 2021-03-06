function chooseDayClick() {
    $(".time-day-select").find(".week-td").tapA(function() {
        var date = $(this).attr("val");

        getTeacherBusy(teacher_id, date, this, chooseDay, busyDay);
        //chooseDay(this);
    });
}

function initTimeClick() {
    $(".time-space").tapA(function() {
        if ($(this).hasClass("unclickable")) {
            $.toastMsg("该时间段已有预约!", 1500);

            return ;
        }

        timeChoose(this);
    });
}

function initSubmitOrder() {
    $("#submit-order").tapA(function() {
        if ($(this).html() == "不在服务区") {
            return ;
        }

        var user_id = localStorage.getItem('user_id');

        if (user_id) {
            submitOrder();
        }
        else {
            userLogin();
        }
    });
}

function toChooseTimeClick() {
    $(".rtselectedtime").find(".t2").tapA(function() {
        var url = location.href;

        location.href = "#teacher-time";
    })
}

function back() {
    if (document.referrer) {
        window.history.back();
    }
    else {
        location.href = "/";
    }
}