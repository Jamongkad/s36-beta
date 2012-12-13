<?php namespace Widget\Entities\Types;

abstract class WidgetTypes {

    protected $height;
    protected $width;

    public function render_html() {}
    public function render_hosted() {}

    public function get_height() {
        return $this->height;      
    }
    public function get_width() { 
        return $this->width;      
    }
    public function my_name() {
        return get_class($this);
    }
}
