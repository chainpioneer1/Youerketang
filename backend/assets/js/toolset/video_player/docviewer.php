<?php
$url = $_GET['ncw_file'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <title>文件</title>
    <script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="assets/js/index.js"></script>
</head>
<body style="overflow: auto;">
<a href="<?=$url?>" id="doc" ></a>
<!--<input type="file" onchange="test(this);"/>-->
<!--<textarea id="text" ></textarea>-->
<div id="content"></div>
<script>
    var titleId = "<?=$title_id?>";
    var path = "<?=$url?>";
    var ext = path.split('.');
    $('#doc')[0].download = "document."+ext[ext.length-1];
    $('#doc')[0].click();
    setTimeout(function () {
        //history.back();
    },100)
</script>
</body>
</html>