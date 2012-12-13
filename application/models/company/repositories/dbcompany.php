<?php namespace Company\Repositories;

use S36DataObject\S36DataObject, PDO, StdClass, Helpers, DB, S36Auth;

class DBCompany extends S36DataObject {

    var $companyId;

    public function set_companyId($id) {
        $this->companyId = $id;     
    }

    public function update_company_emails($post) {
        DB::Table('Company', 'master') 
            ->where('companyId', '=', $post->companyid)
            ->update(Array(
                'ffEmail1' => $post->ffEmail1
              , 'ffEmail2' => $post->ffEmail2
              , 'ffEmail3' => $post->ffEmail3
              , 'alias1' => $post->alias1
              , 'alias2' => $post->alias2
              , 'alias3' => $post->alias3
              , 'replyTo' => $post->replyTo
            ));
    }

    public function update_companyinfo($post) {
        //do an update 
        DB::Table('Company', 'master')
            ->where('companyId', '=', $post->companyid)
            ->update(Array( 
                'description'         => $post->company_desc
              , 'fullpageCompanyName' => $post->fullpagecompanyname 
              , 'facebook_username'   => $post->facebook_username
              , 'twitter_username'    => $post->twitter_username
              , 'website_link'        => $post->website_link
              , 'logo'                => $post->logo
            )); 
    }

    public function get_company_info($company_id = null) {
        $company_id = (!empty($this->companyId)) ? $this->companyId : $company_id;
        if(is_numeric($company_id)) {
            $company_sql = "Company.companyId = :company_id";
        } else { 
            $company_sql = "Company.name = :company_id";
        }
        /*
        $sql = "
            SELECT 
                * 
                , Company.name AS company_name 
                , (SELECT AVG(rating) FROM Feedback WHERE siteId = Site.siteId) AS avg_rating
            FROM 
                Company
            INNER JOIN
                Site
                    ON Site.companyId = Company.companyId
            WHERE 1=1
                AND $company_sql
            LIMIT 1
        ";
        */
        $sql = "
            SELECT 
                * 
                , Company.name AS company_name 
                , (SELECT AVG(rating) FROM Feedback WHERE Feedback.companyId = Company.companyId) AS avg_rating
            FROM 
                Company
            INNER JOIN
                Site
                    ON Site.companyId = Company.companyId
            WHERE 1=1
                AND $company_sql
            LIMIT 1
        ";
        
        $sth = $this->dbh->prepare($sql);     

        $sth->bindParam(':company_id', $company_id);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_OBJ);
        return $result;
    } 
    
    public function get_account_owner($id = NULL){
    	$user 		= S36Auth::user();
		$company_id = (!empty($id) && is_numeric($id)) ? $id :$user->companyid; 	
    	return DB::table('User')
    			->where('companyId','=',$company_id)
    			->where('account_owner','=',1)
    			->first();
    }

    public function get_account_user($company_id = NULL){
		$company_id = (!empty($this->companyId)) ? $this->companyId : $company_id;
		if(!empty($company_id) && is_numeric($company_id)):
    		return DB::table('User')
    				->where('companyId','=',$company_id)
    				->get(
						array('userid',
							'companyid',
							'username',
							'account_owner',
							'email',
							'fullname',
							'title',
							'phone',
							'ext',
							'mobile',
							'fax',
							'home',
							'im',
							'imid',
							'avatar'
							)    			
    			);
    	endif;
    }
    
    public function update_plan($planId){
        $user = S36Auth::user();
        $result = DB::table('Company')
            ->where('companyId','=',$user->companyid)
            ->update(array('planId'=>$planId));
        return $result;
    }
    
    public function update_bt_customer_id($id){
        $user = S36Auth::user();
        return DB::table('Company')
            ->where('companyId','=',$user->companyid)
            ->update(array('bt_customer_id'=>$id));
    }

    public function update_coverphoto($data){

        $src = (isset($data['src'])) ? $data['src'] : null;
        $top = (isset($data['top'])) ? $data['top'] : 0;
        $company_id = $data['company_id'];

        $existing_cover_photo = DB::table('Company')
            ->where('companyId', '=', $company_id)
            ->first(Array('coverphoto_src'));

        $updated = DB::table('Company')
            ->where('companyId', '=', $company_id)
            ->update(array('coverphoto_src' => $src, 'coverphoto_top' => $top));   
        

        if($existing_cover_photo->coverphoto_src) {
            unlink($existing_cover_photo->coverphoto_src);
        }

        $result = new StdClass;
        $result->company_id = $company_id;
        $result->src = $src;
        $result->top = $top;
        $result->update_success = $updated;
        return $result;
    }
    
    
    public function update_desc_header($data, $company_id){
        
        // don't proceed if there's no input.
        if( ! array_key_exists('description', $data) ) return;
        if( ! array_key_exists('header_text', $data) ) return;
        
        DB::table('Company')->where('companyId', '=', $company_id)->update( array('description' => $data['description']) );
        DB::table('HostedSettings')->where('companyId', '=', $company_id)->update( array('header_text' => $data['header_text']) );
        
    }
}
