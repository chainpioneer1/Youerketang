<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width,initial-scale=1.0,minimum-scale=0.8, maximum-scale=1.5, user-scalable=yes"/>
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <title><?= $this->lang->line('frontend_title')?></title>
    <link rel="shortcut icon" href="<?= base_url('assets/images/logo.png') ?>" type="image/x-icon"/>
    <script type="text/javascript" src="<?= base_url('assets/js/jquery-1.12.3.min.js') ?>"></script>

    <style>
        body {
            position: absolute;
            width: calc(100vw - 20px );
            height: calc(100vh - 20px);
            overflow:auto;
            text-align: center;
            vertical-align: middle;
        }

        iframe {
            position: relative;
            display: inline-block;
            left: 0;
            top: 0;
            /*transform: translate(-50%, -50%);*/
        }
    </style>
</head>
<body>
</body>
</html>