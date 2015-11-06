$(document).ready(function() {
    initControls();

    initInput();

    initBtn();

    loadData();
});

function initBtn() {
    chooseDayClick();

    initTimeClick();

    initSubmitOrder();

    toChooseTimeClick();

    loadIsRange();
}

function initInput() {

}

function loadData() {
    todayIsBusy();
}

function initControls() {
    initWeek();
}
