<?php namespace Widget\Entities;

use Input;
use \Widget\Entities\Types\WidgetValueObject;

class DisplayValueObject extends WidgetValueObject { 
    $widgetKey;
    $site_id;
    $company_id;
    $theme_type;
    $theme_name
    $form_text;
    $embed_type;
    $embed_block_type;
    $embed_effects;
    $modal_effects;
    $perms;
    $widget_type = 'display';
}
