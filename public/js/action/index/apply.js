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

    //$("#pp-change-name").find('.cd-slidepopupback').tapA();
    //$('.cd-slidepopupback').tapA();

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

    //return;

    getPhoneValid(phone_num, setPhoneCode);
}

function validPhoneCode() {
    var tmp_1 = $("#phone-code").val();
    var tmp_2 = $("#phone-num").attr("code");

    if (tmp_1 != tmp_2) {
        $.toastMsg("验证码输入错误!", 3000);

        return;
    }

    $("#my-phone").html($("#phone-num").val());

    var model = "customer";
    var key = "phone";
    var value = $("#phone-num").val();

    modifyValie(user_id, model, key, value, null);

    //$("#pp-change-tel").find('.cd-slidepopupback').tapA();

    closePopup($("#pp-change-tel").find('.cd-slidepopupback'));
}
//------------设置性别------------------------------------------

function saveSex() {
    var model = "customer";
    var key = "sex";
    var value = $('#pp-change-sex input[name="sex"]:checked ').val();

    modifyValie(user_id, model, key, value, setSex);
}

function setSex(response) {
    var sex_text = "男";

    if (response.data != 1) {
        sex_text = "女";
    }

    $("#my-sex").html(sex_text)

    //$("#pp-change-sex").find('.cd-slidepopupback').tapA();

    closePopup($("#pp-change-sex").find('.cd-slidepopupback'));
}

//------------设置出生日期------------------------------------------
function saveBirthday() {
    var model = "customer";
    var key = "birthday";
    var value = $('#birthday').val();

    if (!value) {
        $.toastMsg("出生年月不能为空!", 3000);

        return;
    }

    modifyValie(user_id, model, key, value, setBirthday);
}

function setBirthday(response) {
    var tmp_date = response.data.split("-");
    var tmp_month = "";
    var tmp_day = "";
    if (String(tmp_date[1]).substr(0, 1) == "0") {
        tmp_month = String(tmp_date[1]).substr(1, 1);
    }
    else {
        tmp_month = tmp_date[1];
    }

    if (String(tmp_date[2]).substr(0, 1) == "0") {
        tmp_day = String(tmp_date[2]).substr(1, 1);
    }
    else {
        tmp_day = tmp_date[2];
    }

    $("#my-birthday").html(tmp_date[0] + "年" + tmp_month +"月"+ tmp_day +"日");

    //$("#pp-change-birthday").find('.cd-slidepopupback').tapA();

    closePopup($("#pp-change-birthday").find('.cd-slidepopupback'));
}

//------------设置籍贯------------------------------------------
function savePlace() {
    var model = "customer";
    var key = "place";
    var value = $('#place').val();

    modifyValie(user_id, model, key, value, setPlace);
}

function setPlace(response) {
    $("#my-place").html(response.data);

    //$("#pp-change-place").find('.cd-slidepopupback').tapA();

    closePopup($("#pp-change-place").find('.cd-slidepopupback'));
}

//------------设置学历------------------------------------------
function saveEducational() {
    var model = "customer";
    var key = "educational";
    var value = $('#educational').val();

    if (value == "0") {
        $.toastMsg("请选择学历程度!", 3000);

        return;
    }

    modifyValie(user_id, model, key, value, setEducational);
}

function setEducational(response) {
    $("#my-educational").html(response.data);

    //$("#pp-change-educational").find('.cd-slidepopupback').tapA();

    closePopup($("#pp-change-educational").find('.cd-slidepopupback'));
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

    //$("#pp-change-code").find('.cd-slidepopupback').tapA();

    closePopup($("#pp-change-code").find('.cd-slidepopupback'));
}

//-----------设置邮箱------------------------------
function saveEmail() {
    var model = "customer";
    var key = "email";
    var value = $('#email').val();

    if (!value) {
        $.toastMsg("电子邮箱不能为空!", 3000);

        return;
    }

    modifyValie(user_id, model, key, value, seEmail);
}

function seEmail(response) {
    $("#my-email").html(response.data);

    //$("#pp-change-email").find('.cd-slidepopupback').tapA();

    closePopup($("#pp-change-email").find('.cd-slidepopupback'));
}

//-----------设置qq------------------------------
function saveQQ() {
    var model = "customer";
    var key = "qq";
    var value = $('#qq').val();

    modifyValie(user_id, model, key, value, setQQ);
}

function setQQ(response) {
    $("#my-qq").html(response.data);

    //$("#pp-change-qq").find('.cd-slidepopupback').tapA();

    closePopup($("#pp-change-qq").find('.cd-slidepopupback'));
}

//-----------设置微信------------------------------
function saveWeChat() {
    var model = "customer";
    var key = "wechat";
    var value = $('#wechat').val();

    modifyValie(user_id, model, key, value, setWeChat);
}

function setWeChat(response) {
    $("#my-wechat").html(response.data);

    //$("#pp-change-wechat").find('.cd-slidepopupback').tapA();

    closePopup($("#pp-change-wechat").find('.cd-slidepopupback'));
}

//-----------设置所在城市------------------------------
function saveLocation() {
    var model = "customer";
    var key = "location";
    var value = $('#location').val();

    modifyValie(user_id, model, key, value, setLocation);
}

function setLocation(response) {
    $("#my-location").html(response.data);

    //$("#pp-change-location").find('.cd-slidepopupback').tapA();

    closePopup($("#pp-change-location").find('.cd-slidepopupback'));
}

//---------------------设置授课区域------------------------
function saveRegion() {
    var model = "customer";
    var key = "region";

    var value = '';

    $('#pp-change-region input[name="region"]:checked ').each(function(){
        value += this.value + ',';
    });

    value = value.substring(0,value.length-1);

    modifyValie(user_id, model, key, value, setRegion);
}

function setRegion(response) {
    if (response.data.length > 26) {
        $("#my-region").html(response.data.substr(0, 25) + "...");
    }
    else {
        $("#my-region").html(response.data);
    }

    //$("#pp-change-region").find('.cd-slidepopupback').tapA();

    closePopup($("#pp-change-region").find('.cd-slidepopupback'));
}

//---------------------设置授课类别------------------------
function saveCategory() {
    var model = "customer";
    var key = "category";

    var value = '';

    $('#pp-change-category input[name="category"]:checked ').each(function(){
        value += this.value + ',';
    });

    value = value.substring(0,value.length-1);

    modifyValie(user_id, model, key, value, setCategory);
}

function setCategory(response) {
    if (response.data.length > 20) {
        $("#my-category").html(response.data.substr(0, 19) + "...");
    }
    else {
        $("#my-category").html(response.data);
    }
    //$("#my-category").html(response.data);

    //$("#pp-change-category").find('.cd-slidepopupback').tapA();

    closePopup($("#pp-change-category").find('.cd-slidepopupback'));
}

//---------------------设置银行------------------------
function saveBank() {
    var model = "customer";
    var key = "bank";

    var value = $('#bank').val();

    if (value == "0") {
        $.toastMsg("请选择银行名称!", 3000);

        return;
    }

    modifyValie(user_id, model, key, value, setBank);
}

function setBank(response) {
    $("#my-bank").html(response.data);

    //$("#pp-change-bank").find('.cd-slidepopupback').tapA();

    closePopup($("#pp-change-bank").find('.cd-slidepopupback'));
}

//---------------------设置银行卡好------------------------
function saveBankCode() {
    var model = "customer";
    var key = "bank_code";

    var value = $('#bank_code').val();

    if (value == "0") {
        $.toastMsg("请输入银行卡号!", 3000);

        return;
    }

    modifyValie(user_id, model, key, value, setBankCode);
}

function setBankCode(response) {
    $("#my-bank_code").html(response.data);

    //$("#pp-change-bank_code").find('.cd-slidepopupback').tapA();

    closePopup($("#pp-change-bank_code").find('.cd-slidepopupback'));
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

    //$("#pp-change-description").find('.cd-slidepopupback').tapA();

    closePopup($("#pp-change-description").find('.cd-slidepopupback'));
}