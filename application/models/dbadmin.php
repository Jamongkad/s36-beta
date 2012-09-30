<?php

class DBAdmin extends S36DataObject {

    public $input_data; 
    public $perms_data;

    private function _extract_personal_data()   {
       $encrypt = new Encryption\Encryption;

       $data = Array(
           'username' => strtolower($this->input_data->username) 
         , 'fullName' => $this->input_data->fullName
         , 'email' => $this->input_data->email
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
       
       //check if password has been changed...
       if($this->input_data->password) {
           $data['password'] = crypt($this->input_data->password);
           $data['encryptString'] = $encrypt->encrypt(strtolower($this->input_data->username)."|".$this->input_data->password);
       }

       return $data;
    }

    public function save() {
    
        $personal_data = $this->_extract_personal_data();
        $user_id = DB::Table('User', 'master')->insert_get_id($personal_data);

        if($user_id) {
            $this->perms_data['itemname'] = $this->input_data->account_type;
            $this->perms_data['userid'] = $user_id;
            DB::Table('AuthAssignment', 'master')->insert($this->perms_data);
           
            $invite_data = new Email\Entities\InvitationData; 
            $invite_data->invitee_info_id($user_id);
            $invite_data->set_publisher_email(S36Auth::user()->email);
            $invite_data->account_owner = S36Auth::user()->fullname;
            $invite_data->message = $this->input_data->welcome_note;

            $emailservice = new Email\Services\EmailService($invite_data);
            $emailservice->send_email();
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
        $profile_img = new Profile\Services\ProfileImage();
        $profile_img->remove_profile_photo($admin_details->avatar);
        DB::Table('User', 'master')->where('userId', '=', $id)->delete();
        DB::Table('AuthAssignment', 'master')->where('userid', '=', $id)->delete();
    }
}
