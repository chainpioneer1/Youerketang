<!DOCTYPE html>
<html html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN" xml:lang="zh-CN">
<head>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/student/custom.css') ?>">
</head>
<body>
    <img class="load-bg" src="<?= base_url('assets/images/student/home/load_bg.png') ?>"/>
    <script>
        var _loadTmr = 0;
        var imgTag = document.getElementsByClassName('load-bg')[0];
        imgTag.addEventListener('load', function () {
            clearTimeout(_loadTmr);
            _loadTmr = setTimeout(function () {
                location.href='<?=base_url()?>student/home';
            }, 500);
        })
    </script>
</body>
</html>