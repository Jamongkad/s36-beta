<!-- top blue bar with filter options -->
<div class="block">
    <div class="contact-table" id="widget-setup-block">
        <table>
            <table width="100%" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <td>&nbsp;</td>
                        <td>THEME NAME</td>
                        <td>SITE</td>
                        <td>WIDGET TYPE</td>
                        <td>THEME</td>
                        <td>ACTIONS</td>
                    </tr>
                </thead>
                <tbody>
                    <?foreach($fetched_themes as $themes):?>
                        <tr>
                            <td>&nbsp;</td>
                            <td><?=$themes->themename?><br/> 
                            <small><a href="<?=URL::to('feedsetup/get_code/'.$themes->userthemeid)?>" style="color: #627483" class="get-code">[Get Code]</a></small>
                            </td>  
                            <td><?=$themes->domain?></td>
                            <td><?=$themes->widgetname?></td>
                            <td><?=$themes->name?></td>
                            <td><input class="edit" type="button"/> <input class="delete" type="button"/></td>
                        </tr>
                    <?endforeach?>
                </tbody>
            </table>
        </table>
    </div>
</div>
