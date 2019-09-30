

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/classroom.css') ?>">
<!--<script>
    var imageDir = baseURL + "assets/images/classroom/";
    var classPath = parseInt("<?/*=$class_id;*/?>");
    // $(function () {
    //     setTimeout(function () {
    //         $('iframe').attr('src',baseURL+classList[classPath].path+"/package/index.html");
    //     },500);
    // })
</script>-->
<iframe src=""></iframe>

<script>
    $(function () {
        setTimeout(function () {
            $('iframe').css({'width':'100%','height':'100%'});
            $('iframe').attr('src',"<?= base_url($class_id)?>");
        },100);
    })
</script>

<!--<script src="<?/*= base_url('assets/js/classroom.js') */?>" type="text/javascript"></script>-->