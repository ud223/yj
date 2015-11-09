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
    //    接受条款才给按
    $("#submit-reg").tapA(function() {
        if($(this).hasClass('unuse')) {
            alert('注册前请阅读并遵守《瑜伽去学员服务协议》');
            return;
        } else {
            submitReg();
        }
    })
}