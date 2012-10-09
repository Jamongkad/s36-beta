
<?php

class DBCountry extends S36DataObject {
    
    public function get_country_list(){
    	return DB::table('Country')->order_by('name')->get();
    }
}

