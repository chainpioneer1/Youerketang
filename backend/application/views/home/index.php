<div class="bg-home-top" style="width:100%; height:100%;"></div>

<!--<div class="home-main-content slider-bar owl-carousel">-->
<!--    --><?php
//        foreach ( $banners as $item){
//            echo '<div class="owl-item"><img src="'.base_url('uploads/'.$item->image).'"/></div>';
//        }
//    ?>
<!--</div>-->
<iframe class="home-main-content" ondragstart="return false;" draggable="false"
        src="<?= base_url('uploads') . '/' . $banners[0]->image; ?>"
        frameborder="no" allowfullscreen="true"></iframe>
<a class="home-preview-link" href="<?= base_url() . '/uploads/class/kuaile_1/package/index.html' ?>">点我试用</a>
<div class="home-bottom">
    <?php $i = 0; foreach ($sites as $item) { $i++; ?>
        <a class="nav" href = "<?= base_url('classroom').'/index/'.$item->id ?>" itemid = "<?= $i ?>" style = "background: url(<?= base_url().$item->icon_path ?>);" ></a>
    <?php } ?>

</div>

<script>
    // $('.home-main-content').owlCarousel({
    //     items: 1,
    //     nav: true,
    //     dots: true,
    //     autoplay: true,
    //     loop: true,
    //     navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
    //     mouseDrag: true,
    //     touchDrag: true,
    //     smartSpeed: 1200
    // });
    $('iframe.home-main-content').on('load', function () {
        $($('iframe.home-main-content')[0].contentWindow.document.getElementsByTagName('video')).css({
            'object-fit': 'fill',
            width: '100%',
            height: '100%'
        });
    })
    $(function () {
        $('.home-btn').hide();
        $('.home-main-content').on('mousedown', function (e) {
            e.preventDefault();
        }).on('mousemove', function (e) {
            e.preventDefault();
        }).on('mouseup', function (e) {
            e.preventDefault();
        })
    })
    sessionStorage.setItem('ci_session', 'qwerpoislkj234098srtpoiu3409weoriusdf');
</script>