function addrClick(node) {
    $(node).tapA(function() {
        chooseAddr($(this).find(".t1").html());
    })
}

function editAddressName() {
    $("#btn-addr-query").tap(function() {
        if ($("#edit-addr").val() == "") {
            return;
        }

        getAddressByAddressName($("#edit-addr").val(), setAddressList);
    });
}

function applyAddrClick() {
    $("#apply-addr").tapA(function() {
        applyAddress();
    });
}

function applyAddrDetailClick() {
    $("#valid-addr-detail-code").tapA(function() {
        applyAddressDetail();
    });
}

function phoneValidClick() {
    $("#send-code").tapA(function() {
        getPhoneValidCode();
    });
}

function validPhoneCodeClick() {
    $("#valid-phone-code").tapA(function() {
        validPhoneCode();
    });
}

function chooseDayClick() {
    //$(".time-day-select").find(".week-td").tap(function() {
    //    if ($(this).hasClass("selected")) {
    //        return;
    //    }
    //
    //    $(".time-day-select").find(".table").find(".selected").removeClass("selected");
    //
    //    $(this).addClass("selected");
    //
    //    $(".time-space").removeClass("selected");
    //
    //    $("#select_date").val($(this).attr("val"));
    //});

    $(".time-day-select").find(".week-td").tapA(function() {
        var date = $(this).attr("val");

        getTeacherBusy(teacher_id, date, this, chooseDay, busyDay);
        //chooseDay(this);
    });
}

function initTimeClick() {
    $(".time-space").tapA(function() {
        if ($(this).hasClass("unclickable")) {
            $.toastMsg("该时间段已有预约!", 3000);

            return ;
        }

        timeChoose(this);
    });
}

function initSubmitOrder() {
    $("#submit-order").tapA(function() {
        submitOrder();
    });
}

function acceptTimeClick() {
    $("#btn-accept-time").tapA(function() {
        acceptTime();
    })
}