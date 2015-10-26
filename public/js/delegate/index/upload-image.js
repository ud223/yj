function initHeadPic() {
    var fileInput = document.getElementById('upload-head-pic');

    fileInput.onchange = function() {
        var file = fileInput.files[0];

        ImageOpt(file, 'pre-image');

        $("#btn-submit").removeAttr("disabled");
    };
}

function choosePhotoClick() {
    $("#btn-choose").tapA(function() {
        $("#upload-head-pic").click();
    })
}

function back() {
    window.history.back();
}