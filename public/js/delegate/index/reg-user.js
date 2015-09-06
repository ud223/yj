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

function saveCodeClick() {
    $("#valid-code-code").tapA(function() {
        saveCode();
    })
}

function submitRegClick() {
    $("#submit-reg").tapA(function() {
        saveCode();
    })
}