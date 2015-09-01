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