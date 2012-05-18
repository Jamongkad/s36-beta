<?php

class DBAccount extends S36DataObject {

    public $dbh, $user_id;

    public function __construct() { 
        $this->dbh = DB::connection('master')->pdo;

        if (S36Auth::check()) {
            $this->user_id = S36Auth::user()->userid;             
        } 
    }

    public function create_account() {
        
        $encrypt = new Crypter;
        $password_string = "bimshop668";
        $password = crypt($password_string);
        $name = $this->escape("Bimshop");
        $email = $this->escape("bimshop@gmail.com");
        $encrypt_string = $encrypt->encrypt($email."|".$password_string);
        $company = $this->escape("Bimshop");
        $bill_to = "Bimshop, LLC";
        $fullName = $this->escape("Bimshop");
        $site = $this->escape("www.bimshop.com");
        $site_name = $this->escape("Bimshop");
        
        if($this->company($company)) {
            throw new Exception("The company $company already exists.");
        } else {  
            print_r("Creating New Account<br/>");
            $this->dbh->beginTransaction();
            $this->dbh->query('INSERT INTO Company (`name`, `planid`, `billTo`) VALUES("'.$company.'", 1, "'.$bill_to.'")');
            $this->dbh->query('SET @company_id = LAST_INSERT_ID()');
            $this->dbh->query('INSERT INTO Metric (`companyId`, `totalRequest`, `totalResponse`) VALUES(@company_id, 0, 0)'); 
            $this->dbh->query('INSERT INTO Site (`companyId`, `domain`, `name`, `defaultFormId`) VALUES(@company_id, "'.$site.'", "'.$site_name.'", 1)');   
            $this->dbh->query('SET @site_id = LAST_INSERT_ID()');
            $this->dbh->query('INSERT INTO User (`companyId`, `username`, `account_owner`,`confirmed`, `password`, `encryptString`, `email`, `fullName`, `title`, `imId`)  
                               VALUES (@company_id, "'.$name.'", 1, 1, "'.$password.'", "'.$encrypt_string.'", "'.$email.'", "'.$fullName.'", "CEO", 1)');
            $this->dbh->query('SET @user_id = LAST_INSERT_ID()');
            $this->dbh->query('INSERT INTO AuthAssignment (`itemname`, `userid`) VALUES ("Admin", @user_id)');
            $this->dbh->query('INSERT INTO Category (`companyId`, `intName`, `name`, `changeable`) 
                               VALUES
                                  (@company_id, "default", "Inbox", 0) 
                                , (@company_id, "general", "General", 1)
                                , (@company_id, "misc", "Miscelleanous", 1)
                                , (@company_id, "price", "Price", 1)
                                , (@company_id, "bugs", "Problems/Bugs", 1)
                                , (@company_id, "suggestions", "Suggestions", 1)');
            $this->dbh->commit();
            
            $company_info = $this->company($company);
            $site_id = $company_info->siteid;
            $company_id = $company_info->companyid;

            $form = new Widget\Entities\FormWidget;
            $form->make_default = True;

            $form_data = (object) Array(
                'widgetkey'   => False
              , 'widget_type' => 'submit'
              , 'site_id'     => $site_id 
              , 'company_id' => $company_id
              , 'theme_type' => 'form-aglow'
              , 'theme_name' => "$company Default"
              , 'embed_type' => 'form'
              , 'submit_form_text'     => 'Please gives us your feedback'
              , 'submit_form_question' => 'What are your thoughts about our product/services?'
              , 'tab_pos'  => 'side'
              , 'tab_type' => 'tab-l-aglow'
            );

            $form->set_widgetdata($form_data);
            $form->save();
            print_r("SUCCESSFUL");
        }

    }

    public function company($company) {
        $sql = "
            SELECT  
                Company.companyId
              , Site.siteId
            FROM 
                Company 
            INNER JOIN
                Site
                    ON Site.companyId = Company.companyId
            WHERE 1=1
                AND Company.name = :company_name
        ";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':company_name', $company);
        $sth->execute(); 
        $result = $sth->fetch(PDO::FETCH_OBJ);
        return $result;
    }
}
