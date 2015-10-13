$(document).ready(function() {
    initTest();

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
    //load();
}

function initControls() {

}

//初始化测试数据
function initTest() {
    //var regions = $(".tcfilter-filter").find(".itmbtn");
    //
    //$(regions[1]).addClass("selected");

    lat = "30.646992";
    lng = "114.308168";

    getLocal(load);

    //localStorage.setItem('user_id', '55d53896d53de421048b456f');//55ced8b3d53de429048b456b
    //
    //$("#to-me").attr("hottap", "/me/55d53896d53de421048b456f");
}
