<div class="bg"></div>
<div class="main-content">
    <?php
    $i = 0;
    $j = 0;
    for($k = 0; $k < count($sites); $k++) {
        $item = $sites[$k];
        if ($j == 4) {
            $j = 0;
            $i++;
        }
        if ($j == 0) {
            echo '<div class="course-content" itemid="' . ($i + 1) . '"';
            if ($i != 0)
                echo ' style="opacity:0; z-index:0;">';
            else
                echo ' style="opacity:1; z-index:1;">';
            echo '<div class="before-btn" itemid="' . ($i + 1) . '"></div>';
            echo '<div class="after-btn" itemid="' . ($i + 1) . '"></div>';
        }
        $lock = true;
        foreach ($codeInfo as $active_item) {
            if ($active_item->site_id == $item->id)
                $lock = false;
        }
        echo '<a class="nav-btn" itemid="' . $item->id . '"';
        if ($lock)
            echo ' lock="1">';
        else
            echo ' lock="0">';
        echo '<div class="nav-item" style="background: url(' . base_url() . $item->icon_path . ');"></div>';
        echo '<div class="lock-bg"';
        if ($lock)
            echo ' style="opacity:1; z-index:1;">';
        else
            echo ' style="opacity:0; z-index:0;">';
        echo '</div>';
        echo '</a>';
        if ($j == 3 || $k == count($sites) - 1)
            echo '</div>';
        $j++;
    }
    ?>
    <div class="warning"></div>
</div>

<script>
    var site_count = '<?= count($sites)?>';
    if (site_count > 4) {
        $('.before-btn').show();
        $('.after-btn').show();
    }
    var course_count = 0;
    if (site_count % 4 == 0)
        course_count = site_count / 4;
    else
        course_count = (site_count - site_count % 4) / 4 + 1;
    $('.before-btn').on('click', function () {
        var element = $(this);
        var item_id = element.attr('itemid') * 1;
        var idx = item_id - 1;
        if (idx <= 0) idx = course_count;
        $('.course-content[itemid=' + idx + ']').css({opacity: '1', 'z-index': '1'});
        $('.course-content[itemid=' + item_id + ']').css({opacity: '0', 'z-index': '0'});

    })
    $('.after-btn').on('click', function () {
        var element = $(this);
        var item_id = element.attr('itemid') * 1;
        var idx = item_id + 1;
        if (idx > course_count) idx = 1;
        $('.course-content[itemid=' + idx + ']').css({opacity: '1', 'z-index': '1'});
        $('.course-content[itemid=' + item_id + ']').css({opacity: '0', 'z-index': '0'});

    })
    $('.nav-btn').on('click', function () {
        var element = $(this);
        var lock = element.attr('lock');
        var item_id = element.attr('itemid');
        if (lock == '0')
            location.href = baseURL + "classroom/pinyin/" + item_id;
        else {
            $('.warning').show();
            setTimeout(function () {
                $('.warning').hide();
            },2000);
        }

    })
    sessionStorage.setItem('ci_session', 'qwerpoislkj234098srtpoiu3409weoriusdf');
</script>