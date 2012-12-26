<?php namespace Feedback\Entities;

use \Feedback\Entities\Types\FeedbackDataTypes;
use DB, Helpers, Package;
use SimpleArray;
Package::load('HTMLPurifier');

class FeedbackAttachments extends FeedbackDataTypes { 

  private $attachments;
  private $feedbackId;

    public function __construct(SimpleArray $post_data) {
        $this->post_data    = $post_data;
        $this->attachments  = $this->post_data->get('attachments');
    }

    public function generate_data() {
      $attachment_json = json_encode($this->attachments);
      return $attachment_json;
    }

}
