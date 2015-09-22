function ImageOpt(file, img_id) {
    // 参数，最大高度
    var MAX_HEIGHT = 120;
    var path = URL.createObjectURL(file);
    // 创建一个 Image 对象
    var image = document .getElementById(img_id);
    // 绑定 load 事件处理器，加载完成后执行
    image.onload = function()  {
        if (MAX_HEIGHT < this.height) {
            var scale = MAX_HEIGHT / this.height;
            var width = this.width;
            var height = this.height;

            this.width = width * scale;
            this.height = height * scale;
        }
    };

    image.src = path;
}

function loadImage(path, img_id) {
    // 参数，最大高度
    var MAX_HEIGHT = 120;
    // 创建一个 Image 对象
    var image = document .getElementById(img_id);
    // 绑定 load 事件处理器，加载完成后执行
    image.onload = function()  {
        if (MAX_HEIGHT < this.height) {
            var scale = MAX_HEIGHT / this.height;
            var width = this.width;
            var height = this.height;

            this.width = width * scale;
            this.height = height * scale;
        }
    };

    image.src = path;
}