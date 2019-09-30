<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/community_view.css') ?>">

<div class="page-root">

    <?php

    if ($user_info->user_type_id == '1') { ?>
        <div class="content-info">
            <div class="content-username"><?= $user_info->fullname; ?></div>
            <div class="content-title"><?= $contents_info->content_title; ?></div>
            <div class="content-description"><?= $contents_info->content_description; ?></div>
        </div>
    <?php } else { ?>
        <div class="content-info-student">
            <div class="content-student-username"><?= $contents_info->content_class; ?></div>
            <div class="content-student-class"><?= $contents_info->apply_time; ?></div>
            <div class="content-student-title"><?= $contents_info->content_title; ?></div>
            <div class="content-student-description"><?= $contents_info->content_description; ?></div>
        </div>
    <?php } ?>

    <?php if ($contents_info->media_type == '1') {
        if ($contents_info->content_path != '') {
            $imgArr = explode(';', $contents_info->content_path);
            echo '<div class="content-view-image">';
            foreach ($imgArr as $imgItem):
                echo '<div class="content-image-item" style="background-image:url(' . base_url($imgItem) . ')"></div>';
            endforeach;
            echo '</div>';
        }
        ?>
    <?php } else if ($contents_info->media_type == '2') { ?>
        <div class="content-view-video">

            <iframe src="<?= base_url('assets/js/toolset/video_player/vplayer.php') . '?ncw_file=' . base_url($contents_info->content_path) . '&status=stop'; ?>"
                    id="courseware_iframe" allowfullscreen="true"
                    webkitallowfullscreen="true" mozallowfullscreen="true" style="border:none;width: 100%;height: 100%">
            </iframe>
        </div>

    <?php } ?>

</div>

<div id="courseview-content">
    <input id="courseId" value="<?= $contents_info->content_id; ?>" style="display: none;">
</div>

<script src="<?= base_url('assets/js/frontend/community_view.js') ?>"></script>