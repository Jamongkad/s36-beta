<div class="block">
    <div id="widget-setup-block"> 
        <div class="widget-options">
        <h2 class="ico-widget widget"><?=HTML::link('feedsetup/overview/'.$overview_type, $link_text, Array('class' => 'widget-overview-btn'))?> </h2>
        <span id="overview-target">  
            <?if($widgets->widgets):?>
                <?foreach($widgets->widgets as $rows):?>
                    <div class="widget-types">
                        <div class="widget-info">
                            <div class="grids">
                                <div class="g2of3">
                                <div class="widget-title"><?=$rows->widget_obj->theme_name?></div>
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr><td width="90"><strong>Widget Type :</strong></td>
                                        <td><?=($overview_type == 'display') ? $rows->widget_obj->embed_type : 'Submission'?></td>
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
                                            <li><?=HTML::link('feedsetup/edit/'.$rows->widgetkey.'/'.$overview_type, 'Edit', array('class' => 'button-gray'))?></li>

                                            <li><?=HTML::link('feedsetup/formcode_manager/'.$rows->widgetkey, 'Integrate', array('class' => 'button-gray'))?></li>

                                            <li><?=HTML::link('feedsetup/delete_widget/'.$rows->widgetkey, 'Delete', array('class' => 'button-gray'))?></li>
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
                        <?=$pagination?>
                    </div>
                </div>
            <?else:?>
            <div class="woops">
                <h2 class="woops-header">No Widgets available</h2>
                <p class="woops-content">
                   Whoops! Looks like there are no widgets available... 
                </p>
            </div>
            </div>
            <?endif?>        
        </span>
        </div>
    </div>
</div>
