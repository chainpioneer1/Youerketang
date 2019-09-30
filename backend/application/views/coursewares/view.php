<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/home.css') ?>">

<input id="all_coursewares" value='<?=json_encode($coursewares);?>' style="display: none;">
<script>
    var all_coursewares = JSON.parse($('#all_coursewares').val());
</script>
<div id="courseview-content">
    <div class="courseview-nav">
        <?php
        for ($i = 0; $i < 4; $i++) {
            echo '<div class="mainnav-item"></div>';
        }
        ?>
    </div>
    <?php
    $ii = 0;
    $jj = 0;
    $kk = 0;
    $colors = ['#44dc5e', '#da4846', '#ff9700', '#54c9fc'];
    for ($i = 0; $i < count($coursewares); $i++) {
        $item = $coursewares[$i];
//        if ($item->childcourse_publish == 0) {
//            continue;
//        }
        if ($item->ncw_author_id != '0') continue;
        if ($kk == 5) {
            $kk = 1;
            $jj++;
        }
        if ($jj == 3) {
            $kk = 0;
            $jj = 0;
            $ii++;
        }
        if ($jj == 0 && $kk == 0) {
            if ($ii != 0) echo '</div>';
            echo '<div class="courseview-subnav" item_id="' . ($ii + 1) . '"';
//            if ($ii != 0)
//                echo ' style="opacity:0;z-index:0;"';
//            else
//                echo ' style="opacity:1;z-index:1;"';
            echo '>';
        }
        switch ($kk) {
            case 0:
                echo '<div class="courseview-title" '
                    . ' style="background:url('
                    . base_url('assets/images/taiyang/courseview/nav_'
                        . ($ii + 1) . '0.png') . ') no-repeat;">'
                    . '</div>';
                break;
            case 1:
                echo '<div class="courseview-title" '
                    . ' style="background:url('
                    . base_url('assets/images/taiyang/courseview/nav_'
                        . ($ii + 1) . ($jj + 1) . '.png') . ') no-repeat;">'
                    . '</div>';
                break;
        }
        echo '<a class="courseview-item" style="color:grey;';
        if ($item->childcourse_publish != 0 && $item->ncw_publish == 1) {
            if ($item->ncw_type == 1)
                echo 'color:' . $colors[$ii] . '" href="#" onclick="showPackage(\'' . base_url($item->ncw_file) . '/index.html\',this);';
            else if ($item->ncw_type == 2)
                echo 'color:' . $colors[$ii] . '" href="#" onclick="showPackage(\''
                    . base_url('assets/js/toolset/video_player/vplayer.php') . '?ncw_file='
                    . base_url($item->ncw_file) . '\',this);';
            else if ($item->ncw_type == 3)
                echo 'color:' . $colors[$ii] . '" href="#" onclick="showPackage(\''
                    . base_url('assets/js/toolset/video_player/iplayer.php') . '?ncw_file='
                    . base_url($item->ncw_file) . '\',this);';
            else if ($item->ncw_type == 4)
                echo 'color:' . $colors[$ii] . '" href="#" onclick="showPackage(\''
                    . base_url('assets/js/toolset/video_player/docviewer.php') . '?ncw_file='
                    . base_url($item->ncw_file) . '\',this);';
        }
        echo '" old_color="' . $colors[$ii] . '">' . $item->ncw_name . '</a>';
        $kk++;
    }
    echo '</div>';
    ?>
    <div class="courseview-area">
        <iframe src=""
                id="courseware_iframe" allowfullscreen="true"
                webkitallowfullscreen="true" mozallowfullscreen="true" style="border:none">

        </iframe>
    </div>
    <input id="courseId" value="<?= $courseware_id; ?>" style="display: none;">
</div>

<script src="<?= base_url('assets/js/courseware.js') ?>"></script>
