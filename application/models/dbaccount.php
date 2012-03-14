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
        $password_string = "p455w0rd";

        $password = crypt($password_string);
        $email = $this->quote("ryanchua6@gmail.com");
        $encrypt_string = $encrypt->encrypt($email."|".$password_string);
        $company = $this->quote("ryan");
        $fullName = $this->quote("Mathew Wong");
        $site = $this->quote("www.mathewklan.com");
        $site_name = $this->quote("mathewklan");

        $this->dbh->beginTransaction();
        $this->dbh->query('INSERT INTO Company (`name`, `planid`) VALUES("'.$company.'", 1)');
        $this->dbh->query('SET @company_id = LAST_INSERT_ID()');
        $this->dbh->query('INSERT INTO Metric (`companyId`, `totalRequest`, `totalResponse`) VALUES(@company_id, 0, 0)'); 
        $this->dbh->query('INSERT INTO Site (`companyId`, `domain`, `name`, `defaultFormId`) VALUES(@company_id, "'.$site.'", "'.$site_name.'", 1)');   
        $this->dbh->query('SET @site_id = LAST_INSERT_ID()');
        $this->dbh->query('INSERT INTO User (`companyId`, `username`, `confirmed`, `password`, `encryptString`, `email`, `fullName`, `title`, `imId`)  
                           VALUES (@company_id, "mathew", 1, "'.$password.'", "'.$encrypt_string.'", "'.$email.'", "'.$fullName.'", "CEO", 1)');
        $this->dbh->query('SET @user_id = LAST_INSERT_ID()');
        $this->dbh->query('INSERT INTO AuthAssignment (`itemname`, `userid`) VALUES ("Admin", @user_id)');
        //$this->dbh->query('INSERT INTO FeedbackBlock (`siteId`, `themeId`, `formId`) VALUES(@site_id, 1, 1)');
        $this->dbh->query('INSERT INTO Category (`companyId`, `intName`, `name`, `changeable`) 
                           VALUES
                              (@company_id, "default", "Inbox", 0) 
                            , (@company_id, "general", "General", 1)
                            , (@company_id, "misc", "Miscelleanous", 1)
                            , (@company_id, "price", "Price", 1)
                            , (@company_id, "bugs", "Problems/Bugs", 1)
                            , (@company_id, "suggestions", "Suggestions", 1)');
        $this->dbh->commit();
    }
}
