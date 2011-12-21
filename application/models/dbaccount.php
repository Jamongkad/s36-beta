<?php

class DBAccount extends S36DataObject {

    public $dbh, $user_id;

    public function __construct() { 
        $this->dbh = DB::connection('master')->pdo;

        if(S36Auth::check())
            $this->user_id = S36Auth::user()->userid;        
    }

    public function create_account() {
        
        $encrypt = new Crypter;
        $password_string = "p455w0rd";
        $password = crypt($password_string);
        $email = "wrm932@gmail.com";

        $this->dbh->beginTransaction();
        $this->dbh->query('INSERT INTO Company (`name`, `planid`) VALUES("TheMathewClan", 1)');
        $this->dbh->query('SET @company_id = LAST_INSERT_ID()');
        $this->dbh->query('INSERT INTO Metric (`companyId`, `totalRequest`, `totalResponse`) VALUES(@company_id, 0, 0)'); 
        $this->dbh->query('INSERT INTO Site (`companyId`, `domain`, `name`, `defaultFormId`) VALUES(@company_id, "www.mathewklan.com", "mathewklan", 1)');          
        $this->dbh->query('SET @site_id = LAST_INSERT_ID()');
        $this->dbh->query('INSERT INTO User (`companyId`, `username`, `confirmed`, `password`, `encryptString`, `email`, `fullName`, `title`, `imId`)  
                           VALUES (@company_id, "mathew", 1, "'.$this->escape($password).'", "'.$this->escape($encrypt->encrypt($email."|".$password_string)).'", "'.$this->escape($email).'", "Mathew Wong", "CEO", 1)');
        $this->dbh->query('SET @user_id = LAST_INSERT_ID()');
        $this->dbh->query('INSERT INTO AuthAssignment (`itemname`, `userid`) VALUES ("Admin", @user_id)');
        $this->dbh->query('INSERT INTO FeedbackBlock (`siteId`, `themeId`, `formId`) VALUES(@site_id, 1, 1)');
        $this->dbh->query('INSERT INTO Form (`siteId`, `themeId`, `scaleId`) VALUES(@site_id, 1, 2)');
        $this->dbh->query('INSERT INTO Category (`companyId`, `intName`, `name`, `changeable`) 
                           VALUES
                              (@company_id, "default", "General", 0)
                            , (@company_id, "misc", "Miscelleanous", 1)
                            , (@company_id, "price", "Price", 1)
                            , (@company_id, "bugs", "Problems/Bugs", 1)
                            , (@company_id, "suggestions", "Suggestions", 1)');
        $this->dbh->commit();
    }
}
