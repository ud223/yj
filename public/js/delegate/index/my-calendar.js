function setFreeDayClick() {
    $("#set-free").tapA(function() {
        setDay(0);
    });
}

function setBusyDayClick() {
    $("#set-busy").tapA(function() {
        setDay(1);
    });
}