<?php

class DBAdmin extends S36DataObject {
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

    public function _send_welcome_email($user_id) {

        $user = DB::Table('User', 'master')->where('userId', '=', $user_id)->first();

        $email = $this->input_data->email;

        $vo = new InvitationNotificationData;
        $message_obj = new StdClass;
        $message_obj->account_owner = S36Auth::user()->fullname;
        $message_obj->publisher = S36Auth::user()->email;
        $message_obj->invitee = $this->input_data->fullName;
        $message_obj->message = $this->input_data->welcome_note;
        $message_obj->name = $this->input_data->username;
        $message_obj->user = $user;
        
        $factory = new EmailFactory($vo);
        $factory->addresses = Array((object)Array('email' => $this->input_data->email));
        $factory->message = $message_obj;
        $email_page = $factory->execute();

        //return $email_page[0]->get_message();
        $emailer = new Email($email_page);
        $emailer->process_email();
    }

    public function save() {
    
        $personal_data = $this->_extract_personal_data();
        $user_id = DB::Table('User', 'master')->insert_get_id($personal_data);

        if($user_id) {
            $this->perms_data['itemname'] = $this->input_data->account_type;
            $this->perms_data['userid'] = $user_id;
            DB::Table('AuthAssignment', 'master')->insert($this->perms_data);

            $this->_send_welcome_email($user_id);
        } 
    }

    public function update($user=False) {

        $userId = $this->input_data->userId;
        $personal_data = $this->_extract_personal_data();

        if(isset($user) && $user->itemname == "Admin") {
            DB::Table('AuthAssignment', 'master')
                      ->where('userid', '=', $userId)
                      ->update($this->perms_data);
        }

        DB::Table('User', 'master')
                  ->where('userId', '=', $userId) 
                  ->update($personal_data);
    }

    public function fetch_admin_details_by_id($id) {
        $admin = DB::Table('User', 'master')
                     ->join('AuthAssignment', 'AuthAssignment.userid', '=', 'User.userId')
                     ->where('User.userId', '=', $id)
                     ->first();
        return $admin;
    }

    public function fetch_admin_details($opts) {

        $company_statement = null;
        $opts_check = property_exists($opts, 'options');
        
        if($opts_check) { 
            $company_statement = "AND LCASE(CONVERT(Company.name USING latin1)) = :admin_company";
        }

        $sql = "SELECT 
                * 
                FROM 
                    User
                INNER JOIN
                    Company
                        ON Company.companyId = User.companyId
                WHERE 1=1
                    $company_statement 
                    AND (User.username = :admin_username OR User.email = :admin_email)
                ";

        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':admin_email', $opts->username, PDO::PARAM_STR);
        $sth->bindParam(':admin_username', $opts->username, PDO::PARAM_STR);

        if($opts_check) {
            $sth->bindParam(':admin_company', $opts->options['company'], PDO::PARAM_STR);
        }

        $sth->execute();
        $user = $sth->fetch(PDO::FETCH_OBJ);
        return $user;
    }

    public function delete_admin($id) {
        $admin_details = $this->fetch_admin_details_by_id($id);
        $profile_img = new Widget\ProfileImage();
        $profile_img->remove_profile_photo($admin_details->avatar);
        DB::Table('User', 'master')->where('userId', '=', $id)->delete();
        DB::Table('AuthAssignment', 'master')->where('userid', '=', $id)->delete();
    }
}
