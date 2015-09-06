function saveName() {
    var model = "customer";
    var key = "name";
    var value = $("#user-name").val();

    if (!value) {
        $.toastMsg("姓名不能为空!", 3000);

        return;
    }

    modifyValie(user_id, model, key, value, setName);
}

function setName(response) {
    $("#my-name").html(response.data)

    $("#pp-change-name").find('.cd-slidepopupback').tap();
}

//-----------------------手机短信验证------------------------------------------

function setPhoneCode(response) {
    $("#phone-num").attr("code", response.data);
}

function getPhoneValidCode() {
    var phone_num = $("#phone-num").val();

    if (!phone_num || phone_num.length != 11) {
        $.toastMsg("请输入正确手机号码!", 3000);

        return;
    }
    alert(2);
    getPhoneValid(phone_num, setPhoneCode);
}

function validPhoneCode() {
    alert(3);
    var tmp_1 = $("#phone-code").val();
    var tmp_2 = $("#phone-num").attr("code");

    if (tmp_1 != tmp_2) {
        $.toastMsg("验证码输入错误!", 3000);

        return;
    }
    alert(4);
    $("#my-phone").html($("#phone-num").val());

    var model = "customer";
    var key = "phone";
    var value = $("#phone-num").val();
    alert(5);
    modifyValie(user_id, model, key, value, null);

    $("#pp-change-tel").find('.cd-slidepopupback').tap();
}

//---------------------设置个人介绍------------------------
function saveDescription() {
    var model = "customer";
    var key = "description";

    var value = $('#description').val();

    modifyValie(user_id, model, key, value, setDescription);
}

function setDescription(response) {
    $("#my-description").html(response.data);

    $("#pp-change-description").find('.cd-slidepopupback').tap();
}

//------------设置身份证------------------------------------------
function saveCode() {
    var model = "customer";
    var key = "code";
    var value = $('#code').val();

    if (!value) {
        $.toastMsg("身份证不能为空!", 3000);

        return;
    }

    if (value.length != 15 && value.length != 18) {
        $.toastMsg("身份证格式错误!", 3000);

        return;
    }

    modifyValie(user_id, model, key, value, setCode);
}

function setCode(response) {
    $("#my-code").html(response.data);

    $("#pp-change-code").find('.cd-slidepopupback').tap();
}
