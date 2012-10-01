<?php

class DBMetric extends S36DataObject {
    
    public $company_id;

    public function fetch_metrics() {
        $sql = "SELECT 
                * 
                FROM 
                    Metric
                WHERE 1=1
                    AND Metric.companyId = :company_id";

        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':company_id', $this->company_id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function increment_request() {
        $sql = "UPDATE Metric 
                    SET totalRequest = totalRequest + 1
                WHERE 1=1
                    AND Metric.companyId = :company_id";

        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':company_id', $this->company_id, PDO::PARAM_INT);
        $sth->execute();
    }

    public function increment_response() {
        $sql = "UPDATE Metric 
                    SET totalResponse = totalResponse + 1
                WHERE 1=1
                    AND Metric.companyId = :company_id";

        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':company_id', $this->company_id, PDO::PARAM_INT);
        $sth->execute();
    }
}
