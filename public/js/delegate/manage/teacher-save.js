function initSkillAdd() {
    $("#btn-skill-add").click(function() {
        skillAddNode();
    });
}

function initSkillRemove() {
    $(".btn-skill-remove").click(function() {
        removeSkill($(this).parent());
    });
}

function initFormSubmit() {
    $('form').on('submit', function() {
        return initSubmit();
    });
}


function initBangCustomer() {
    $("#bang-customer").click(function() {
        var name = $("#wx-name").val();

        loadCustomerList(1, name);
    });
}

function initHeadPic() {
    var fileInput = document.getElementById('upload-head-pic');

    fileInput.onchange = function() {
        var file = fileInput.files[0];

        ImageOpt(file, 'pre-image');
    };
}

function initCertificatePic() {
    var fileInput = document.getElementById('upload-certificate-pic');

    fileInput.onchange = function() {
        var file = fileInput.files[0];

        ImageOpt(file, 'pre-certificate-image');
    };
}