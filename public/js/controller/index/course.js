$(document).ready(function() {
    initUser();

    initControls();

    initInput();

    initBtn();

    loadData();
});

function initBtn() {
    toMeClick();

    toTeachClick();
}

function initInput() {

}

function loadData() {

}

function initControls() {

}

//初始化测试数据
function initUser() {
    //var regions = $(".tcfilter-filter").find(".itmbtn");
    //
    //$(regions[6]).addClass("selected");

    //if (user_id) {
    //    $("#to-me").attr("hottap", "/me/" + user_id);
    //    $("#to-teach").attr("hottap", "/my/teach/" + user_id);
    //}


    if (usertype == 2) {
        $("#to-teach").show();
        $("#teacher-date").addClass("grid3");
        $("#to-me").addClass("grid3");
    }
    else {
        $("#to-teach").hide();
        $("#teacher-date").removeClass("grid3");
        $("#to-me").removeClass("grid3");
    }
}
