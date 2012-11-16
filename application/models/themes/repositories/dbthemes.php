<?php namespace Themes\Repositories;

use S36DataObject\S36DataObject, PDO, StdClass, Helpers, DB, S36Auth;

class DBThemes extends S36DataObject {

    private $table_name  = 'Themes';

	public function get_themes() {
		return DB::table($this->table_name)->get();
	}

	public function get_theme_by_name($name) {
		return DB::table($this->table_name)->where('theme_name', '=', $name)->first();
	}
}
