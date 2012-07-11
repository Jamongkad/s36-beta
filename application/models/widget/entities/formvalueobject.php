<?php namespace Widget\Entities;

use Input;
use \Widget\Entities\Types\WidgetValueObject;

class FormValueObject extends WidgetValueObject {  
   public $widgetKey; 
   public $site_id;
   public $company_id;
   public $theme_type;
   public $theme_name;
   public $submit_form_question;
   public $submit_form_text;
   public $tab_pos;
   public $tab_type;
   public $widget_type = 'submit';
   public $embed_type = 'form';
}
