<?php 

namespace Plan\Repositories;

use S36DataObject\S36DataObject, PDO, StdClass, Helpers, DB, S36Auth;

class DBPlan extends S36DataObject{


public function get_planInfo($planId = NULL){
		$tbl_plan = DB::table('Plan');
		$planInfo = (!empty($planId)) ? $tbl_plan->where('planid','=',$planId)->order_by('price','desc')->first() : $tbl_plan->order_by('price','desc')->get();
		@$planInfo->upgrade_images = $this->get_upgradePlanImages($planId);
		return $planInfo;
}


function get_upgradePlanImages($planId = NULL){		

	
	if(!empty($planId)):
	
		switch($planId){
			case 1://free
				$return = array(
					'current'=>'current-free',
					'upgrade'=>'upgrade-basic'					
					);
				break;
			case 2://Basic
				$return = array(
					'current'=> 'current-basic',
					'upgrade'=> 'upgrade-enhanced'					
					);
				break;
			case 3://Enhanced
				$return = array(
					'current'=> 'current-enhanced',
					'upgrade'=> 'upgrade-premium'					
					);
				break;
			case 4://Premium
				$return = array(
					'current'=> 'current-premium',
					'upgrade'=> false					
					);
				break;
		}//end switch
		return Helpers::arrayToObject($return);
	endif;
}


}//end class
