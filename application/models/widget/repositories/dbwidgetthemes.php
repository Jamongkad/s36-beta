<?php namespace Widget\Repositories;

use redisent, Helpers, StdClass, S36Themes;

class DBWidgetThemes {

    private $redis;
    private $collection;

    public function __construct() {
        $this->redis = new redisent\Redis; 
        $this->categories = new S36Themes;
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

    public function show_all() { 
        return $this->collection;
    }
    
    //Grab data
    public function build_menu_structure() {
        
        $collection = new StdClass; 

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
                $child_data->default = (object) array($v => $main);
                $child_data->heart   = (object) array($heart_key => $heart);
                $child_data->like    = (object) array($like_key => $like);

                $data->children[] = $child_data;

            }

            $collection->$key = $data;
        }

        $this->collection = $collection;
        //conserb mems
        $collection = Null;
    }

    public function insert_category() {}
    public function insert_theme() {}
}
