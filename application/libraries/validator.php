<?php

class Validator extends System\Validator {
    public function validate_s36email($attribute, $parameters) {
        $email = $this->attributes[$attribute];
        $companyId = $this->attributes['companyId'];
        $result = DB::Table('User', 'master')
                      ->where('email', '=', $email)
                      ->where('companyId', '=', $companyId)
                      ->count();
        return $result == 0;
    }
}
