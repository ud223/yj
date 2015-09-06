function chooseDayClick() {
    $(".time-day-select").find(".week-td").tap(function() {
        var date = $(this).attr("val");

        getTeacherBusy(teacher_id, date, this, chooseDay, busyDay);
        //chooseDay(this);
    });
}

function initTimeClick() {
    $(".time-space").tap(function() {
        if ($(this).hasClass("unclickable")) {
            $.toastMsg("该时间段已有预约!", 3000);

            return ;
        }

        timeChoose(this);
    });
}

function initSubmitOrder() {
    $("#submit-order").tap(function() {
        var user_id = localStorage.getItem('user_id');

        if (user_id) {
            submitOrder();
        }
        else {
            userLogin();
        }
    });
}