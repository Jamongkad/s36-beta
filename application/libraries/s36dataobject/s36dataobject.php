<?php namespace S36DataObject;

use DB;
use S36Auth; 

abstract class S36DataObject { 

    public $dbh, $user_id;

    public function __construct() { 
        $this->dbh = DB::connection('master')->pdo;

        if(S36Auth::check())
            $this->user_id = S36Auth::user()->userid;        
    }
}

//TODO: Transfer to S36ValueObjects Package Value Objects for UserThemes
class EmbeddedWidget {
    public $site_id;
    public $company_id;
    public $embed_type;
    public $type;
    public $width;
    public $height;
    public $effect;
    public $units;
    public $theme_id;
    public $widget_option_id;
}

class ModalWidget { 
    public $site_id;
    public $company_id;
    public $embed_type;
    public $theme_id;
    public $effect;
    public $widget_option_id;
}
