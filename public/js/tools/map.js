function getAddressByCoordinate(lng, lat, fun) {
    var url = "http://api.map.baidu.com/geocoder/v2/?ak=8TN0gC5Rqo6cec2jroKOkNpE&callback=renderReverse&location="+ lat +","+ lng +"&output=json&pois=1";

    $.ajax({
        url: url,
        dataType: 'JSONP',
        method: 'post',
        success: function (response) {
            //alert(JSON.stringify(response)); return;
            if (response.status == 0) {
                if (fun) {
                    fun(response);
                }
            }
            else {
                alert("获取失败");
            }
        },
        error: function () {

        }
    });
}

function getAddressByAddressName(address_name, fun) {
   var url = "http://api.map.baidu.com/geocoder/v2/?ak=8TN0gC5Rqo6cec2jroKOkNpE&callback=renderOption&output=json&address="+ address_name +"&city=武汉市";

    $.ajax({
        url: url,
        dataType: 'JSONP',
        method: 'post',
        success: function (response) {
            //alert(JSON.stringify(response)); return;
            if (response.status == 0) {
                if (fun) {
                    getAddressByCoordinate(response.result.location.lng, response.result.location.lat, fun)
                }
            }
            else {
                alert("获取失败");
            }
        },
        error: function () {

        }
    });
}