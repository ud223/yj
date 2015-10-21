function toMeClick() {
    $("#to-me").click(function() {
        var user_id = localStorage.getItem('user_id');
        //alert(user_id);
        if (user_id) {
            location.href = "/me/"+ user_id;
        }
        else {
            userLogin();
        }
    });
}

function toTeachClick() {
    $("#to-teach").click(function() {
        var user_id = localStorage.getItem('user_id');
        //alert(user_id);
        if (user_id) {
            location.href = "/my/teach/"+ user_id;
        }
        else {
            userLogin();
        }
    });
}