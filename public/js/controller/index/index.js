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

    toMeClick();

    toTeachClick();

    toOrderClick();

    editTeacherName();
}

function initInput() {

}

function loadData() {
    //load();
}

function initControls() {
    editAddressName();

    getLocClick();
}

//初始化测试数据
function initUser() {
    //clearPos();
    //lat = "22.745052";
    //lng = "113.803324";

    if (!loadCell())
        getLocal(load);


    resetBottomBar(usertype, 'teacher-date');
}
