<div class="block">
    <div id="widget-setup-block">
        <div class="widget-options">

            <h2 class="ico-widget widget">
                <?=HTML::link('feedsetup/overview/display', 'Display Widgets', Array('class' => 'widget-overview-btn'))?> 
                <small style="font-weight:normal;">(for displaying feedback on your websites)</small>
            </h2>
            <?=HTML::link('feedsetup/display_widgets', 'Create Display Widget', array('class' => 'widget-create'))?>   

            <?if($widgets->display_widgets->widget->widgets != null):?>
                <span id="display-overview-target">
                    <?=View::make('feedsetup/ajax_views/ajax_overview_view', Array(
                        'widgets' => $widgets->display_widgets->widget
                      , 'pagination' => $widgets->display_widgets->pagination
                      , 'widget_type' => 'display'
                    ))->get();?>
                </span>
            <?else:?>
                <div class="woops">
                    <h2 class="woops-header">
                        <?=HTML::link('feedsetup/display_widgets', 'Create your display widgets ', Array('class' => 'woops-header'))?> 
                    </h2>
                    <p class="woops-content">
                        <?=HTML::link('feedsetup/display_widgets', 'Share your customer testimonials on your website', Array('class' => 'woops-a'))?> 
                    </p>
                </div>
            <?endif;?>

        </div>
    </div>

    <div id="widget-setup-block">
        <div class="widget-options">
            <h2 class="ico-widget form">
                <?=HTML::link('feedsetup/overview/submit', 'Submission Forms', Array('class' => 'widget-overview-btn'))?> 
                <small style="font-weight:normal;"> (for accepting feedback from your customers/visitors)</small>
            </h2>
            <a href="#" class="widget-create">Create Submission Form</a>
            <?=HTML::link('feedsetup/submission_widgets', 'Create Submission Form', array('class' => 'widget-create'))?>

            <?if($widgets->form_widgets->widget->widgets != null):?>
                <span id="form-overview-target">
                    <?=View::make('feedsetup/ajax_views/ajax_overview_view', Array(
                        'widgets' => $widgets->form_widgets->widget
                      , 'pagination' => $widgets->form_widgets->pagination
                      , 'widget_type' => 'submit'
                    ))->get();?>
                </span>
            <?else:?>
                <div class="woops">
                    <h2 class="woops-header">  
                         <?=HTML::link('feedsetup/submission_widgets', 'Create your feedback submission form', Array('class' => 'woops-header'))?> 
                    </h2>
                    <p class="woops-content">
                    <?=HTML::link('feedsetup/submission_widgets', 'Start receiving feedback from you customers/visitors', Array('class' => 'woops-a'))?> 
                    </p>
                </div>
            <?endif?>
        </div>
    </div>
</div>
