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

    //var regions = $(".tcfilter-filter").find(".itmbtn");
    //
    //$(regions[1]).addClass("selected");
    //55f3d0607406f74f758b4624 滕燕
    //55f29c427406f750758b45db	彭彩红
    //56049fad7406f7536f8b45fb 傅丽君
    //5604a6677406f7007f8b4568	温利华
    //55f682737406f74f758b4646	刘郎平
    //55ed73fc7406f7ac7f8b4567 戴炳锋
//服务器测试：55ebe5c67406f7ba678b4573
//测试用:55caf092d53de42d048b456c//55ced8b3d53de429048b456b//55f2d8bfd53de415048b4569
//    localStorage.setItem('user_id', '55caf092d53de42d048b456c');
}
