<?php

class BadWords extends S36DataObject { 
    public function profanity_detection($bad_words) {
        $sth = $this->dbh->prepare(" 
            SELECT  
                BadWords.word
            FROM 
                BadWords 
            WHERE 1=1          
                AND :bad_words LIKE CONCAT('%', BadWords.word, '%')
        ");
        $sth->bindParam(':bad_words', $bad_words, PDO::PARAM_STR);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_CLASS);
        return $result;
    }
}
