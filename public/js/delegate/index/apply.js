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

function saveSexClick() {
    $("#valid-sex-code").tap(function() {
        saveSex();
    })
}

function saveBirthdayClick() {
    $("#valid-birthday-code").tap(function() {
        saveBirthday();
    })
}

function savePlaceClick() {
    $("#valid-place-code").tap(function() {
        savePlace();
    })
}

function saveEducationalClick() {
    $("#valid-educational-code").tap(function() {
        saveEducational();
    })
}

function saveCodeClick() {
    $("#valid-code-code").tapA(function() {
        saveCode();
    })
}

function saveEmailClick() {
    $("#valid-email-code").tapA(function() {
        saveEmail();
    })
}

function saveQQClick() {
    $("#valid-qq-code").tapA(function() {
        saveQQ();
    })
}

function saveWeChatClick() {
    $("#valid-wechat-code").tapA(function() {
        saveWeChat();
    })
}

function saveLocationClick() {
    $("#valid-location-code").tapA(function() {
        saveLocation();
    })
}

function saveRegionClick() {
    $("#valid-region-code").tapA(function() {
        saveRegion();
    })
}

function saveCategoryClick() {
    $("#valid-category-code").tapA(function() {
        saveCategory();
    })
}

function saveBankClick() {
    $("#valid-bank-code").tapA(function() {
        saveBank();
    })
}

function saveBankCodeClick() {
    $("#valid-bank_code-code").tapA(function() {
        saveBankCode();
    })
}



function setDescriptionClick() {
    $("#valid-description-code").tapA(function() {
        saveDescription();
    })
}

function submitRegClick() {
    $("#submit-reg").tapA(function() {
        submitReg();
    })
}

function applyClick() {
    $("#submit-apply").tapA(function() {
        submitApply();
    })
}

function deleteCertificateClick() {
    $(".certificate_del").tapA(function() {
        deleteCertificate($(this).attr("for"));
    })
}

function deletePhotoClick() {
    $(".photo_del").tapA(function() {
        deletePhoto($(this).attr("for"));
    })
}

function certificateUpClick() {
    $(".certificate_up").tapA(function() {
        certificateUp($(this).attr("for"));
    })
}

function certificateDownClick() {
    $(".certificate_down").tapA(function() {
        certificateDown($(this).attr("for"));
    })
}

function photoUpClick() {
    $(".photo_up").tapA(function() {
        photoUp($(this).attr("for"));
    })
}

function photoDownClick() {
    $(".photo_down").tapA(function() {
        photoDown($(this).attr("for"));
    })
}