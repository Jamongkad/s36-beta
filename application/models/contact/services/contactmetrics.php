<?php namespace Contact\Services;

use View, Helpers;
use Contact\Repositories\DBContact, S36Auth, DBMetric;

class ContactMetrics {

    private $contacts_model;

    public function __construct(DBContact $dbcontact, DBMetric $metric, S36Auth $auth) {
        $this->contacts_model = $dbcontact;
        $this->auth = $auth->user();
        $this->metric = $metric;
    }

    public function render_metric_bar() {

        $company_id = $this->auth->companyid;

        $this->metric->company_id = $company_id;

        $contact_count = $this->contacts_model->count_total_contacts();

        return View::make('partials/contact_metricbar_view', Array(
            'contact_count' => $contact_count
          , 'metric' => $this->metric->fetch_metrics()
        ));
    }
}
