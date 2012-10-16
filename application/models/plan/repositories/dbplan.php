<?php 

namespace Plan\Repositories;

use S36DataObject\S36DataObject, PDO, StdClass, Helpers, DB, S36Auth;

class DBPlan extends S36DataObject{


public function get_planInfo($planId = NULL){
		if(!empty($planId)){
			$planInfo = DB::table('Plan')->where('planid','=',$planId)
										->or_where('name','=',$planId)
										->order_by('price','desc')->first();
			$planInfo->upgrade_images = $this->get_upgradePlanImages($planInfo->planid);
			return $planInfo;
		}
		else{
			return DB::table('Plan')->order_by('price','desc')->get();
		}
}

public function get_upgradePlanImages($planId = NULL){		

	
	if(!empty($planId)):
	
		switch($planId){
			case 1:
				$return = array(
					'current'=>'current-free',
					'upgrade'=>'upgrade-basic'					
					);
				break;
			case 2:
				$return = array(
					'current'=> 'current-basic',
					'upgrade'=> 'upgrade-enhanced'					
					);
				break;
			case 3:
				$return = array(
					'current'=> 'current-enhanced',
					'upgrade'=> 'upgrade-premium'					
					);
				break;
			case 4:
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
