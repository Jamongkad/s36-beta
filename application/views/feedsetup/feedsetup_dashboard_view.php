<div class="block">
<div id="widget-setup-block">
    <div class="widget-options">
        <h2 class="ico-widget widget">Display Widgets <small style="font-weight:normal;">(for displaying feedback on your websites)</small></h2>
        <?=HTML::link('feedsetup/display_widgets', 'Create Display Widget', array('class' => 'widget-create'))?>
        <?foreach($widgets->display_widgets as $rows):?>
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
                                <td><?=$rows->widget_obj->base_url?></td>
                            </tr>
                        </table>
                        </div>
                        <div class="g1of3">
                            <div class="right-align">
                                <ul class="widget-button-list">
                                    <li><?=HTML::link('feedsetup/edit/'.$rows->widgetstoreid, 'Edit', array('class' => 'button-gray'))?></li>
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
    </div>
    <div class="widget-opts">
        <div class="widget-pagination">
            <a href="#" class="activePage">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
            <a href="#">4</a>
            <a href="#">5</a>
        </div>
    </div>
</div>

<div id="widget-setup-block">
    <div class="widget-options">
        <h2 class="ico-widget form">Submission Forms <small style="font-weight:normal;"> (for accepting feedback from your customers/visitors) </small></h2>
        <a href="#" class="widget-create">Create Submission Form</a>
        <?=HTML::link('feedsetup/submission_widgets', 'Create Submission Form', array('class' => 'widget-create'))?>
        <?if($widgets->form_widgets != null):?>
            <?foreach($widgets->display_widgets as $rows):?>
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
                                    <td><?=$rows->widget_obj->base_url?></td>
                                </tr>
                            </table>
                            </div>
                            <div class="g1of3">
                                <div class="right-align">
                                    <ul class="widget-button-list">
                                        <li><?=HTML::link('feedsetup/edit/'.$rows->widgetstoreid, 'Edit', array('class' => 'button-gray'))?></li>
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
                    <a href="#" class="activePage">1</a>
                    <a href="#">2</a>
                    <a href="#">3</a>
                    <a href="#">4</a>
                    <a href="#">5</a>
                </div>
            </div>
        <?else:?>
            <div class="woops">
                <h2 class="woops-header">Create your feedback submission form</h2><br/><br/>
                <!--
                <p>Have you <?=HTML::link('feedsetup/all', 'set up your feedback form')?> on your website already?</p>
                -->
                <p class="woops-content">Start receiving feedback from you customers/visitors</p>
            </div>
        <?endif?>
        </div>
</div>
</div>
