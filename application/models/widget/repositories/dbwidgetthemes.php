<?php namespace Widget\Repositories;

use redisent, Helpers, StdClass;

class DBWidgetThemes {

    private $redis;
    private $main_categories_build = Array(
        'corporate' =>  Array(
            'aglow'  => 'Aglow'
          , 'alum'   => 'Aluminum'
          , 'chrome' => 'Chrome'
          , 'classic'=> 'Classic'
          , 'contrast' => 'Contrast'
          , 'dark'   => 'Dark'
          , 'matte'    => 'Matte'
          , 'silver' => 'Silver'
        )
      , 'minimalist' => Array()
      , 'creative' => Array(
            'cloudy'  => 'Cloudy'
          , 'salad' => 'Salad'
      ));

    public function __construct() {
        $this->redis = new redisent\Redis; 
    }

    public function build_data() {
        foreach($this->main_categories_build as $key => $val) {
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

        $collection = Array();

        foreach($this->main_categories_build as $key => $val) {
            $key_name = "$key:widget:themes";
            $smembers = $this->redis->smembers($key_name);
            foreach($smembers as $v) {
                $widget_theme_key = "$v:theme:value:label";
                Helpers::dump($widget_theme_key);
            }
            /*
            foreach($val as $k => $v) {
                $widget_theme_key = "$k:theme:value:label";
                
                $main = $this->redis->hget($widget_theme_key, $k);
                $heart = $this->redis->hget($widget_theme_key, $k."-heart");
                $like = $this->redis->hget($widget_theme_key, $k."-like");

                $heart_key = $k."-heart";
                $like_key = $k."-like";

                $data = new StdClass;
                $data->main = array($v => $main);
                $data->heart = array($heart_key => $heart);
                $data->like = array($like_key => $like);

                Helpers::dump($data);
            }
            */
        }
    }

    public function insert_category() {}
    public function insert_theme() {}
}
