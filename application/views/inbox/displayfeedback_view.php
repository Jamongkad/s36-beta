<div class="block">
    <p>Customize Feedback Display Options</p>
</div>
<div class="block">
     <div class="head">Embedded Block Display Information</div>
     <table class="display-info" style="width: 300px">
         <span id="toggle_url" hrefaction="<?=URL::to('/feedsetup/toggle_feedback_display')?>"></span>
         <?=Form::hidden('feedid', $feed_options->feedbackblockid, array('id' => 'feed-id'))?>
         <tr><th></th><th style="text-align:left; font-size: 9px">edit</th><th style="font-size: 9px">display?</th></tr>
         <tr>
             <td>Display Name</td>
             <td align="center"><?=Form::checkbox('displayName', $feed_options->displayname, ($feed_options->displayname ? True : Null))?></td>
         </tr>
         <tr>
             <td>Display Image:</td>
             <td align="center"><?=Form::checkbox('displayImg', $feed_options->displayimg, ($feed_options->displayimg ? True : Null))?></td>
         </tr>
         <tr>
             <td>Company Name:</td>
             <td align="center"><?=Form::checkbox('displayCompany', $feed_options->displaycompany, ($feed_options->displaycompany ? True : Null))?></td>
         </tr>
         <tr>
             <td>Designation / Position:</td>
             <td align="center"><?=Form::checkbox('displayPosition', $feed_options->displayposition, ($feed_options->displayposition ? True : Null))?></td>
         </tr>
         <tr>
             <td>Website Url:</td>
             <td align="center"><?=Form::checkbox('displayURL', $feed_options->displayurl, ($feed_options->displayurl ? True : Null))?></td>
         </tr>
         <tr>
             <td>Country & Flag:</td>
             <td align="center"><?=Form::checkbox('displayCountry', $feed_options->displaycountry, ($feed_options->displaycountry ? True : Null))?></td>
         </tr>
         <tr>
             <td>Submitted Date:</td>
             <td align="center"><?=Form::checkbox('displaySbmtDate', $feed_options->displaysbmtdate, ($feed_options->displaysbmtdate ? True : Null))?></td>
         </tr>
     </table> 
    <div class="c"></div>
</div>

<!-- spacer -->
<div class="block noborder" style="height:300px;">
</div>
<!-- spacer -->
