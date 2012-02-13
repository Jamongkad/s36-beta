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
                    <?foreach($widgets->display_widgets->widget->widgets as $rows):?>
                        <div class="widget-types">
                            <div class="widget-info">
                                <div class="grids">
                                    <div class="g2of3">
                                    <div class="widget-title"><?=$rows->widget_obj->theme_name?></div>
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr><td width="90"><strong>Widget Type :</strong></td>
                                            <td><?=$rows->widget_obj->embed_type?></td>
                                        </tr>
                                        <tr><td width="90"><strong>Theme :</strong></td>
                                            <td><?=$rows->widget_obj->theme_type?></td>
                                        </tr>
                                        <tr><td width="90"><strong>URL :</strong></td>
                                            <td><?=$rows->widget_obj->site_nm?></td>
                                        </tr>
                                    </table>
                                    </div>
                                    <div class="g1of3">
                                        <div class="right-align">
                                            <ul class="widget-button-list">
                                                <li><?=HTML::link('feedsetup/edit/'.$rows->widgetstoreid."/display", 'Edit', array('class' => 'button-gray'))?></li>
                                                <!--  
                                                <li><a href="#" class="button-gray">Stat</a></li>
                                                <li><a href="#" class="button">More</a></li> 
                                                -->
                                            </ul>               
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    <?endforeach?>
                    <div class="widget-opts">
                        <div class="widget-pagination"> 
                            <?=$widgets->display_widgets->pagination?>
                        </div>
                    </div>
                </span>
            <?else:?>
                <div class="woops">
                    <h2 class="woops-header">Create your display widgets</h2>
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
                    <?foreach($widgets->form_widgets->widget->widgets as $rows):?>
                        <div class="widget-types">
                            <div class="widget-info">
                                <div class="grids">
                                    <div class="g2of3">
                                    <div class="widget-title"><?=$rows->widget_obj->theme_name?></div>
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr><td width="90"><strong>Widget Type :</strong></td>
                                            <td>Submission Form</td>
                                        </tr>
                                        <tr><td width="90"><strong>Theme :</strong></td>
                                            <td><?=$rows->widget_obj->theme_type?></td>
                                        </tr>
                                        <tr><td width="90"><strong>URL :</strong></td>
                                            <td><?=$rows->widget_obj->site_nm?></td>
                                        </tr>
                                    </table>
                                    </div>
                                    <div class="g1of3">
                                        <div class="right-align">
                                            <ul class="widget-button-list">
                                                <li><?=HTML::link('feedsetup/edit/'.$rows->widgetstoreid.'/submit', 'Edit', array('class' => 'button-gray'))?></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    <?endforeach?>
                    <div class="widget-opts">
                        <div class="widget-pagination"> 
                            <?=$widgets->form_widgets->pagination?>
                        </div>
                    </div>
                </span>
            <?else:?>
                <div class="woops">
                    <h2 class="woops-header">Create your feedback submission form</h2>
                    <p class="woops-content">
                    <?=HTML::link('feedsetup/submission_widgets', 'Start receiving feedback from you customers/visitors', Array('class' => 'woops-a'))?> 
                    </p>
                </div>
            <?endif?>
        </div>
    </div>

</div>
<!--

-->

<!--
    <div id="widget-setup-block">
        <div class="widget-options">
            <h2 class="ico-widget form"><?=HTML::link('feedsetup/overview/submit', 'Submission Forms', Array('class' => 'widget-overview-btn'))?> <small style="font-weight:normal;"> (for accepting feedback from your customers/visitors) </small></h2>
            <a href="#" class="widget-create">Create Submission Form</a>
            <?=HTML::link('feedsetup/submission_widgets', 'Create Submission Form', array('class' => 'widget-create'))?>
            <?if($widgets->form_widgets->widget->widgets != null):?>
                <?foreach($widgets->form_widgets->widget->widgets as $rows):?>
                    <div class="widget-types">
                        <div class="widget-info">
                            <div class="grids">
                                <div class="g2of3">
                                <div class="widget-title"><?=$rows->widget_obj->theme_name?></div>
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr><td width="90"><strong>Widget Type :</strong></td>
                                        <td>Submission Form</td>
                                    </tr>
                                    <tr><td width="90"><strong>Theme :</strong></td>
                                        <td><?=$rows->widget_obj->theme_type?></td>
                                    </tr>
                                    <tr><td width="90"><strong>URL :</strong></td>
                                        <td><?=$rows->widget_obj->site_nm?></td>
                                    </tr>
                                </table>
                                </div>
                                <div class="g1of3">
                                    <div class="right-align">
                                        <ul class="widget-button-list">
                                            <li><?=HTML::link('feedsetup/edit/'.$rows->widgetstoreid, 'Edit', array('class' => 'button-gray'))?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                <?endforeach?>
                <div class="widget-opts">
                    <div class="widget-pagination"> 
                        <?=$widgets->form_widgets->pagination?><br/><br/>
                        <?=HTML::link('feedsetup/overview/display', 'browser for more...')?> 
                    </div>
                </div>
            <?else:?>
                <div class="woops">
                    <h2 class="woops-header">Create your feedback submission form</h2>
                    <p class="woops-content">
                    <?=HTML::link('feedsetup/submission_widgets', 'Start receiving feedback from you customers/visitors', Array('class' => 'woops-a'))?> 
                    </p>
                </div>
            <?endif?>
        </div>
    </div>
-->

            <!--
            <div class="widget-opts">
                <div class="widget-pagination">
                    <?=$widgets->display_widgets->pagination?><br/><br/>
                    <?=HTML::link('feedsetup/overview/display', 'browser for more...')?> 
                </div>
            </div>
            -->
