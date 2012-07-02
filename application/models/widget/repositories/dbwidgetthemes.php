<?php namespace Widget\Repositories;

use redisent;

class DBWidgetThemes {

    private $redis;
    private $main_categories = Array('corporate', 'minimalist', 'creative');

    public function __construct() {
        $this->redis = new redisent\Redis; 
    }
}
