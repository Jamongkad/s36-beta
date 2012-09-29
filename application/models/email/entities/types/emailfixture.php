<?php namespace Email\Entities\Types;

use PostMark;

abstract class EmailFixture {

    public $postmark;
    private $address, $feedback_data;

    public function __construct() {
        $this->postmark = new PostMark("11c0c3be-3d0c-47b2-99a6-02fb1c4eed71", "news@36stories.com", "ryanchua6@gmail.com,wrm932@gmail.com,klemengkid@gmail.com,");       
    }

    public function gather($email_data) {}
    public function send() {}
    public function get_subject() {}
}
