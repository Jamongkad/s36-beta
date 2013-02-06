<?php namespace Hosted\Repositories;

use S36DataObject\S36DataObject, PDO, StdClass, Helpers, DB, S36Auth, Exception;

class DBHostedSettings extends S36DataObject {

    private $hosted_settings;
    private $admin_panel_fields = array(
        'background_image',
        'page_bg_position',
        'page_bg_repeat',
        'page_bg_color',
        'page_bg_color_opacity',
        'show_rating',
        'show_votes',
        'show_recommendation',
        'show_metadata',
        'show_admin_comment',
        'show_sharing_option',
        'show_flag_inapp',
        'show_first_name',
        'show_last_name',
        'show_position',
        'show_company',
        'show_city',
        'show_country',
        'show_flag',
        'show_image_attachment',
        'show_video_attachment',
        'description',
        'button_bg_color',
        'button_hover_bg_color',
        'button_font_color',
        'facebook_url',
        'twitter_url',
    );

    public function set_hosted_settings($hosted_settings)  {
        $this->hosted_settings = $hosted_settings;    
    }

    public function save() { 
        if($this->hosted_settings) { 
            if(!$this->record_exists()) 
                DB::table('HostedSettings', $this->db_name)->insert($this->hosted_settings);           
            else
                $this->update();
        } else {
            throw new Exception("Please provided a Hosted Settings array.");
        }
    } 

    public function update() {
        $sql = "UPDATE HostedSettings 
                    SET 
                        theme_name = :theme_name
                      , header_text = :header_text 
                      , submit_form_text = :submit_form_text 
                      , submit_form_question = :submit_form_question
                      , background_image = :background_image
                WHERE 1=1 
                    AND companyId = :company_id";

        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':company_id', $this->hosted_settings['company_id'], PDO::PARAM_INT);       
        $sth->bindParam(':theme_name', $this->hosted_settings['theme_name'], PDO::PARAM_STR);
        $sth->bindParam(':header_text', $this->hosted_settings['header_text'], PDO::PARAM_STR);       
        $sth->bindParam(':submit_form_text', $this->hosted_settings['submit_form_text'], PDO::PARAM_STR);       
        $sth->bindParam(':submit_form_question', $this->hosted_settings['submit_form_question'], PDO::PARAM_STR);
        $sth->bindParam(':background_image', $this->hosted_settings['background_image'], PDO::PARAM_STR);       
        $sth->execute();
    }

    public function record_exists() {
        $sql = "SELECT 
                    HostedSettings.companyId
                  , HostedSettings.theme_name
                  , HostedSettings.header_text
                  , HostedSettings.submit_form_text
                  , HostedSettings.background_image
                  , HostedSettings.autopost_enable
                  , HostedSettings.autopost_rating
                  , TRIM(HostedSettings.submit_form_question) AS submit_form_question
                  , Themes.theme_css
                  , Themes.theme_js
                FROM 
                    HostedSettings 
                INNER JOIN
                    Themes
                        ON HostedSettings.theme_name = Themes.theme_name
                WHERE 1=1 
                    AND companyId = :company_id";

        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':company_id', $this->hosted_settings['company_id'], PDO::PARAM_INT);       
        $sth->execute();

        return $sth->fetch(PDO::FETCH_OBJ);
    }
    
    //a much straightforward method of fetching hosted settings
    public function fetch_hosted_settings($company_id) { 
        $sql = "SELECT 
                    HostedSettings.companyId
                  , HostedSettings.theme_name
                  , HostedSettings.header_text
                  , HostedSettings.submit_form_text
                  , HostedSettings.background_image
                  , HostedSettings.autopost_enable
                  , HostedSettings.autopost_rating
                  , TRIM(HostedSettings.submit_form_question) AS submit_form_question
                  , Themes.theme_css
                  , Themes.theme_js
                FROM 
                    HostedSettings 
                INNER JOIN
                    Themes
                        ON HostedSettings.theme_name = Themes.theme_name
                WHERE 1=1 
                    AND companyId = :company_id";

        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':company_id', $company_id, PDO::PARAM_INT);       
        $sth->execute();

        return $sth->fetch(PDO::FETCH_OBJ);
    }
    
    //this method makes more sense....retrieves hosted settings
    public function hosted_settings() {
        return $this->record_exists();
    }

    public function update_autoposting($data){
        return DB::table('HostedSettings')->where('companyId', '=' ,$data['companyid'])->update($data); 
    }
    
    
    // get admin panel settings.
    public function get_panel_settings($company_id, $type = null){
        
        $result = Db::table('HostedSettings')->where('companyId', '=', $company_id)->first( $this->admin_panel_fields );
        return ( $type == 'json' ? json_encode($result) : $result ) ;
        
    }
    
    
    // update admin panel settings.
    public function update_panel_settings($company_id, $data){
        
        // only data with valid fields should be saved.
        
        // create dummy values for panel fields so it can be used in array_intersect_key().
        $panel_fields = array_combine($this->admin_panel_fields, range(1, count($this->admin_panel_fields)) );
        
        // get only the data with valid keys.
        $valid_data = array_intersect_key((array)$data, $panel_fields);
        
        // extra validatios on some fields.
        
        // now update db with the selected fields.
        // reminder: laravel automatically escapes all values.
        Db::table('HostedSettings')->where('companyId', '=', $company_id)->update( $valid_data );
        
    }
    
    
    // update description from hosted page.
    public function update_desc($data, $company_id){        
        // don't save if there's no input.
        if( array_key_exists('description', $data) ){
            DB::table('HostedSettings')->where('companyId', '=', $company_id)->update( array('description' => $data['description']) );
        } 
    }
    
}
