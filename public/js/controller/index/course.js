$(document).ready(function() {
    initUser();

    initControls();

    initInput();

    initBtn();

    loadData();
});

function initBtn() {

}

function initInput() {

}

function loadData() {

}

function initControls() {

}

//初始化测试数据
function initUser() {
    var regions = $(".tcfilter-filter").find(".itmbtn");

    $(regions[6]).addClass("selected");

    var user_id = localStorage.getItem('user_id')

    $("#to-me").attr("hottap", "/me/" + user_id);
}
