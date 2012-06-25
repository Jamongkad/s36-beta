<?php namespace Feedback\Services;

use Feedback\Repositories\DBFeedback, Halcyonic, DBBadWords;
use S36Auth, Input, Exception, Helpers, DB, StdClass;

class FeedbackService {
    public function __construct(DBFeedback $dbfeedback, DBBadWords $dbbadwords) {
        $this->dbfeedback = $dbfeedback;     
        $this->dbbadwords = $dbbadwords;
    }

    public function save_feedback($post) {
        $http_check = Helpers::contains_tld(strip_tags($post->feedback_text));
        if($http_check) {
            echo "Mathew";
        } else {            
            $text = Helpers::html_cleaner($post->feedback_text);
            $feed_id = $post->feed_id;
            $profanity = $this->dbbadwords->profanity_detection($text);         
            return $this->dbfeedback->update_feedback_text($feed_id, $text, $profanity);
        }
    }
}
