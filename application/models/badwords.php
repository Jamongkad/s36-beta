<?php

class BadWords extends S36DataObject { 
    public function profanity_detection($bad_words, $feedback_id) {
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
        $isProfane = $sth->fetchAll(PDO::FETCH_CLASS);

        DB::table('Feedback', 'master')
             ->where('feedbackId', '=', $feedback_id)
             ->update(Array(
                          'text' => $bad_words
                        , 'hasProfanity' => ($isProfane) ? 1 : 0
                      ));

    }
}
