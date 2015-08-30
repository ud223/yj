function addrClick(node) {
    $(node).tap(function() {
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
    $("#apply-addr").tap(function() {
        applyAddress();
    });
}

function phoneValidClick() {
    $("#send-code").tap(function() {
        getPhoneValidCode();
    });
}

function validPhoneCodeClick() {
    $("#valid-phone-code").tap(function() {
        validPhoneCode();
    });
}

function chooseDay() {
    $(".time-day-select").find(".week-td").tap(function() {
        if ($(this).hasClass("selected")) {
            return;
        }

        $(".time-day-select").find(".table").find(".selected").removeClass("selected");

        $(this).addClass("selected");

        $(".time-space").removeClass("selected");

        $("#select_date").val($(this).attr("val"));
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

function acceptTimeClick() {
    $("#btn-accept-time").tap(function() {
        acceptTime();
    })
}