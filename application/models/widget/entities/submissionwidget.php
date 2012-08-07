<?php namespace Widget\Entities;

use Config, View, DB, Widget\Entities\Types\FormWidgets, \Widget\Repositories\DBHostedSettings, \Company\Repositories\DBCompany;

class SubmissionWidget extends FormWidgets {

    protected $height = 590;
    protected $width = 447;
    
    public function __construct($options) {

        $this->env = Config::get('application.env_name');

        if($this->env == 'dev' or $this->env == 'local') { 
            $this->fb_id = '171323469605899';
            $fb_secret   = 'b60766ccb12c32c92029a773f7716be8';
        }

        if($this->env == 'prod') { 
            $this->fb_id = '259670914062599';
            $fb_secret   = '8e0666032461a99fb538e5f38ac7ef93';
        }
        
        $this->widgetkey  = $options->widgetkey;
        $this->site_id    = $options->site_id;
        $this->company_id = $options->company_id;
        $this->form_text  = $options->submit_form_text;
        $this->form_question = $options->submit_form_question;
        $this->theme_type = $options->theme_type;
        $this->tab_pos  = $options->tab_pos;
        $this->tab_type = $options->tab_type;
        $this->country  = DB::Table('Country', 'master')->order_by('name')->get();

        $company = new DBCompany;
        $this->company = $company->get_company_info($options->company_id);

        $this->hosted_settings = new DBHostedSettings;
        $this->hosted_settings->set_hosted_settings(Array('companyId' => $options->company_id));
    }

    public function render_data() {
        $widget_view = 'widget::widget_submissionform_view';

        return View::of_widget_layout()->partial('contents', $widget_view, Array(
            'fb_app_id' => $this->fb_id  
          , 'env' => $this->env
          , 'country' => $this->country 
          , 'site_id' => $this->site_id
          , 'company_id' => $this->company_id
          , 'company_name' =>  $this->company->company_name
          , 'form_text' => $this->form_text
          , 'form_question' => $this->form_question
          , 'theme_name' => $this->theme_type
          , 'hosted' => $this->hosted_settings->hosted_settings() 
          , 'response' => 0
        ))->get();  
    }

    public function render_hosted() {

        $hosted_settings = new \Widget\Repositories\DBHostedSettings;
        $hosted_settings->set_hosted_settings(Array('companyId' => $this->company_id));

        return View::make('widget::widget_hostedform_view', Array(
            'fb_app_id' => $this->fb_id  
          , 'env' => $this->env
          , 'country' => $this->country
          , 'site_id' => $this->site_id
          , 'company_id' => $this->company_id
          , 'company_name' =>  $this->company->company_name
          , 'form_text' => $this->form_text
          , 'form_question' => $this->form_question
          , 'theme_name' => $this->theme_type
          , 'hosted' => $this->hosted_settings->hosted_settings() 
          , 'response' => 0
        ))->get();
    }

    public function get_tab_type() { 
        return $this->tab_type;
    }

    public function get_tab_pos() { 
        return $this->tab_pos;
    } 
}
