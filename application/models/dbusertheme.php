<?php

class DBUserTheme extends S36DataObject {
    public function create_theme($post) { 

        $widget = DB::table('Widget', 'master')->where('widgetName', '=', $post['embed_type'])->first(Array('widgetId'));
        $data = Array(
            'siteId'     => $post['site_id']
          , 'companyId'  => $post['company_id']
          , 'widgetId'   => $widget->widgetid
          , 'themeId'    => $post['theme_id']
          , 'themeName'  => $post['theme_name']
        );

        $insert_id = DB::table('UserThemes', 'master')->insert_get_id($data);

        $optionFactory = new OptionFactory($post, $insert_id);
        $optionFactory->returnObj()->save();
    }

    public function fetch_themes_by_company_id($company_id) {
        $sql = "
            SELECT 
                ut.userThemeId 
              , ut.themeName
              , ste.domain
              , wdgt.widgetName 
              , thme.name
            FROM 
                UserThemes AS ut
            LEFT JOIN
                FullPageOptions AS fpo
                    ON fpo.userThemeId = ut.userThemeId
            LEFT JOIN
                ModalWindowOptions AS mwo
                    ON mwo.userThemeId = ut.userThemeId
            LEFT JOIN
                EmbeddedBlockOptions AS ebo
                    ON ebo.userThemeId = ut.userThemeId
            INNER JOIN
                Widget AS wdgt
                    ON wdgt.widgetId = ut.widgetId
            INNER JOIN
                Site AS ste
                    ON ste.siteId = ut.siteId
            INNER JOIN
                Theme AS thme
                    ON thme.themeId = ut.themeId
            WHERE 1=1
                AND ut.companyId = :company_id
            ORDER BY 
                ut.userThemeId DESC
        ";

        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':company_id', $company_id, PDO::PARAM_INT); 
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function fetch_theme_by_id($user_theme_id, $company_id) {
        $sql = "
            SELECT 
              *
              , ut.userThemeId
              , ut.companyId
              , ut.siteId
              , ut.themeId
              , CASE
                    WHEN ebo.effectId THEN ebo.effectId
                    WHEN mwo.effectId THEN mwo.effectId
                END AS effect
              , CASE
                    WHEN ebo.embeddedBlockId THEN ebo.embeddedBlockId
                    WHEN mwo.modalId THEN mwo.modalId
                END AS widgetOptionId
            FROM 
                UserThemes AS ut
            LEFT JOIN
                FullPageOptions AS fpo
                    ON fpo.userThemeId = ut.userThemeId
            LEFT JOIN
                ModalWindowOptions AS mwo
                    ON mwo.userThemeId = ut.userThemeId
            LEFT JOIN
                EmbeddedBlockOptions AS ebo
                    ON ebo.userThemeId = ut.userThemeId
            LEFT JOIN
                Widget AS wdgt
                    ON wdgt.widgetId = ut.widgetId
            LEFT JOIN
                Site AS ste
                    ON ste.siteId = ut.siteId
            LEFT JOIN
                Theme AS thme
                    ON thme.themeId = ut.themeId
            WHERE 1=1
                AND ut.userThemeId = :user_theme_id
                AND ut.companyId = :company_id
        ";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':user_theme_id', $user_theme_id, PDO::PARAM_INT);
        $sth->bindParam(':company_id', $company_id, PDO::PARAM_INT); 
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_OBJ);
        
        $value_object = null;
        if($result->widgetname == 'embedded') {
            $value_object = new S36DataObject\EmbeddedWidget;
            $value_object->site_id    = $result->siteid;
            $value_object->company_id = $result->companyid; 
            $value_object->embed_type = $result->widgetname;
            $value_object->type       = $result->type;
            $value_object->width      = $result->width; 
            $value_object->height     = $result->height;
            $value_object->effect     = $result->effect;
            $value_object->units      = $result->units; 
            $value_object->theme_id   = $result->themeid;
            $value_object->widget_option_id = $result->widgetoptionid;
        }

        if($result->widgetname == 'modal') {
            $value_object = new S36DataObject\ModalWidget;
            $value_object->site_id    = $result->siteid;
            $value_object->company_id = $result->companyid; 
            $value_object->embed_type = $result->widgetname;
            $value_object->theme_id   = $result->themeid;
            $value_object->effect     = $result->effect;     
            $value_object->widget_option_id = $result->widgetoptionid;
        }

        return $value_object; 
    }

    public function update_theme($post) {
        //update UserTheme table
        DB::table('UserThemes', 'master')->where('userThemeId', '=', $post['userThemeId'])
                                        ->where('companyId', '=', $post['companyId'])
                                        ->update(Array('themeId' => $post['theme_id']));

        if($post['widgetType'] == 'embedded') { 
            DB::table('EmbeddedBlockOptions', 'master')->where('userThemeId', '=', $post['userThemeId'])
                                                       ->where('embeddedBlockId', '=', $post['widgetOptionId'])
                                                       ->update(Array(
                                                           'type' => $post['embed_block_type']
                                                         , 'units' => $post['embed_units']
                                                         , 'width'  => $post['embed_width']
                                                         , 'height' => $post['embed_height']
                                                         , 'effectId' => $post['embed_effects']
                                                       ));
        }

        if($post['widgetType'] == 'modal') {  
            DB::table('ModalWindowOptions', 'master')->where('userThemeId', '=', $post['userThemeId'])
                                                       ->where('modalId', '=', $post['widgetOptionId'])
                                                       ->update(Array('effectId' => $post['modal_effects']));
        }
    }

}

class OptionFactory {

    private $embed_type, $post_contents;
    public $obj;

    public function __construct($post, $insert_id) { 

        $this->post_contents = $post;        

        $embed_type = $post['embed_type'];

        if($embed_type == 'embedded') { 
            $params = Array(
                'units'    => $post['embed_units']
              , 'type'     => $post['embed_block_type']
              , 'width'    => $post['embed_width']
              , 'height'   => $post['embed_height']
              , 'effectId' => $post['embed_effects']
              , 'userThemeId' => $insert_id
            );
            $this->obj = new EmbeddedBlockOptions($params);          
        }
           
        if($embed_type == 'fullpage') {
            $params = Array('units' => $post['full_page_units'], 'userThemeId' => $insert_id);
            $this->obj = new FullPageOptions($params);      
        }
       
        if($embed_type == 'modal') {
            $params = Array('effectId' => $post['modal_effects'], 'userThemeId' => $insert_id);
            $this->obj = new ModalWindowOptions($params);          
        }
    }

    public function returnObj() {
        return $this->obj;     
    }
}

abstract class Options {
    
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

    public $dbh;

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

class FullPageOptions extends Options { 
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
