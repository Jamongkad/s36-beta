<?php namespace Company\Repositories;

use S36DataObject\S36DataObject;
use Helpers, DB, S36Auth;
use PDO, StdClass;

class DBCompany extends S36DataObject {

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
                //'description'         => $post->company_desc
                'fullpageCompanyName' => $post->fullpagecompanyname 
                , 'website_link'        => $post->website_link
                , 'logo'                => $post->logo
            )); 
        
        // description is now on HostedSettings.
        DB::table('HostedSettings')
            ->where('companyId', '=', $post->companyid)
            ->update(array('description' => $post->company_desc));
    }

    public function get_company_info($company_id = Null) {
        $company_id = (!empty($this->company_id)) ? $this->company_id : $company_id;
        if(is_numeric($company_id)) {
            $company_sql = "Company.companyId = :company_id";
        } else { 
            $company_sql = "Company.name = :company_id";
        }

        $sql = "
            SELECT 
                * 
                , Company.name AS company_name 
                , (SELECT AVG(rating) FROM Feedback WHERE Feedback.companyId = Company.companyId) AS avg_rating
                , (SELECT COUNT(*) FROM Feedback WHERE Feedback.companyId = Company.companyId) AS total_feedback
                , (SELECT COUNT(*) FROM Feedback WHERE Feedback.companyId = Company.companyId AND isRecommended = 1) AS total_recommendations
                , WidgetStore.widgetKey
            FROM 
                Company
            INNER JOIN
                Site
                    ON Site.companyId = Company.companyId
            LEFT JOIN
                WidgetStore
                    ON WidgetStore.companyId = Company.companyId
                   AND WidgetStore.isDefault = 1
                   AND WidgetStore.widgetType = 'submit'
            LEFT JOIN
                HostedSettings
                    ON HostedSettings.companyId = Company.companyId
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
    
    public function get_account_owner($id = Null){
    	$user 		= S36Auth::user();
		$company_id = (!empty($id) && is_numeric($id)) ? $id :$user->companyid; 	
    	return DB::table('User')
    			->where('companyId','=',$company_id)
    			->where('account_owner','=',1)
    			->first();
    }
    
    //this method is to be used regardless of user session is set or not
    public function get_account_users() {

        $cols = Array(
            'userid',
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
		);

        return DB::table('User') 
                ->or_where('name', '=', $this->company_name)
                ->get($cols);
    }
    
    public function update_plan($planId){
        $result = DB::table('Company')
            ->where('companyId', '=', $this->company_id)
            ->update(array('planId' => $planId));
        return $result;
    }
    
    public function update_bt_customer_id($id){
        return DB::table('Company')
            ->where('companyId', '=', $this->company_id)
            ->update(array('bt_customer_id' => $id));
    }

    public function update_coverphoto($data){
        $updated = DB::table('Company')
            ->where('companyId', '=', $data['company_id'])
            ->update(array('coverphoto_src' => $data['file_name'], 'coverphoto_top' => $data['top']));  
        
        $result = new StdClass;
        $result->company_id     = $data['company_id'];
        $result->src            = $data['file_name'];
        $result->top            = $data['top'];
        $result->update_success = $updated;
        return $result;
    }
     
    // update description from hosted page.
    public function update_desc($data, $company_id){        
        // don't save if there's no input.
        if( array_key_exists('description', $data) ){
            DB::table('Company')->where('companyId', '=', $company_id)->update( array('description' => $data['description']) );
        } 
    }
     
    // increment page view count.
    public function incr_page_view($company_id){ 
        DB::query('UPDATE Company SET page_view = page_view + 1 WHERE companyId = ?', array($company_id)); 
    }
}
