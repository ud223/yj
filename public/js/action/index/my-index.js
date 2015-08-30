function saveName() {
    var model = "teacher";
    var key = "name";
    var value = $("#user-name").val();

    if (!value) {
        alert("姓名不能为空!");

        return;
    }

    modifyValie(user_id, model, key, value, setName);
}

function setName(response) {
    $("#my-name").html(response.data)
}

//-----------------------手机短信验证------------------------------------------

function setPhoneCode(response) {
    $("#phone-num").attr("code", response.data);
}

function getPhoneValidCode() {
    var phone_num = $("#phone-num").val();

    if (!phone_num || phone_num.length != 11) {
        alert("请输入正确手机号码!");

        return;
    }

    getPhoneValid(phone_num, setPhoneCode);
}

function validPhoneCode() {
    var tmp_1 = $("#phone-code").val();
    var tmp_2 = $("#phone-num").attr("code");

    if (tmp_1 != tmp_2) {
        alert("验证码输入错误!");

        return;
    }

    $("#customer-phone").html($("#phone-num").val());

    var model = "teacher";
    var key = "phone";
    var value = $("#phone-num").val();

    modifyValie(user_id, model, key, value, null);
}

//修改个人备注
function saveDescription() {
    var model = "teacher";
    var key = "description";
    var value = $("#edit-description").val();

    modifyValie(user_id, model, key, value, setDescription);
}

function setDescription(response) {
    $("#my-description").html(response.data)
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
}
