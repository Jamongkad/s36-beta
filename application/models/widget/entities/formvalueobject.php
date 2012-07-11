<?php namespace Widget\Entities;

use Input;
use \Widget\Entities\Types\WidgetValueObject;

class FormValueObject extends WidgetValueObject {  
    $widgetKey; 
    $site_id;
    $company_id;
    $theme_type;
    $theme_name;
    $submit_form_question;
    $submit_form_text;
    $tab_pos;
    $tab_type;
    $widget_type = 'submit';
    $embed_type = 'form';
}
