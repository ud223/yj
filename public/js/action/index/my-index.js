function saveName() {
    var model = "teacher";
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

    //$("#pp-change-name").find('.cd-slidepopupback').tap();

    closePopup($("#pp-change-name").find('.cd-slidepopupback'));
}

//-----------------------手机短信验证------------------------------------------

var countdown=60;
var is_count = false;

function settime(val) {
    if (!is_count)
        return;

    if (countdown == 0) {
        $(val).removeAttr("disabled");
        $(val).html("发送验证码");
        countdown = 60;
        is_count = false
    } else {
        $(val).attr("disabled", "true");
        $(val).html("重新发送(" + countdown + ")");
        countdown--;
    }
    setTimeout(function() { settime(val) },1000)
}

function setPhoneCode(response) {
    $("#phone-num").attr("code", response.data);
}

function getPhoneValidCode() {
    if (is_count) {
        return;
    }

    var phone_num = $("#phone-num").val();

    if (!phone_num || phone_num.length != 11) {
        $.toastMsg("请输入正确手机号码!", 3000);

        return;
    }

    is_count = true;
    settime(document.getElementById("send-code"));

    getPhoneValid(phone_num, setPhoneCode);
}

function validPhoneCode() {
    var tmp_1 = $("#phone-code").val();
    var tmp_2 = $("#phone-num").attr("code");

    if (tmp_1 != tmp_2) {
        $.toastMsg("验证码输入错误!", 3000);

        return;
    }

    $("#customer-phone").html($("#phone-num").val());

    var model = "teacher";
    var key = "phone";
    var value = $("#phone-num").val();

    modifyValie(user_id, model, key, value, null);

    //$("#pp-change-tel").find('.cd-slidepopupback').tap();
    closePopup($("#pp-change-tel").find('.cd-slidepopupback'));
}

//修改个人备注
function saveDescription() {
    var model = "teacher";
    var key = "description";
    var value = $("#edit-description").val();

    modifyValie(user_id, model, key, value, setDescription);
}

function setDescription(response) {
    //$("#my-description").html(response.data)

    if (response.data.length > 20) {
        $("#my-description").html(response.data.substr(0, 19) + "...");
    }
    else {
        $("#my-description").html(response.data);
    }

    //$("#pp-my-intro").find('.cd-slidepopupback').tap();

    closePopup($("#pp-my-intro").find('.cd-slidepopupback'));
}

//修改个人练习年份
function saveYears() {
    var model = "teacher";
    var key = "years";
    var value = $("#edit-years").val();

    modifyValie(user_id, model, key, value, setYears);
}

function setYears(response) {
    $("#my-years").html(response.data)

    //$("#pp-change-years").find('.cd-slidepopupback').tap();

    closePopup($("#pp-change-years").find('.cd-slidepopupback'));
}
