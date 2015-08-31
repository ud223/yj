function joinLesson(teacher_id, lesson_id, opt,  fun) {
    var url = '/api/lesson/join';

    var  data = { 'teacher_id':teacher_id, 'lesson_id': lesson_id, 'opt': opt }
    //alert(JSON.stringify(data)); //return;
    $.ajax({
        url: url,
        dataType: 'json',
        data: data,
        method: 'post',
        success: function (response) {
            //alert(JSON.stringify(response)); //return;
            if (response.code == 200) {
                alert(response.data);
                if (fun) {
                    fun(opt, lesson_id);
                }
            }
            else {
                alert(response.data);
            }
        },
        error: function () {

        }
    });
}