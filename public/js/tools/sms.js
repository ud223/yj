function getPhoneValid(phone, fun) {
    var url = "/api/sms/valid";

    var  data = { 'phone':phone }

    $.ajax({
        url: url,
        dataType: 'JSON',
        data: data,
        method: 'post',
        success: function (response) {
            //alert(JSON.stringify(response)); return;
            if (response.code == 200) {
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