<?php namespace Widget\Entities;

use Widget\Entities\Types\FormWidgets, \Widget\Repositories\DBHostedSettings;
use \Company\Repositories\DBCompany, \Company\Repositories\DBCompanySocialAccount;
use Config, View, DB;

class SubmissionWidget extends FormWidgets {

    protected $height = 590;
    protected $width = 447;
    
    public function __construct($options) {

        $this->env = Config::get('application.env_name');        
        $this->fb_id = Config::get('application.fb_id');
        $this->widget_options = $options;
        $this->country  = DB::Table('Country', 'master')->order_by('name')->get();

        $company_social = new DBCompanySocialAccount;
        $this->company_social = $company_social;
        /*
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

        $company_social = new DBCompanySocialAccount;
        $this->company_social = $company_social;

        $this->site = DB::Table('Site')->where('siteId', '=', $options->site_id)->first(Array('domain'));

        $this->hosted_settings = new DBHostedSettings;
        $this->hosted_settings->set_hosted_settings(Array('companyId' => $options->company_id));
        */
    }

    public function render_html() {
        $widget_view = 'widget/widget_submissionform_view';

        return View::of_widget_layout()->partial('contents', $widget_view, Array(
            'fb_app_id'      => $this->fb_id  
          , 'env'            => $this->env
          , 'country'        => $this->country 
          , 'site_id'        => $this->widget_options->siteid
          , 'site_domain'    => $this->widget_options->domain
          , 'company_id'     => $this->widget_options->companyid
          , 'company_name'   => $this->widget_options->name
          , 'company_social' => $this->company_social
          , 'form_text'      => $this->widget_options->widgetattr->submit_form_text
          , 'form_question'  => $this->widget_options->widgetattr->submit_form_question
          , 'theme_name'     => $this->widget_options->widgetattr->theme_type
          , 'response'       => 0
        ))->get();  
    }

    public function render_hosted() {
        return View::make('widget/widget_hostedform_view', Array(
            'fb_app_id'      => $this->fb_id  
          , 'env'            => $this->env
          , 'country'        => $this->country 
          , 'site_id'        => $this->widget_options->siteid
          , 'site_domain'    => $this->widget_options->domain
          , 'company_id'     => $this->widget_options->companyid
          , 'company_name'   => $this->widget_options->name
          , 'company_social' => $this->company_social
          , 'form_text'      => $this->widget_options->submit_form_text
          , 'form_question'  => $this->widget_options->submit_form_question
          , 'theme_name'     => $this->widget_options->widgetattr->theme_type
          , 'response'       => 0
        ))->get();
        /*   
        return View::make('widget/widget_hostedform_view', Array(
            'fb_app_id' => $this->fb_id  
          , 'env' => $this->env
          , 'country' => $this->country
          , 'site_id' => $this->site_id
          , 'site_domain' => $this->site->domain
          , 'company_id' => $this->company_id
          , 'company' =>  $this->company
          , 'company_social' => $this->company_social
          , 'form_text' => $this->form_text
          , 'form_question' => $this->form_question
          , 'theme_name' => $this->theme_type
          , 'hosted' => $this->hosted_settings->hosted_settings() 
          , 'response' => 0
        ))->get();
        */
    }

    public function get_tab_type() { 
        return $this->tab_type;
    }

    public function get_tab_pos() { 
        return $this->tab_pos;
    } 
}
