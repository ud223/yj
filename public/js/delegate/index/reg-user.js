function setNameClick() {
    $("#btn-accept-name").tap(function() {
        saveName();
    })
}

function phoneValidClick() {
    $("#send-code").tap(function() {
        alert(0);
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