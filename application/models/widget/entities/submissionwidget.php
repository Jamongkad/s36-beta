<?php namespace Widget\Entities;

use Widget\Entities\Types\FormWidgets, Widget\Repositories\DBHostedSettings, Widget\Services\Formbuilder\Formbuilder;
use \Company\Repositories\DBCompany, \Company\Repositories\DBCompanySocialAccount;
use Config, View, DB;

class SubmissionWidget extends FormWidgets {

    protected $height = 590;
    protected $width = 447;

    private $form_render;
    
    public function __construct($options) {

        $this->env = Config::get('application.env_name');        
        $this->fb_id = Config::get('application.fb_id');
        $this->widget_options = $options;

        $this->country  = DB::Table('Country', 'master')->order_by('name');
        $this->tab_pos  = $options->widgetattr->tab_pos;
        $this->tab_type = $options->widgetattr->tab_type;

        $company_social = new DBCompanySocialAccount;
        $this->company_social = $company_social;
        
        if($formstructure = $options->formstructure) { 
            $data = Array('form_structure' => $formstructure);
            $this->form_render = new Formbuilder($data);    
        }
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

        $this->form_vars = Array(
            'fb_app_id'      => $this->fb_id  
          , 'env'            => $this->env
          , 'countries'      => $this->country 
          , 'site_id'        => $this->widget_options->siteid
          , 'site_domain'    => $this->widget_options->domain
          , 'company_id'     => $this->widget_options->companyid
          , 'company_name'   => $this->widget_options->name
          , 'company_social' => $this->company_social
          , 'form_text'      => $this->widget_options->widgetattr->submit_form_text
          , 'form_question'  => $this->widget_options->widgetattr->submit_form_question
          , 'theme_name'     => $this->widget_options->widgetattr->theme_type
          , 'response'       => 0
          , 'form_render'    => $this->form_render
        );
    }

    public function render_html() {
        //$widget_view = 'widget/widget_submissionform_view';
        $widget_view = 'widget/widget_submissionform_new_view';
        return View::of_widget_layout()->partial('contents', $widget_view, $this->form_vars)->get();  
    }

    public function render_hosted() {
        $hosted_view = 'widget/widget_hostedform_view';
        return View::make($hosted_view, Array(
            'fb_app_id'      => $this->fb_id  
          , 'env'            => $this->env
          , 'countries'      => $this->country 
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
    }

    public function get_tab_type() { 
        return $this->tab_type;
    }

    public function get_tab_pos() { 
        return $this->tab_pos;
    } 
}
