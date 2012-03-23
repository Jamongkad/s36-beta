<?php namespace Widget\Services;

use Config
  , Widget\Entities\SubmissionWidget
  , Widget\Entities\HorizontalEmbedWidget
  , Widget\Entities\VerticalEmbedWidget
  , Widget\Entities\ModalEmbedWidget;

class WidgetFactory {

   public function load_widget($option) {
       if ($option->widget == 'form') {
           $widget = new SubmissionWidget($option);     
           return $widget;
       }

       if ($option->widget == 'embedded') {
           if ($option->embed_block_type == 'embed_block_x') {
               $widget = new HorizontalEmbedWidget($option);
               return $widget;
           }

           if ($option->embed_block_type == 'embed_block_y') { 
               $widget = new VerticalEmbedWidget($option);
               return $widget;
           }
       }

       if ($option->widget == 'modal') {    
           $widget = new ModalEmbedWidget($option);
           return $widget;
       }
   }
}


