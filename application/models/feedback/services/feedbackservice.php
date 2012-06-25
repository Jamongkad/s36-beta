<?php namespace Feedback\Services;

use Feedback\Repositories\DBFeedback, Halcyonic, DBBadWords;
use UrlLinker;
use S36Auth, Input, Exception, Helpers, DB, StdClass;

class FeedbackService {
    public function __construct(DBFeedback $dbfeedback, DBBadWords $dbbadwords) {
        $this->dbfeedback = $dbfeedback;     
        $this->dbbadwords = $dbbadwords;
    }

    public function save_feedback($post) {
        $str = html_escape_linkurls($post->feedback_text);
        Helpers::dump($str);
        //return Helpers::html_cleaner( $post->feedback_text );
        /*
        $text = Helpers::html_cleaner($post->feedback_text);
        $feed_id = $post->feed_id;
        $profanity = $this->dbbadwords->profanity_detection($text);         
        return $this->dbfeedback->update_feedback_text($feed_id, $text, $profanity);
        */
    }
}
