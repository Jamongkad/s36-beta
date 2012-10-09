<?php namespace Feedback\Services;

use Feedback\Repositories\DBFeedback, DBBadWords;
use Exception, Helpers;

class FeedbackService {
    public function __construct(DBFeedback $dbfeedback, DBBadWords $dbbadwords) {
        $this->dbfeedback = $dbfeedback;     
        $this->dbbadwords = $dbbadwords;
    }

    public function save_feedback($post) {
        $tld_check = Helpers::contains_tld(strip_tags($post->feedback_text));
        if($tld_check) {
            echo json_encode(Array("error" => "Your text contains http links. Please edit your feedback without them."));
        } else {            
            $text = Helpers::html_cleaner($post->feedback_text);
            $feed_id = $post->feed_id;
            $profanity = $this->dbbadwords->profanity_detection($text);         
            return $this->dbfeedback->update_feedback_text($feed_id, $text, $profanity);
        }
    }
}
