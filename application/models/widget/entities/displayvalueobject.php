<?php namespace Widget\Entities;

use Input;
use \Widget\Entities\Types\WidgetValueObject;

class DisplayValueObject extends WidgetValueObject { 
    public $widgetKey;
    public $site_id;
    public $company_id;
    public $theme_type;
    public $theme_name;
    public $form_text;
    public $embed_type;
    public $embed_block_type;
    public $embed_effects;
    public $modal_effects;
    public $perms;
    public $widget_type = 'display';
}
