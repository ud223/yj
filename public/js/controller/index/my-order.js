$(document).ready(function() {
    initUser();


    toMeClick();

    toTeachClick();

    toOrderClick();

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
    var user_id = localStorage.getItem('user_id')
    resetBottomBar(usertype, 'to-order');
}
