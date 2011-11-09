<?php

class Admin extends S36DataObject {
    public $input_data; 
    public $perms_data;

    private function _extract_personal_data()   {
       $encrypt = new Crypter;

       return Array(
           'username' => strtolower($this->input_data->username)
         , 'fullName' => $this->input_data->fullName
         , 'email' => $this->input_data->email
         , 'password' => crypt($this->input_data->password)
         , 'encryptString' => $encrypt->encrypt(strtolower($this->input_data->username)."|".$this->input_data->password)
         , 'companyId' => $this->input_data->companyId
         , 'title' => $this->input_data->title
         , 'ext' => $this->input_data->ext
         , 'mobile' => $this->input_data->mobile
         , 'fax' => $this->input_data->fax
         , 'home' => $this->input_data->home
         , 'imId' => $this->input_data->imId
         , 'im' => $this->input_data->im
         , 'avatar' => $this->input_data->cropped_image_nm
       );
    }

    private function _send_welcome_email() {
        $email = $this->input_data->email;
        $welcome_note = $this->input_data->welcome_note;
        //...send email
    }

    public function save() {
        //$this->_send_welcome_email();
        $personal_data = $this->_extract_personal_data();
        $user_id = DB::Table('User', 'master')->insert_get_id($personal_data);

        if($user_id) {
            $this->perms_data['itemname'] = $this->input_data->account_type;
            $this->perms_data['userid'] = $user_id;
            DB::Table('AuthAssignment', 'master')->insert($this->perms_data);             
        } 


        return Redirect::to('admin'); 
    }
}
