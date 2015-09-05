function submitOrderScore() {
    var time_score = 5 - $("#time-score").find(".empty").length;
    var content_score = 5 - $("#content-score").find(".empty").length;
    var way_score = 5 - $("#way-score").find(".empty").length;
    var teacher_appraise = $("#teacher-appraise").val();

    submitScore(order_id, time_score, content_score, way_score, teacher_appraise, submitOrderScoreSuccess);
}

function submitOrderScoreSuccess(order_id) {
    location.href = "/rating/success/"+ order_id;
}