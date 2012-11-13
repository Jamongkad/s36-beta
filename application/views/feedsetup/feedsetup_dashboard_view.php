<div class="block">
    <?if($hosted_full_page):?>
        <div id="widget-setup-block">
            <div class="widget-options">
                <h2 class="ico-widget widget">
                    <?=HTML::link('feedsetup/hosted_editor/'.$hosted_full_page->companyid
                                  , 'Fullpage Feedback Display', Array('class' => 'widget-overview-btn'))?> 
                    <small style="font-weight:normal;">(configure your fullpage feedback display)</small>
                </h2>
                <div class="widget-types">
                    <div class="widget-info">
                        <div class="grids">
                            <div class="g2of3">
                                <div class="widget-title">Fullpage Display</div>
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr><td width="90"><strong>Widget Type :</strong></td>
                                        <td>Fullpage</td>
                                    </tr>
                                    <tr><td width="90"><strong>Theme :</strong></td>
                                        <td><?=ucwords($hosted_full_page->theme_name)?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="g1of3">
                                <div class="right-align">
                                    <ul class="widget-button-list">
                                        <li>
                                            <?=HTML::link('feedsetup/hosted_editor/'.$hosted_full_page->companyid, 'Edit'
                                                          , array('class' => 'button-gray'))?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
                <div style="padding:15px"></div>
            </div>
        </div>
    <?endif?>

    <div id="widget-setup-block">
        <div class="widget-options">
            <h2 class="ico-widget widget">
                <?=HTML::link('feedsetup/overview/display', 'Feedback Display Setup', Array('class' => 'widget-overview-btn'))?> 
                <small style="font-weight:normal;">(for displaying feedback on your websites)</small>
            </h2>
            <?//=HTML::link('feedsetup/display_widgets', 'Create Display Widget', array('class' => 'widget-create'))?>   

            <?if($widgets->display_widgets->widget->widgets != null):?>
                <span id="display-overview-target">
                    <?=View::make('feedsetup/ajax_views/ajax_overview_view', Array(
                        'widgets' => $widgets->display_widgets->widget
                      , 'pagination' => $widgets->display_widgets->pagination
                    ))->get();?>
                </span>
            <?else:?>
                <div class="woops">
                    <h2 class="woops-header">
                        <?=HTML::link('feedsetup/widget_selection', 'Create your display widgets ', Array('class' => 'woops-header'))?> 
                    </h2>
                    <p class="woops-content">
                        <?=HTML::link('feedsetup/widget_selection', 'Share your customer testimonials on your website', Array('class' => 'woops-a'))?> 
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
            <?//=HTML::link('feedsetup/submission_widgets', 'Create Submission Form', array('class' => 'widget-create'))?>

            <?if($widgets->form_widgets->widget->widgets != null):?>
                <span id="form-overview-target">
                    <?=View::make('feedsetup/ajax_views/ajax_overview_view', Array(
                        'widgets' => $widgets->form_widgets->widget
                      , 'pagination' => $widgets->form_widgets->pagination
                    ))->get();?>
                </span>
            <?else:?>
                <div class="woops">
                    <h2 class="woops-header">  
                         <?=HTML::link('feedsetup/submission_widgets', 'Create your feedback submission form', Array('class' => 'woops-header'))?> 
                    </h2>
                    <p class="woops-content">
                    <?=HTML::link('feedsetup/submission_widgets', 'Start receiving feedback from your customers/visitors', Array('class' => 'woops-a'))?> 
                    </p>
                </div>
            <?endif?>
        </div>
    </div>
</div>
