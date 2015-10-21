$(document).ready(function() {
    initControls();

    initInput();

    initBtn();

    loadData();

    initUser();
});

function initBtn() {
    setNameClick();

    phoneValidClick();

    validPhoneCodeClick();

    setDescriptionClick();

    setYearsClick();

    editAddressName();

    saveRangeClick();
}

function initInput() {

}

function loadData() {

}

function initControls() {

}

function initUser() {
    if (usertype == 2) {
        $("#to-teach").show();
        $("#teacher-date").addClass("grid3");
        $("#to-me").addClass("grid3");
    }
    else {
        $("#to-teach").hide();
        $("#teacher-date").removeClass("grid3");
        $("#to-me").removeClass("grid3");
    }
}