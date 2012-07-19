<?php namespace Widget\Repositories;

use redisent, Helpers, StdClass, S36Themes, Underscore;

//Redis backed WidgetThemes
class DBWidgetThemes {

    private $redis;
    private $collection;
    private $total_theme_count;

    public function __construct() {
        $this->redis = new redisent\Redis; 
        $this->categories = new S36Themes;
        $this->underscore = new Underscore;
    }

    //Write data
    public function write_data() {
        foreach($this->categories->main_categories_build as $key => $val) {
            $key_name = "$key:widget:themes";
            foreach($val as $k => $v) {
                //save category children
                $this->redis->sadd($key_name, $k);       

                $widget_theme_key = "$k:theme:value:label";
                $this->redis->hset($widget_theme_key, $k, ucwords($v));
                $this->redis->hset($widget_theme_key, $k.'-heart', $v." Heart");
                $this->redis->hset($widget_theme_key, $k.'-like', $v." Like");
            }
        }
    }

    public function perform() { 
        return $this->collection;
    }
    
    //Grab data
    public function build_menu_structure() {
        
        $collection = new StdClass; 
        $count = 0;
        
        //always check for new styles write them to main themes directory
        $this->write_data();
        $count = 0;
        foreach($this->categories->main_categories_build as $key => $val) {

            $key_name = "$key:widget:themes";
            $smembers = $this->redis->smembers($key_name);

            $data = new StdClass;
            $data->head = $key_name;
            $data->children = Array();

            foreach($smembers as $v) {

                $widget_theme_key = "$v:theme:value:label";

                $heart_key = $v."-heart";
                $like_key  = $v."-like";

                $main  = $this->redis->hget($widget_theme_key, $v);
                $heart = $this->redis->hget($widget_theme_key, $heart_key);
                $like  = $this->redis->hget($widget_theme_key, $like_key);

                $child_data = new StdClass;
                $child_data->parent  = $key;
                $child_data->default = array($v, $main);
                $child_data->heart   = array($heart_key, $heart);
                $child_data->like    = array($like_key, $like);
                 
                //hard coded value to get total amount object vars
                $count += 3; 
                $data->children[] = $child_data;
            }
            $collection->$key = $data;
        }

        $this->total_theme_count = $count;
        $this->collection = $collection;
        //conserb mems
        $collection = Null;
    }

    public function get_theme_count() {
        return $this->total_theme_count;     
    }

    public function tab_themes() {
        
        $ctr = 0;
        foreach($this->collection as $main_themes) {    
            foreach($main_themes as $key => $value) {
                if(is_array($value)) {
                    foreach($value as $v) { 
                        /*
                        print_r($v->default[0]." ".$v->default[1]."\n");               
                        print_r($v->heart[0]." ".$v->heart[1]."\n");               
                        print_r($v->like[0]." ".$v->like[1]."\n");                
                        */ 
                        foreach($v as $prop => $vl) {
                            if($prop != 'parent') {
                                print_r($prop);
                                foreach($vl as $theme) {
                                    print_r($theme);
                                }
                            }
                        
                        }
                        $ctr += 1;
                    }
                } 
            } 
        }
        
        print_r($ctr);
    }

    public function main_themes() {
        return array_keys($this->categories->main_categories_build);
    }

    public function get_parent($theme_key) { 
        foreach($this->collection as $parent) {
            foreach($parent->children as $key => $value) {
                $match_key = $this->underscore->first($value->default);
                if($theme_key == $match_key) {
                    return $value->parent;     
                } 
            }
        }
    }
 
    //TODO: incomplete implementation
    public function check_theme_changes() {}

    public function remove_category($category) {
        $this->write_data();
        $key_name = "$category:widget:themes";
    }

    public function remove_theme($theme_name) { 
        $this->write_data();
        $widget_theme_key = "$theme_name:theme:value:label";
    }
}
