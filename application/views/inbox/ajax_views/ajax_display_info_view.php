<?if($feed_options):?>
    <script type="text/javascript">
        /* 
        jQuery(function($) { 
            var userInfo = new FeedbackDisplayToggle({feed_id: $('#feed-id'), hrefaction: $('#toggle_url')});
            userInfo.toggleDisplays($('.display-info input[name*="display"]'), 'feedblock_id');
        });
        */
    </script>
    <table width="100%" cellpadding="4" class="display-info">
        <span id="toggle_url" hrefaction="<?=URL::to('/feedbacksetupdisplay/toggle_feedback_display')?>"></span>
        <?=Form::hidden('feedid', $feed_options->feedbackblockid, array('id' => 'feed-id'))?>
        <tr><td width="160" class="feedback-td-font">Display Name :</td><td width="80">
        <?=Form::checkbox('perms[feedbacksetupdisplay][displayName]', $feed_options->displayname, ($feed_options->displayname ? True : Null))?>
        </td>
        <td width="140" class="feedback-td-font">Website Url : </td><td>
        <?=Form::checkbox('perms[feedbacksetupdisplay][displayURL]', $feed_options->displayurl, ($feed_options->displayurl ? True : Null))?>
        </td></tr>
        <tr><td class="feedback-td-font">Display Image :  </td><td>
        <?=Form::checkbox('perms[feedbacksetupdisplay][displayImg]', $feed_options->displayimg, ($feed_options->displayimg ? True : Null))?>
        </td>		
        <td class="feedback-td-font">Country & Flag : </td><td>
       <?=Form::checkbox('perms[feedbacksetupdisplay][displayCountry]', $feed_options->displaycountry, ($feed_options->displaycountry ? True : Null))?>
        </td></tr>
        <tr><td class="feedback-td-font">Company Name :</td><td>
        <?=Form::checkbox('perms[feedbacksetupdisplay][displayCompany]', $feed_options->displaycompany, ($feed_options->displaycompany ? True : Null))?>
        </td>			
        <td class="feedback-td-font">Submitted Date : </td><td>
        <?=Form::checkbox('perms[feedbacksetupdisplay][displaySbmtDate]', $feed_options->displaysbmtdate, ($feed_options->displaysbmtdate ? True : Null))?>
        </td></tr>
        <tr><td class="feedback-td-font">Designation / Position :</td><td>
        <?=Form::checkbox('perms[feedbacksetupdisplay][displayPosition]', $feed_options->displayposition, ($feed_options->displayposition ? True : Null))?>
        </td><td></td><td></td></tr>
    </table>
<?else:?>
        <h3>Please choose a website in order to configure your widget display options.</h3>
<?endif?>
