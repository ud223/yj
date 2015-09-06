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