$(document).ready(function() {
    initUser();

    initControls();

    initInput();

    initBtn();

    loadData();
});

function initBtn() {
    regionClick();

    sortClick();
}

function initInput() {

}

function loadData() {
    load();
}

function initControls() {

}

//初始化测试数据
function initUser() {
    var regions = $(".tcfilter-filter").find(".itmbtn");

    $(regions[6]).addClass("selected");
//55caf092d53de42d048b456c
    localStorage.setItem('user_id', '55d53896d53de421048b456f');//55ced8b3d53de429048b456b//55e307d17406f725038b4679

    var user_id = localStorage.getItem('user_id')

    $("#to-me").attr("hottap", "/me/" + user_id);
}
