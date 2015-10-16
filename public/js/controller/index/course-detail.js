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
    editAddressName();
}

//初始化测试数据
function initTest() {
    //clearPos();

    //lat = "30.646992";
    //lng = "114.308168";
    if (!loadCell())
        getLocal(load);
}
