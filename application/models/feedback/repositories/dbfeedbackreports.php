<?php namespace Feedback\Repositories;

use S36DataObject\S36DataObject, PDO, StdClass, Helpers, DB, S36Auth, Widget;
use \Feedback\Entities\FeedbackNode;
use \Profile\Services\ProfileImage;
use Underscore\Underscore;
use Exception;

class DBFeedbackReports extends S36DataObject {

	private $dbtable = "FeedbackReports";
	public $reportIp;
	public $reportTypes = array(
		 1 => "This information is incorrect"
	   , 2 => "Hate speech"
	   , 3 => "Sexually explicit content"
	   , 4 => "Violence or harmful behavior"
	   , 5 => "Spam or scam"
	   , 6 => "I don't like this post"
	   , 7 => "This post is violating intellectual property"
	);

	public function get_reportTypes(){
		return $this->reportTypes;
	}

    public function get_reports_by_companyid($company_id) { 
		$sql = "SELECT * FROM {$this->dbtable} WHERE companyId = :company_id";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':company_id', $company_id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        $storage = Array();
        foreach($result as $val) {

            $container = Array();
            $container['id']             = $val['id'];
            $container['companyid']      = $val['companyid'];
            $container['feedbackid']     = $val['feedbackid'];
            $container['reporttype']     = $this->reportTypes[$val['reporttype']];
            $container['reportip']       = $val['reportip'];
            $container['reportname']     = $val['reportname'];
            $container['reportemail']    = $val['reportemail'];
            $container['reportcompany']  = $val['reportcompany'];
            $container['reportcomments'] = $val['reportcomments'];

            $storage[] = $container;
        }
        print_r($container);
        return $container; 
    }

	public function get_feebackReport($feedbackId){
		$sql = "SELECT reportType,count(reportType) as count FROM {$this->dbtable} WHERE feedbackId = :feedback_id GROUP BY reportType";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':feedback_id', $feedbackId, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_CLASS);
        $data = array();
        if(!empty($result)){
        	$data['success'] = true;
	        $i=1;
	        $data['feedback_id'] = $feedbackId;
	        foreach ($result as $report) {
	        	$data['reports'][$i]['report_id'] 			= $report->reportType;
	        	$data['reports'][$i]['report_description'] 	= $this->reportTypes[$report->reportType];
	        	$data['reports'][$i]['report_count'] 		= $report->count;
	        	$i++;
	        }
	     }else{
	     	$data['success'] = false;
	     	$data['message'] = "reports not available";
	     }
	     return (object)$data;
	}

	public function addReport($data){
		$data['reportIp'] = Helpers::get_client_ip();
		if($this->_is_flagged($data)){
			$sql = "UPDATE FeedbackActions set flagged=1 WHERE ip_address = :report_ip and feedbackId = :feedback_id";
    	}else{
    		$sql = "INSERT INTO FeedbackActions (ip_address,feedbackId,flagged) VALUES(:report_ip, :feedback_id, 1)";
    	}

    	$sth = $this->dbh->prepare($sql);
        $sth->bindParam(':feedback_id', $data['feedbackId'], PDO::PARAM_INT);
        $sth->bindParam(':report_ip', $data['reportIp'], PDO::PARAM_STR);
        $feedbackAction 	= $sth->execute();

    	if($feedbackAction){
    		$sql = "INSERT IGNORE INTO {$this->dbtable} (feedbackId, reportType, reportIp, reportName, reportEmail, reportCompany, reportComments) VALUES (:feedback_id, :report_id, :report_ip, :report_name, :report_email, :report_company, :report_comments)";
    		$sth = $this->dbh->prepare($sql);
    		$sth->bindParam(':feedback_id', $data['feedbackId'], PDO::PARAM_INT);
    		$sth->bindParam(':report_id', $data['reportType'], PDO::PARAM_INT);
    		$sth->bindParam(':report_ip', $data['reportIp'], PDO::PARAM_INT);
	        $sth->bindParam(':report_name', $data['reportName'], PDO::PARAM_STR);
	        $sth->bindParam(':report_email', $data['reportEmail'], PDO::PARAM_STR);
	        $sth->bindParam(':report_company', $data['reportCompany'], PDO::PARAM_STR);
	        $sth->bindParam(':report_comments', $data['reportComments'], PDO::PARAM_STR);
	        $sth->execute();
	        return array('success'=>true,'message'=>'Success');
    	}else{
    		return array('success'=>false,'message'=>'Failed');
    	}
	}

	public function removeReport($data){

			$sql = "UPDATE FeedbackActions set flagged=NULL WHERE ip_address = :report_ip and feedbackId = :feedback_id";
			$sth = $this->dbh->prepare($sql);
	        $sth->bindParam(':feedback_id', $data['feedbackId'], PDO::PARAM_INT);
	        $sth->bindParam(':report_ip', $data['reportIp'], PDO::PARAM_STR);
	        $sth->execute();

			$sql = "DELETE FROM {$this->dbtable} WHERE feedbackId=:feedback_id and reportIp=:report_ip";
			$sth = $this->dbh->prepare($sql);
	        $sth->bindParam(':feedback_id', $data['feedbackId'], PDO::PARAM_INT);
	        $sth->bindParam(':report_ip', $data['reportIp'], PDO::PARAM_STR);
	        $sth->execute();

	        return array('success'=>true,'message'=>'Success');
	}
	private function _is_flagged($data){
		if(isset($data['feedbackId']) && isset($data['reportIp'])){
			$sql = "select * from FeedbackActions where feedbackId = :feedback_id and ip_address = :report_ip";
	        $sth = $this->dbh->prepare($sql);
	        $sth->bindParam(':feedback_id', $data['feedbackId'], PDO::PARAM_INT);
	        $sth->bindParam(':report_ip', $data['reportIp'], PDO::PARAM_STR);
	        $sth->execute();
	        if($sth->rowCount() > 0){
	        	return true;
	        }else{
	        	return false;
	        }
		}
	}
	private function _existing_report($data){
			$sql = "select feedbackId from {$this->dbtable} where feedbackId = :feedback_id and reportIp = :report_ip";
	        $sth = $this->dbh->prepare($sql);
	        $sth->bindParam(':feedback_id', $data['feedbackId'], PDO::PARAM_INT);
	        $sth->bindParam(':report_ip', $data['reportIp'], PDO::PARAM_STR);
	        $sth->execute();
	        if($sth->rowCount() > 0){
	        	return true;
	        }else{
	        	return false;
	        }
	}

	private function _check_fields($data) {
		$required = array('feedbackId','reportType','reportIp');
		$err = 0;
		foreach ($required as $key) {
			if(!array_key_exists($key, $data) && empty($data[$key])) {
				$err+=1;
			}
		}
		return ($err==0) ? true : false;
	}
}
