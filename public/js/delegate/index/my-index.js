function setNameClick() {
    $("#btn-accept-name").tapA(function() {
        saveName();
    })
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

function setDescriptionClick() {
    $("#send-description").tapA(function() {
        saveDescription();
    })
}

function setYearsClick() {
    $("#send-years").tapA(function() {
        saveYears();
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

function addrClick(node) {
    $(node).tapA(function() {
        chooseAddr($(this).find(".t1").html(), $(this).find(".t1").attr("lat"), $(this).find(".t1").attr("lng"));
    })
}

function saveRangeClick() {
    $("#submit-range").tapA(function() {
        saveRange();
    })
}