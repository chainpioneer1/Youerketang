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
    <script src="assets/js/jquery-1.10.2.min.js"></script>
    <script src="assets/js/pdfobject.js"></script>
    <title>PDF</title>
    <style>.pdf_container{position: absolute;left: 0;top: 0;width: calc(100vw);height: calc(100vh);}</style>
</head>
<body>
<div class="pdf_container" id="pdf_container"></div>
<script>
    $(function () {
        PDFObject.embed("<?=$_GET['ncw_file']?>", "#pdf_container");
    })
</script>
</body>
</html>