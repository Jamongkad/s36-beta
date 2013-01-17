<?php namespace Feedback\Repositories;

use S36DataObject\S36DataObject, PDO, StdClass, Helpers, DB, S36Auth, Widget;
use \Feedback\Entities\FeedbackNode;

class DBFeedbackAdminReply extends S36DataObject {

	private $DB;
	private $table_name = 	"FeedbackAdminReply";
	public  $send_mail 	=	true;

	public function __construct() {
		$this->DB = DB::table($this->table_name);
	}

	public function set_send_mail($bool) {
		$this->send_mail = $bool;
	}

	public function add_admin_reply($data) {
		if($this->_check_fields($data) && $this->DB->insert($data)) {
			//get feedback author's email for sending email message
			$contact = DB::table('Feedback')
    				->left_join('Contact', 'Contact.contactId', '=', 'Feedback.contactId')
    				->where('Feedback.feedbackId','=',$data['feedbackId'])
    				->first(array('Contact.email'));

    		if(!empty($contact->email)) {
                $this->email_admin_reply($contact->email);
            }

			return true;
		} else {
			return false;
		}
	}

	public function get_admin_reply($id = null) {
		if(!empty($id)) {
			return $this->DB->where('feedbackId','=',$id)->first();
		} else {
			return DB::table($this->table_name)->get();
		}
	}

	public function update_admin_reply($data) {
		if($this->_check_fields($data)) {
			return $this->DB->where('feedbackId','=',$data['feedbackId'])->update($data);
		}
	}
	

	public function delete_admin_reply($id) {
		$adminReply = $this->get_admin_reply($id);
		if($adminReply) {
			return $this->DB->where('feedbackId','=',$id)->delete();
		}
	}

	public function email_admin_reply($to) {
		if($this->send_mail==true) {
			$subject	=	"Test Subject";
			$message	=	"Test Message";
			$headers 	= 	'From: no-reply@36stories.com' . "\r\n" .
    						'Reply-To: no-reply@36stories.com' . "\r\n";
			mail($to, $subject, $message, $headers);
		}
	}

	private function _check_fields($data) {
		$required = array('feedbackId','adminReply');
		$err = 0;
		foreach ($required as $key) {
			if(!array_key_exists($key, $data) && empty($data[$key])) {
				$err+=1;
			}
		}
		return ($err==0) ? true : false;
	}

}
