function setNameClick() {
    $("#btn-accept-name").tap(function() {
        alert(0);
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

function saveCodeClick() {
    $("#valid-code-code").tap(function() {
        saveCode();
    })
}