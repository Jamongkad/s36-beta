<?php

class UserTheme extends S36DataObject {
    public function createTheme($post) { 

        $optionFactory = new OptionFactory($post);
        $widget = DB::table('Widget', 'master')->where('widgetName', '=', $post['embed_type'])->first(Array('widgetId'));
        $optionId = $optionFactory->returnObj()->save();

        $data = Array(
            'siteId'    => $post['site_id']
          , 'companyId' => $post['company_id']
          , 'widgetId'  => $widget->widgetid
          , 'themeId'   => $post['theme_id']
          , 'optionId'  => $optionId
        );
        $insert = DB::table('UserThemes', 'master')->insert($data);
        print_r($insert);

    }
}

class OptionFactory {

    private $embed_type, $post_contents;
    public $obj;

    public function __construct($post) { 

        $this->post_contents = $post;

        $embed_type = $post['embed_type'];

        if($embed_type == 'embedded') { 
            $params = Array(
                'units'    => $post['embed_units']
              , 'type'     => $post['embed_block_type']
              , 'width'    => $post['embed_width']
              , 'height'   => $post['embed_height']
              , 'effectId' => $post['embed_effects']
            );
            $this->obj = new EmbeddedBlockOptions($params);          
        }
           
        if($embed_type == 'fullpage') {
            $params = Array('units' => $post['full_page_units']);
            $this->obj = new FullPageOptions($params);      
        }
       
        if($embed_type == 'modal') {
            $params = Array('effectId' => $post['modal_effects']);
            $this->obj = new ModalWindowOptions($params);          
        }
    }

    public function returnObj() {
        return $this->obj;     
    }
}

abstract class Options extends S36DataObject {
    
    private $option_parameters;

    public function __construct($option_parameters) {
        $this->option_parameters = $option_parameters;    
    }
    //saves object in DB returns optionId for embedding into UserTheme table. 
    public abstract function save();
}

class EmbeddedBlockOptions extends Options {
    public function __construct($option_parameters) { 
        $this->option_parameters = $option_parameters;    
        $this->dbh = DB::Connection('master')->pdo;
    }

    public function save() { 
        $this->dbh->query("SET FOREIGN_KEY_CHECKS = 0");
        $insert_id = DB::table(get_class($this), 'master')->insert_get_id( $this->option_parameters );
        $this->dbh->query("SET FOREIGN_KEY_CHECKS = 1");
        return $insert_id;    
    }
}

class ModalWindowOptions extends Options { 
    public function __construct($option_parameters) { 
        $this->option_parameters = $option_parameters;    
    }

    public function save() { 
        $this->dbh->query("SET FOREIGN_KEY_CHECKS = 0");
        $insert_id = DB::table(get_class($this), 'master')->insert_get_id( $this->option_parameters );
        $this->dbh->query("SET FOREIGN_KEY_CHECKS = 1");
        return $insert_id; 
    }
}

class FullPageOptions extends Options { 
    public function __construct($option_parameters) {        
        $this->option_parameters = $option_parameters;    
    }

    public function save() { 
        $this->dbh->query("SET FOREIGN_KEY_CHECKS = 0");
        $insert_id = DB::table(get_class($this), 'master')->insert_get_id( $this->option_parameters );
        $this->dbh->query("SET FOREIGN_KEY_CHECKS = 1");
        return $insert_id; 
    }
}
