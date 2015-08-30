function setFreeDayClick() {
    $("#set-free").tap(function() {
        setDay(0);
    });
}

function setBusyDayClick() {
    $("#set-busy").tap(function() {
        setDay(1);
    });
}