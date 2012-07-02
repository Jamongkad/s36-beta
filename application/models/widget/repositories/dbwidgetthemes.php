<?php namespace Widget\Repositories;

use redisent, Helpers;

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
        foreach($this->main_categories_build as $key => $val) {
            foreach($val as $k => $v) {
                $widget_theme_key = "$k:theme:value:label";
                
                $main = $this->redis->hget($widget_theme_key, $k);
                $heart = $this->redis->hget($widget_theme_key, $k."-heart");
                $like = $this->redis->hget($widget_theme_key, $k."-like");

                Helpers::dump($main);
                Helpers::dump($heart);
                Helpers::dump($like);

            }
        }
    }

    public function insert_category() {}
    public function insert_theme() {}
}
