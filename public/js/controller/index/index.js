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
}

//初始化测试数据
function initUser() {
    lat = "30.646992";
    lng = "114.308168";
    alert(0);
    getLocal(load);

    //var regions = $(".tcfilter-filter").find(".itmbtn");
    //
    //$(regions[1]).addClass("selected");
//服务器测试：55ebe5c67406f7ba678b4573
//测试用:55caf092d53de42d048b456c//55ced8b3d53de429048b456b//55f2d8bfd53de415048b4569
    localStorage.setItem('user_id', '55ebe5c67406f7ba678b4573');
}
