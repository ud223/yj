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
    toOrderClick();
}

function initInput() {

}

function loadData() {

}

function initControls() {

}

//初始化测试数据
function initUser() {
    resetBottomBar(usertype, 'to-home');
}
