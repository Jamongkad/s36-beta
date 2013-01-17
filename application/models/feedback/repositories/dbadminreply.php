<?php namespace Feedback\Repositories;
use PDO, StdClass;
use S36DataObject\S36DataObject, Helpers, DB, S36Auth, Widget, URL;
use \Feedback\Entities\FeedbackNode, \Feedback\Repositories\DBFeedback;
use \Email\Services\EmailService, \Email\Entities\ReplyData;

class DBAdminReply extends S36DataObject {

	private $DB;
	private $table_name = 	"FeedbackAdminReply";
	public  $send_mail 	=	true;

	public function __construct() {
        parent::__construct();
		$this->DB = DB::table($this->table_name);
        $this->dbfeedback = new DBFeedback;
	}

	public function set_send_mail($bool) {
		$this->send_mail = $bool;
	}

    public function insert_admin_reply($data) {
        $sql = "INSERT IGNORE INTO {$this->table_name} (feedbackId, adminReply) VALUES (:feedback_id, :admin_reply)";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':feedback_id', $data['feedbackId'], PDO::PARAM_INT);
        $sth->bindParam(':admin_reply', $data['adminReply'], PDO::PARAM_STR);
        return $sth->execute();
    }

	public function add_admin_reply($data) {
        $feedback_id = $data['feedbackId'];
		if($this->_check_fields($data) && !$this->get_admin_reply($feedback_id)) {
			//get feedback author's email for sending email message   
            $this->insert_admin_reply($data);
			$contact = DB::table('Feedback')
    				->left_join('Contact', 'Contact.contactId', '=', 'Feedback.contactId')
    				->where('Feedback.feedbackId', '=', $feedback_id)
    				->first(array('Contact.email'));
            
    		if(!empty($contact->email)) {
                $this->email_admin_reply($contact->email, $feedback_id);
            }
        }
	}

	public function get_admin_reply($feedback_id) {
	    return $this->DB->where('feedbackId', '= ', $feedback_id)->first();
    }

	public function update_admin_reply($data) {
		if($this->_check_fields($data)) {
			return $this->DB->where('feedbackId', '=', $data['feedbackId'])->update($data);
		}
	}
	
	public function delete_admin_reply($id) {
		$adminReply = $this->get_admin_reply($id);
		if($adminReply) {
			return $this->DB->where('feedbackId', '=', $id)->delete();
		}
	}

	public function email_admin_reply($to, $feedback_id) {
		if($this->send_mail==true) {
            $replydata = new ReplyData; 
            $replydata->subject("and wanted you to know that we posted it on our website.")
                      ->sendto($to)
                      ->from( 
                          (object) Array(
                            "replyto" => $this->email 
                          , "username"  => ucfirst($this->username)
                          ) 
                        )
                      ->message("Hi we featured and replied to your feedback check it out <a href='".URL::to('/')."'>on our website</a>.")
                      ->feedbackdata($this->dbfeedback->pull_feedback_by_id($feedback_id));            
     
            $emailservice = new EmailService($replydata);  
            return $emailservice->send_email(); 
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
