<?php

?>
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery.validate.js') ?>"></script>
<script src="<?= base_url('assets/js/frontend/global.js') ?>"></script>
<script src="<?= base_url('assets/admin/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') ?>"
        type="text/javascript"></script>

<script>
    var _backSteps = history.length;
    $(function () {
        $('.datetime_text').datetimepicker();
    })
    var parentView = '<?=(isset($parentView) ? $parentView : '')?>';

    var userId = '<?= $this->session->userdata('loginuserID')?>';

    function goPreviousPage(id) {
        _backSteps = -history.length + _backSteps - 1;
        console.log(_backSteps);
        if (parentView == 'back') history.go(_backSteps);
        else location.href = baseURL + parentView;
    }

    $(function () {
        if (parentView == '')
            $('.top-back').hide();
    });

    function export_table(filename) {
//        $('#main_tbl thead').css({'display': 'block'});
        $("#main_tbl").table2excel({
            exclude: ".noExl",
            name: "Excel Document Name",
            filename: filename,
            fileext: ".xls",
            exclude_img: true,
            exclude_links: true,
            exclude_inputs: true
        });
        setTimeout(function () {
            $('#main_tbl thead').css({'display': 'none'});
        }, 100);
    }

    function b64toBlob(b64Data, contentType, sliceSize) {

        contentType = contentType || '';
        sliceSize = sliceSize || 512;

        //var byteCharacters = atob(b64Data);//IE10+
        var byteCharacters = Base64.decode(b64Data);
        var byteArrays = [];

        for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
            var slice = byteCharacters.slice(offset, offset + sliceSize);

            var byteNumbers = new Array(slice.length);
            for (var i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
            }

            var byteArray = new Uint8Array(byteNumbers);

            byteArrays.push(byteArray);
        }

        var blob = new Blob(byteArrays, {type: contentType});
        return blob;
    }

    function save_panel_perform() {

        var save_canvas = document.getElementById('result_canvas');
        var ctx_save = save_canvas.getContext('2d');

        var img_back = $('.classinfo-detail img')[0];
        ctx_save.drawImage(img_back, 0, 0, save_canvas.width, save_canvas.height);

        ctx_save.font = '23px Arial';
        ctx_save.fillStyle = '#ffffff';
        ctx_save.strokeStyle = '#ffffff';
        ctx_save.fillText($('.classinfo-detail .classinfo-code').html(), 300, 190);
        ctx_save.strokeText($('.classinfo-detail .classinfo-code').html(), 300, 190);

        var spiriteURL = save_canvas.toDataURL();
        osStatus = getMobileOperatingSystem();
        var userAgent = navigator.userAgent || navigator.vendor || window.opera;
        // $('body').append('<div>'+userAgent.indexOf('JavaFX')+'</div>');
        // return;

        if (userAgent.indexOf('JavaFX') != -1) {
            JavaFx.saveCanvas(spiriteURL);
            // showMessageDlg('<br>图片已成功存储在您的设备上.<br>(' + JavaFx.getFileName() + ')');
        }else if (osStatus=='Android') {
                Android.saveCanvas(spiriteURL);
                // showMessageDlg('<br>图片已成功存储在您的设备上.<br>(' + Android.getFileName() + ')');
        } else {
            var spData = spiriteURL.substring(22);
            $.ajax({
                url: baseURL + "api/uploadImgData",
                type: "POST",
                data: {'imageData': spData},
                success: function (result) {
                    result = JSON.parse(result);
                    if (result.status) {
                        var elem = document.createElement('a');
                        elem.href = result.data;
                        elem.download = "code.png";
                        elem.innerHTML = "Click here to download the file";
                        document.body.appendChild(elem);
                        elem.click();
                        setTimeout(function () {
                            document.body.removeChild(elem);
                            window.URL.revokeObjectURL(elem.href);
                        }, 100);
                        console.log(result);
                    } else
                        window.alert(result['data']);
                }
            });
//            var blob = b64toBlob(spData, 'image/png');
//            if (window.navigator.msSaveOrOpenBlob) {
//                window.navigator.msSaveBlob(blob, "paint.png");
//            } else {
//                if (navigator.userAgent.indexOf(".NET") > 1) {
//
//                } else {
//                    var URL = window.URL || window.webkitURL || window.mozURL || window.msURL;
//                    var base64ImgData = URL.createObjectURL(blob);
//                    var elem = document.createElement('a');
//                    elem.href = base64ImgData;
//                    elem.download = "paint.png";
//                    elem.innerHTML = "Click here to download the file";
//                    document.body.appendChild(elem);
//                    elem.click();
//                    setTimeout(function () {
//                        document.body.removeChild(elem);
//                        window.URL.revokeObjectURL(elem.href);
//                    }, 100);
//                }
//            }
        }
    }

    var isScrolling = false;
    var containerClass = $('#custom-scroll').attr('container_class');
    var containerCtrl = $('.' + containerClass);
    var scrArea = [20, 62, 20, 65];// start, height, readstart, readheight
    var mouseMoveEvent = 'mousemove';
    var mouseUpEvent = 'mouseup';
    var mouseOutEvent = 'mouseout';
    var mouseDownEvent = 'mousedown';
    var mouseEnterEvent = 'mouseover';

    if (isMobile) {
        mouseMoveEvent = 'touchmove';
        mouseUpEvent = 'touchend';
        mouseDownEvent = 'touchstart';
    }

    containerCtrl.scroll(function () {
        var pos = this.scrollTop;
        var hh = this.scrollHeight - this.clientHeight;
        pos = (scrArea[0] + pos / hh * scrArea[1]).toFixed(3);
        $('.scroll-thumb').css({top: pos + '%'});
        var ww = this.clientWidth;
        var hh = $('.scroll-read')[0].clientHeight;
        var sh = $('.scroll-thumb')[0].clientHeight;
        pos = ((pos - scrArea[0] / 2) / (scrArea[3] - scrArea[2]) * hh).toFixed(2);
        $('.scroll-read').attr('style',
            'clip: rect(0px,' + ww + 'px,' + pos + 'px,-1px);'
        );
    });

    $('#custom-scroll').on(mouseDownEvent, function (e) {
        isScrolling = true;
    });
    $('#custom-scroll').on(mouseUpEvent, function (e) {
        isScrolling = false;
    });
    $('#custom-scroll').on(mouseOutEvent, function (e) {
        isScrolling = false;
    });
    $('#custom-scroll').on(mouseEnterEvent, function (e) {
//        isScrolling = true;
    });

    $('#custom-scroll').on(mouseMoveEvent, function (e) {
        e.preventDefault();
        if (!isScrolling) return;
        if (containerCtrl[0].clientHeight >= containerCtrl[0].scrollHeight) return;
        mouse = getMouseCoordinate.call(this, e);
        var pos = mouse.y - this.offsetTop + this.offsetHeight / 2;
        pos = (pos / this.clientHeight * 100).toFixed(1);
        if (pos < scrArea[0] || pos > scrArea[0] + scrArea[1]) return;
        var hh = containerCtrl[0].scrollHeight - containerCtrl[0].clientHeight;
        pos = parseFloat(((pos - scrArea[0]) / scrArea[1] * hh).toFixed(2));
        containerCtrl[0].scrollTop = pos;
    });

    $('#custom-scroll .scroll-up-btn').on('click', function (e) {
        var pos = containerCtrl[0].scrollTop;
        if (pos > 0)
            containerCtrl.animate({scrollTop: pos - 100}, 500, 'linear');
    });
    $('#custom-scroll .scroll-down-btn').on('click', function (e) {
        var pos = containerCtrl[0].scrollTop;
        if (pos < containerCtrl[0].scrollHeight)
            containerCtrl.animate({scrollTop: pos + 100}, 500, 'linear');
    });

    function getMouseCoordinate(evt) {

        if (isMobile) {
            evt = evt.originalEvent;
            if (('changedTouches' in evt)) evt = evt.changedTouches[0];
        }
        return {
            x: evt.pageX - this.offsetParent.offsetLeft,
            y: evt.pageY - this.offsetParent.offsetTop
        };

    }
</script>
</body>
</html>