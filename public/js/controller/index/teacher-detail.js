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
}

function initInput() {

}

function loadData() {
    todayIsBusy();
}

function initControls() {
    initWeek();
}
