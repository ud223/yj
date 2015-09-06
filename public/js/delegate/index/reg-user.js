function setNameClick() {
    $("#btn-accept-name").tap(function() {
        saveName();
    })
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

function setDescriptionClick() {
    $("#valid-description-code").tap(function() {
        saveDescription();
    })
}