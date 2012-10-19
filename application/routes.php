<?php

$feedback = new Feedback\Repositories\DBFeedback;
$hosted_settings = new Widget\Repositories\DBHostedSettings;
$dbw = new Widget\Repositories\DBWidget;
$company = new Company\Repositories\DBCompany;
$company_name = Config::get('application.subdomain');
$twitter = new \twitter\twitter('danOliverC');
$user = S36Auth::user();

return array(
	/*
	|--------------------------------------------------------------------------
	| Application Routes
	|--------------------------------------------------------------------------
	|
	| Here is the public API of your application. To add functionality to your
	| application, you just add to the array located in this file.
	|
	| It's a breeze. Simply tell Laravel the request URIs it should respond to.
	|
	| Need more breathing room? Organize your routes in their own directory.
	| Here's how: http://laravel.com/docs/start/routes#organize
	|
	*//*
    'GET /' => function() use($company_name, $hosted_settings, $dbw, $company) { 
        //consider placing this into a View Object
        $company_info = $company->get_company_info($company_name); 

        $hosted = new Feedback\Services\HostedService($company_name);
        $hosted->fetch_hosted_feedback(); 
        $hosted->build_data();         

        $widget = $dbw->fetch_canonical_widget($company_name);

        $hosted_settings->set_hosted_settings(Array('companyId' => $company_info->companyid));

        $header_view = new Hosted\Services\CompanyHeader($company_info->company_name
                                                       , $company_info->fullpagecompanyname
                                                       , $company_info->domain);

        $meta = new Hosted\Services\HostedMetadata(Array(
             'company_name' => $company_info->company_name
           , 'company_id' => $company_info->companyid
        ));
        $meta->calculate_metrics();

        echo View::of_company_layout()->partial('contents', 'hosted/hosted_feedback_fullpage_view', Array(  
                                                    'company' => $company_info
                                                  , 'feeds' => $hosted->view_fragment()
                                                  , 'widget' => $widget
                                                  , 'feed_count' => $meta->perform()
                                                  , 'company_header' => $header_view
                                                  , 'hosted' => $hosted_settings->hosted_settings()));        
    },
*/
        'GET /' => function() use($company_name, $hosted_settings, $dbw, $company, $user, $twitter) {
        //consider placing this into a View Object
        $company_info = $company->get_company_info($company_name); 
        $tweets = $twitter->findTwitts('codiqa');
        $hosted = new Feedback\Services\HostedService($company_name);
        $hosted->fetch_hosted_feedback(); 
        $hosted->build_data();         

        $widget = $dbw->fetch_canonical_widget($company_name);

        $hosted_settings->set_hosted_settings(Array('companyId' => $company_info->companyid));

        $header_view = new Hosted\Services\CompanyHeader($company_info->company_name
                                                       , $company_info->fullpagecompanyname
                                                       , $company_info->domain);

        $meta = new Hosted\Services\HostedMetadata(Array(
             'company_name' => $company_info->company_name
           , 'company_id' => $company_info->companyid
        ));
        $meta->calculate_metrics();
        //\Helpers::show_data($tweets);
        echo View::of_fullpage_layout()->partial('contents', 'hosted/hosted_feedback_fullpage_view', Array(  
                                                    'company' => $company_info
                                                  , 'user' => $user
                                                  , 'feeds' => $hosted->view_fragment()
                                                  , 'tweets' => $tweets
                                                  , 'widget' => $widget
                                                  , 'feed_count' => $meta->perform()
                                                  , 'company_header' => $header_view
                                                  , 'hosted' => $hosted_settings->hosted_settings()));        
    },
    'POST /savecoverphoto' => function() use($company){
      $data = Input::all();
      $company->update_coverphoto($data);
      return json_encode($data);
    },
    'POST /ajaxfileupload' => function(){
        $error = "";
        $msg = "";
        $filedir = "";
        $width = "";
        $file = 'clientLogoImg';
        if(!empty($_FILES[$file]['error']))
        {
          switch($_FILES[$file]['error'])
          {

            case '1':
              $error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
              break;
            case '2':
              $error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
              break;
            case '3':
              $error = 'The uploaded file was only partially uploaded';
              break;
            case '4':
              $error = 'No file was uploaded.';
              break;
            case '6':
              $error = 'Missing a temporary folder';
              break;
            case '7':
              $error = 'Failed to write file to disk';
              break;
            case '8':
              $error = 'File upload stopped by extension';
              break;
            case '999':
            default:
              $error = 'No error code avaiable';
          }
        }elseif(empty($_FILES[$file]['tmp_name']) || $_FILES[$file]['tmp_name'] == 'none'){
          $error = 'No file was uploaded..';
        }elseif(($_FILES[$file]['type'] != "image/jpeg") && 
            ($_FILES[$file]['type'] != "image/gif")  && 
            ($_FILES[$file]['type'] != "image/pjpeg")&& 
            ($_FILES[$file]['type'] != "image/x-png")&& 
            ($_FILES[$file]['type'] != "image/png")){
            $error = 'Please Upload Image Files Only';
        }elseif($_FILES[$file]['size'] > 2000000){
          $error = "Please Upload Images Not Greater than 2MB";
        }else{
            //$msg .= " File Size: " . @filesize($_FILES['your_photo']['tmp_name']);
            //for security reason, we force to remove all uploaded file
              $filename = date("Ydmhis").$_FILES[$file]['name'];
              $filedir = "uploaded_images/coverphoto/".$filename;
              $maxwidth = 800;
              $maxheight = 140;
              $move = move_uploaded_file($_FILES[$file]['tmp_name'],"uploaded_images/coverphoto/".$filename);
              if($move){
                 //start image resizing..
                 $resizeObj = new \resize\Resize($filedir);
                 $resizeObj -> resizeImage($maxwidth, $maxheight, 'landscape');
                 $resizeObj -> saveImage($filedir, 100);
              }
            
        }
        echo "{";
        echo        "error: '" . $error . "',\n";
        echo        "msg: '" . $filedir  . "',\n";
        echo        "wid: '" . $width  . "'\n";
        echo "}";
    },


    'GET /(:any)/submit' => function($company_name) use($hosted_settings, $dbw, $company) {
        $canon_widget = $dbw->fetch_canonical_widget($company_name);

        $wl = new Widget\Services\WidgetLoader($canon_widget->widgetkey); 
        $widget = $wl->load();

        $company_info = $company->get_company_info($widget->company_id);
        $header_view = new Hosted\Services\CompanyHeader($company_info->company_name, $company_info->fullpagecompanyname, $company_info->domain);

        $hosted_settings->set_hosted_settings(Array('companyId' => $widget->company_id));

        return View::of_company_layout()->partial('contents', 'hosted/hosted_feedback_form_view', Array(
                                                      'widget' => $widget->render_hosted()
                                                    , 'company' => $company_info
                                                    , 'company_header' => $header_view 
                                                    , 'hosted' => $hosted_settings->hosted_settings()));
    },

    'GET /single/(:num)' => function($id) use ($feedback, $hosted_settings, $company) { 

        $feedback = $feedback->pull_feedback_by_id($id);
        $company_info = $company->get_company_info($feedback->companyid);

        $fb_id = Config::get('application.fb_id');

        $hosted_settings->set_hosted_settings(Array('companyId' => $feedback->companyid));  
        $header_view = new Hosted\Services\CompanyHeader($company_info->company_name, $company_info->fullpagecompanyname, $company_info->domain);

        return View::make('hosted/hosted_feedback_single_view', Array(
            'feedback' => $feedback 
          , 'company_header' => $header_view 
          , 'fb_id' => $fb_id
          , 'hosted' => $hosted_settings->hosted_settings()
        ));
    },

    'GET /login' => function() use($company_name) {
        $auth = new S36Auth;
        if($auth->check()) { 
            return forward_or_dash();
        } else {
            return View::of_home_layout()->partial('contents', 'home/login', Array(
                'company' => $company_name, 'errors' => array(), 'warning' => null
            ));      
        }		

    },

    'POST /login' => function() use($company_name) {
        $input = Input::get();        
        $auth = new S36Auth;

        $rules = Array(
            'username' => 'required'
          , 'password' => 'required'
        );
 
        $validator = Validator::make($input, $rules);

        if(!$validator->valid()) { 
            return View::of_home_layout()->partial('contents', 'home/login', Array(  
                                                       'company' => $company_name
                                                     , 'errors' => $validator->errors
                                                     , 'warning' => null));      
        } else {

            $auth->login($input['username'], $input['password'], Array('company' => $company_name)); 

            if($auth->check()) {

                $user_id = $auth->user()->userid;
                $company_id = $auth->user()->companyid;

                $halcyon = new Halcyonic\Services\HalcyonicService;
                $halcyon->company_id = $company_id;
                $halcyon->set_user_feedcount($user_id);
                
                return forward_or_dash();
            } else {
                return View::of_home_layout()->partial('contents', 'home/login', Array(  
                    'company' => $company_name
                  , 'errors' => Array()
                  , 'warning' => 'Invalid login - try again.')); 
            } 
        }
    },
    
    'GET /logout' => function() {
        S36Auth::logout();
        return Redirect::to('login');
    },

    'GET /help' => Array('name' => 'help', 'before' => 's36_auth', 'do' => function() {
        return View::of_home_layout()->partial('contents', 'help/help_index_view');
    }),

    'GET /complete' => function() { 
        return View::of_home_layout()->partial('contents', 'home/user_auth_thankyou_view');       
    },

    'GET /resend_password' => function() use($company_name) {  
        return View::of_home_layout()->partial('contents', 'home/resend_password_view', Array(
                                                   'errors'  => Array()
                                                 , 'warning' => null
                                                 , 'company' => $company_name));       
    },

    'POST /resend_password' => function() use($company_name) {
        $admin = new DBadmin; 
        $data = Input::get();
        $rules = Array('email' => 'required|email');
 
        $validator = Validator::make($data, $rules);
        if(!$validator->valid()) {
            return View::of_home_layout()->partial('contents', 'home/resend_password_view', Array(
                                                       'errors' => $validator->errors
                                                     , 'warning' => null
                                                     , 'company' => $company_name));
        } else {
            $opts = new StdClass; 
            $opts->username = $data['email'];
            $opts->options = Array('company' => $company_name);
            $user = $admin->fetch_admin_details($opts);

            if(!$user) { 
                return View::of_home_layout()->partial('contents', 'home/resend_password_view', Array(
                                                         'errors' => Array()
                                                       , 'warning' => 'Email does not exist.'));
            }
        
            $data = new Email\Entities\ResendPasswordData;
            $data->user_data = $user;
            $data->get_host();
            $data->reset_key();

            $emailservice = new Email\Services\EmailService($data);
            $emailservice->send_email();  
            //success!
            return View::of_home_layout()->partial('contents', 'home/resend_password_sent_view');        
        }

    },
    
    'GET /password_reset' => function() use($company_name) { 
        $data = Input::get();
        $encrypt = new Encryption\Encryption;

        $params = explode("|", $encrypt->decrypt($data['k']));
        //I am the only key to user passwords!!! MWHAHAHA
        if($params[0] === "jamongkad") {  
            return View::of_home_layout()->partial('contents', 'home/password_reset_view', Array(
                                                       'subdomain' => $company_name
                                                     , 'email' => $data['email']
                                                     , 'user_id' => $params[1]
                                                     , 'errors' => array()));       
        }
       
    },

    'POST /password_reset' => function() {  
        $data = Input::get();
        $encrypt = new Encryption\Encryption;

        $rules = Array(
            'password' => 'required|min:8|confirmed'
        );

        $validator = Validator::make($data, $rules);
        if(!$validator->valid()) {
            return View::of_home_layout()->partial('contents', 'home/password_reset_view', Array(
                                                       'subdomain' => $data['company']
                                                     , 'email' => $data['email']
                                                     , 'user_id' => $data['user_id']
                                                     , 'errors' => $validator->errors));        
        } else {

            $user = DB::table('User', 'master')->where('User.userId', '=', $data['user_id'])->first();

            $personal_data = Array( 
                'username' => strtolower($user->username)
              , 'password' => crypt($data['password'])
              , 'encryptString' => $encrypt->encrypt(strtolower($user->username)."|".$data['password'])
            );

            DB::table('User', 'master')
                ->where('User.userId', '=', $data['user_id'])
                ->update($personal_data);

            return View::of_home_layout()->partial('contents', 'home/reset_password_success_view');        
        }
    },
);

function forward_or_dash() { 
    if($forward_to = Input::get('forward_to')) {
        return Redirect::to($forward_to);
    } else {
        return Redirect::to('dashboard');     
    } 
}
