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

    public function update_feedback($id,array $field = null){
    $feedback = $this->dbfeedback->pull_feedback_by_id($id);
    /*setup fields*/
    $fields['siteId']          = (isset($field['siteId']))          ? $field['siteId']          : $feedback->siteid;
    $fields['categoryId']      = (isset($field['categoryId']))      ? $field['categoryId']      : $feedback->categoryid;
    $fields['status']          = (isset($field['status']))          ? $field['status']          : $feedback->status;
    $fields['rating']          = (isset($field['rating']))          ? $field['rating']          : $feedback->rating;
    $fields['text']            = (isset($field['text']))            ? $field['text']            : $feedback->text;
    $fields['priority']        = (isset($field['priority']))        ? $field['priority']        : $feedback->priority;
    $fields['permission']      = (isset($field['permission']))      ? $field['permission']      : $feedback->permission;
    $fields['isFeatured']      = (isset($field['isFeatured']))      ? $field['isFeatured']      : $feedback->isfeatured;
    $fields['isFlagged']       = (isset($field['isFlagged']))       ? $field['isFlagged']       : $feedback->isflagged;
    $fields['isPublished']     = (isset($field['isPublished']))     ? $field['isPublished']     : $feedback->ispublished;
    $fields['isArchived']      = (isset($field['isArchived']))      ? $field['isArchived']      : $feedback->isarchived;
    $fields['isSticked']       = (isset($field['isSticked']))       ? $field['isSticked']       : $feedback->issticked;
    $fields['isDeleted']       = (isset($field['isDeleted']))       ? $field['isDeleted']       : $feedback->isdeleted;
    $fields['displayName']     = (isset($field['displayName']))     ? $field['displayName']     : $feedback->displayname;
    $fields['displayImg']      = (isset($field['displayImg']))      ? $field['displayImg']      : $feedback->displayimg;
    $fields['displayCompany']  = (isset($field['displayCompany']))  ? $field['displayCompany']  : $feedback->displaycompany;
    $fields['displayPosition'] = (isset($field['displayPosition'])) ? $field['displayPosition'] : $feedback->displayposition;
    $fields['displayURL']      = (isset($field['displayURL']))      ? $field['displayURL']      : $feedback->displayurl;
    $fields['displayCountry']  = (isset($field['displayCountry']))  ? $field['displayCountry']  : $feedback->displaycountry;
    $fields['displaySbmtDate'] = (isset($field['displaySbmtDate'])) ? $field['displaySbmtDate'] : $feedback->displaysbmtdate;
    return $this->dbfeedback->update_feedback($id,$fields);
    }

   
}
