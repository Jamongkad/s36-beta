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

    public function _send_welcome_email() {

        $email = $this->input_data->email;

        $vo = new InvitationNotificationData;
        $message_obj = new StdClass;
        $message_obj->account_owner = S36Auth::user()->fullname;
        $message_obj->publisher = S36Auth::user()->email;
        $message_obj->invitee = $this->input_data->fullName;
        $message_obj->message = $this->input_data->welcome_note;
        $message_obj->name = $this->input_data->username;
        
        $factory = new EmailFactory($vo);
        $factory->addresses = Array((object)Array('email' => $this->input_data->email));
        $factory->message = $message_obj;
        $email_page = $factory->execute();

        //return $email_page[0]->get_message();
        $emailer = new Email($email_page);
        $emailer->process_email();
    }

    public function save() {
        $this->_send_welcome_email();
        $personal_data = $this->_extract_personal_data();
        $user_id = DB::Table('User', 'master')->insert_get_id($personal_data);

        if($user_id) {
            $this->perms_data['itemname'] = $this->input_data->account_type;
            $this->perms_data['userid'] = $user_id;
            DB::Table('AuthAssignment', 'master')->insert($this->perms_data);             
        } 

        return Redirect::to('admin'); 
    }

    public function update($user) {

        $userId = $this->input_data->userId;
        $personal_data = $this->_extract_personal_data();

        if($user->itemname == "Admin") {
            DB::Table('AuthAssignment', 'master')
                      ->where('userid', '=', $userId)
                      ->update($this->perms_data);
        }
       
        DB::Table('User', 'master')
                  ->where('userId', '=', $userId) 
                  ->update($personal_data);

        return Redirect::to('admin');  
    }

    public function fetch_admin_details_by_id($id) {
        $admin = DB::Table('User', 'master')
                     ->join('AuthAssignment', 'AuthAssignment.userid', '=', 'User.userId')
                     ->where('User.userId', '=', $id)
                     ->first();
        return $admin;
    }
}
