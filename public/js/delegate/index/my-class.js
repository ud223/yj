function lessonClick() {
    $(".class-btn").tapA(function() {
        chooseLesson(this);
    });
}

function joinClick() {
    $("#is-join-lesson").tapA(function() {
        submitLesson(this);
    })
}