function lessonClick() {
    $(".class-btn").tap(function() {
        chooseLesson(this);
    });
}

function joinClick() {
    $("#is-join-lesson").tap(function() {
        submitLesson(this);
    })
}