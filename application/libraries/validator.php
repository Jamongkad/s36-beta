<?php

class Validator extends System\Validator {
    public function validate_s36email($attribute, $parameters) {
        $email = $this->attributes[$attribute];
        $companyId = $_GET['subdomain'];
        $admin = new \DBadmin; 

        $opts = new StdClass; 
        $opts->username = $email;
        $opts->options = Array('company' => $_GET['subdomain']);
        $result = $admin->fetch_admin_details($opts);
        return $result == 0;
    }
}
