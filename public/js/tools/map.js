//var lng = "114.081278";
//var lat = "22.531413";

var afterMethod = null;

function locationError(error){
    //if (afterMethod) {
    //    afterMethod();
    //}

    //getAddressByCoordinate(lng, lat, setAddressList);

    $("#address-view").html("定位中...");
}

function showPosition(data) {
    if(data.status!=0){
        alert("地图坐标转换出错");
        return ;
    }

    lng = data.result[0].x;
    lat = data.result[0].y;

    if (afterMethod) {
        afterMethod();
    }

    getAddressByCoordinate(lng, lat, setAddressList);
}

function locationSuccess(position) {
    var currentLat = position.coords.latitude;

    lat = currentLat;
    var currentLon = position.coords.longitude;
    lng = currentLon;

    if (afterMethod) {
        afterMethod();
    }

    var url = 'http://api.map.baidu.com/geoconv/v1/?coords='+currentLon+','+currentLat+'&from=1&to=5&ak=8TN0gC5Rqo6cec2jroKOkNpE&callback=showPosition';

    var script = document.createElement('script');

    script.src = url;

    document.getElementsByTagName("head")[0].appendChild(script);
}

function getLocal(fun) {
    afterMethod = fun;

    //手机使用代码
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(locationSuccess, locationError,{
            // 指示浏览器获取高精度的位置，默认为false
            enableHighAcuracy: true,
            // 指定获取地理位置的超时时间，默认不限时，单位为毫秒
            timeout: 2500,
            // 最长有效期，在重复获取地理位置时，此参数指定多久再次获取位置。
            maximumAge: 3000
        });
    }else{
        alert("Your browser does not support Geolocation!");
    }
}

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
                $.toastMsg("获取失败", 1500);
            }
        },
        error: function () {

        }
    });
}

function getAddressByAddressName(address_name, fun) {
   var url = "http://api.map.baidu.com/geocoder/v2/?ak=8TN0gC5Rqo6cec2jroKOkNpE&callback=renderOption&output=json&address="+ address_name +"&city=深圳市";

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
                $.toastMsg("没有找到对应信息,请输入完整地名!", 1500);
            }
        },
        error: function () {

        }
    });
}