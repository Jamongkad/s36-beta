<?php
    $db_fullpage_bg = new \Hosted\Repositories\DBFullpageBackground(Config::get('application.subdomain'));
    $fullpage_bg = $db_fullpage_bg->get_data();
?>
<div id="body_image_overlay"></div>
<div id="bodyColorOverlay"></div>
<style type"text/css">
    #body_image_overlay, #bodyColorOverlay{
        position: fixed;
        width: 100%;
        height: 100%;
    }
    #body_image_overlay{
        background-image: url(<?= $fullpage_bg->page_bg_image; ?>);
        background-position: <?= $fullpage_bg->page_bg_position; ?>;
        background-repeat: <?= $fullpage_bg->page_bg_repeat; ?>;
    }
    #bodyColorOverlay{
        background: <?= $fullpage_bg->page_bg_color; ?>;
        opacity: <?= $fullpage_bg->page_bg_color_opacity; ?>;
    }
</style>