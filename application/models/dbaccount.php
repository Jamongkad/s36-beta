<?php

class DBAccount extends S36DataObject {
    public function create_account() {
        $sql = '
            START TRANSACTION;
                INSERT INTO Company (`name`, `planid`) VALUES("TheMathewClan", 1);
                SET @company_id = LAST_INSERT_ID();
                INSERT INTO Metric (`companyId`, `totalRequest`, `totalResponse`) VALUES(@company_id, 0, 0);
                INSERT INTO Site (`companyId`, `domain`, `name`, `defaultFormId`) VALUES(@company_id, "www.mathewklan.com", "mathewklan", 1);
                SET @site_id = LAST_INSERT_ID();
                INSERT INTO User (`companyId`, `username`, `confirmed`, `password`, `encryptString`, `email`, `fullName`, `title`, `imId`) 
                VALUES (@company_id, "mathew", 1, "[bcrypt]", "[bcrypt]", "wrm932@gmail.com", "Mathew Wong", "CEO", 1);
                SET @user_id = LAST_INSERT_ID();
                INSERT INTO AuthAssignment (`itemname`, `userid`) VALUES ("Admin", @user_id);
                INSERT INTO FeedbackBlock (`siteId`, `themeId`, `formId`) VALUES(@site_id, 1, 1);
                INSERT INTO Form (`siteId`, `themeId`, `scaleId`) VALUES(@site_id, 1, 2);
                INSERT INTO Category (`companyId`, `intName`, `name`, `changeable`) 
                VALUES
                (@company_id, "default", "General", 0)
                , (@company_id, "misc", "Miscelleanous", 1)
                , (@company_id, "price", "Price", 1)
                , (@company_id, "bugs", "Problems/Bugs", 1)
                , (@company_id, "suggestions", "Suggestions", 1);
            COMMIT;
        ';
        //$sth = $this->dbh->prepare($sql);
        //$sth->execute(); 
        //$this->dbh->query($sql);
        $this->dbh->beginTransaction();
        $this->dbh->exec('INSERT INTO Company (`name`, `planid`) VALUES("TheMathewClan", 1)');
        $this->dbh->rollBack();
    }
}
