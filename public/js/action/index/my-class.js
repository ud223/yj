function chooseLesson(lesson) {
    $("#pal-name").html($(lesson).find(".lesson-name").html());
    $("#pal-content").html($(lesson).find(".lesson-description").html());
    $("#big-img").attr('src', '/photo/image/'+ $(lesson).attr("img"));
    $("#is-join-lesson").attr("val", $(lesson).attr("val"));

    var is_join = $(lesson).find(".is-join");
    //alert($(is_join).html());
    if ($(is_join).html()) {
        $("#is-join-lesson").addClass("normal");
        $("#is-join-lesson").html("退出该课程");
        $("#is-join-lesson").attr("val", $(lesson).attr("val"));
        $("#is-join-lesson").attr("opt", "0");
    }
    else {
        $("#is-join-lesson").removeClass("normal");
        $("#is-join-lesson").html("参加该课程");
        $("#is-join-lesson").attr("val", $(lesson).attr("val"));
        $("#is-join-lesson").attr("opt", "1");
    }
}

function submitLesson(lesson) {
    var lesson_id = $(lesson).attr("val");
    var opt = $(lesson).attr("opt");

    joinLesson(teacher_id, lesson_id, opt,  submitLater)
}

function submitLater(opt, lesson_id) {
    var classes = $(".class-btn");

    $.each(classes,function() {
        //alert($(this).attr("val") + ":" + lesson_id);
       if ($(this).attr("val") == lesson_id) {
           if (opt == 1) {
               $(this).find(".holder").html("");
               $(this).find(".holder").html('<img src="/img/arr-r.png" class="icoin" /><div class="p27-t1 is-join">已参加</div>');

               var count = parseInt($("#class-count").html());

               count = count + 1;

               $("#class-count").html(count)
           }
           else {
               $(this).find(".holder").html("");
               $(this).find(".holder").html('<img src="/img/arr-r.png" class="icoin" />');

               var count = parseInt($("#class-count").html());

               count = count - 1;

               $("#class-count").html(count)
           }
       }
    });

    if (opt == 1) {
        $("#is-join-lesson").addClass("normal");
        $("#is-join-lesson").html("退出该课程");
        $("#is-join-lesson").attr("opt", "0");
    }
    else {
        $("#is-join-lesson").removeClass("normal");
        $("#is-join-lesson").html("参加该课程");
        $("#is-join-lesson").attr("opt", "1");
    }

    //$("#pp-show-cld").find('.cd-slidepopupback').tap();

    closePopup($("#pp-show-cld").find('.cd-slidepopupback'));
}