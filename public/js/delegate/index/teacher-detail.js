function chooseDayClick() {
    $(".time-day-select").find(".week-td").tap(function() {
        chooseDay(this);
    });
}

function initTimeClick() {
    $(".time-space").tap(function() {
        if ($(this).hasClass("unclickable")) {
            alert("该时间段已有预约!");

            return ;
        }

        timeChoose(this);
    });
}

function initSubmitOrder() {
    $("#submit-order").tap(function() {
        submitOrder();
    });
}