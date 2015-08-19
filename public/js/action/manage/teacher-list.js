function searchTeacher() {
    var name = $("#wx-name").val();

    location.href = "/manage/teacher/list/"+ name +"/1";
}
