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

    $(regions[1]).addClass("selected");//服务器用:55e307d17406f725038b4679
<<<<<<< HEAD
//测试用:55caf092d53de42d048b456c//55ced8b3d53de429048b456b
    localStorage.setItem('user_id', '55ced8b3d53de429048b456b');
=======
//测试用:55caf092d53de42d048b456c   55e307d17406f725038b4679
    localStorage.setItem('user_id', '55caf092d53de42d048b456c');
>>>>>>> 7e09eae9e79efaf890e7eb2f51f50adc17dcbb15

    var user_id = localStorage.getItem('user_id')

    $("#to-me").attr("hottap", "/me/" + user_id);
}
