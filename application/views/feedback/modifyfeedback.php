<div class="main_content grids"> 
<? $id = $feedback->id ?>
<?=Form::hidden('feed_id', $id, array('id' => 'feed-id'))?>
<h3>Feedback Information</h3>
<div class="grids">
    <div class="grids">
        <div class="g1of2">
             <div class="head">Entry by <?=$feedback->firstname?> <?=$feedback->lastname?></div>
             <?=Form::textarea('text', $feedback->text, Array('class' => 'feedback-textarea', 'rows' => 5, 'cols' => 30, 
                                                              'disabled', 'hrefaction' => URL::to('feedback/edit_feedback_text'))
             )?><br/>
             <?=HTML::link('/', 'edit', Array('class' => 'edit'))?>
             <?=HTML::link('/', 'save', Array('class' => 'save'))?>
        </div> 
        <div class="g1of2">
             <div class="savebox">
                 <div class="save-head">
                 Select a Category for this feedback. 
                 <ul class="category-picker">
                     <?foreach($categories as $cat):?> 
                         <li <?=($feedback->category === $cat->name) ? 'class="Matched"' : Null?>>
                             <?=HTML::link('feedback/changecat?catid='.$cat->id.'&feedid='.$feedback->id, $cat->name)?>
                         </li>
                     <?endforeach?>
                 </ul>
                 </div>
             </div>
        </div>
    </div>

    <div>
        <div>Status: <?=$feedback->status?> Priority: <?=$feedback->priority?></div>
        <?=HTML::link('/', 'Reply to User')?> | 
        <?=HTML::link('/', 'Forward')?> | 
        <?=HTML::link('feedback/change_state/publish/'.$id, 'Publish')?> |
        <?=HTML::link('feedback/change_state/feature/'.$id, 'Feature')?> |
        <?=HTML::link('feedback/change_state/flag/'.$id, 'Flag') ?> |
        <?=HTML::link('/feedback/deletefeedback/'.$id, 'Delete')?> 
        <!--
        <?=HTML::link('/', 'Publish', array(  'class' => 'check'
                                            , 'state' => $feedback->ispublished
                                            , 'feedid' => $id
                                            , 'hrefaction' => URL::to('/feedback/publishfeedback')))?> | 
        <?=HTML::link('/', 'Make Sticky', array(  'class'=> 'feature'
                                                , 'state' => $feedback->isfeatured
                                                , 'feedid' => $id
                                                , 'hrefaction' => URL::to('/feedback/featurefeedback')))?> | 
        <?=HTML::link('/', 'Flag for followup', array(  'class' => 'flag'
                                                      , 'state' => $feedback->isflagged
                                                      , 'feedid' => $id
                                                      , 'hrefaction' => URL::to('/feedback/flagfeedback')))?>
        -->
    </div>

    <div class="grids">
        <div class="g1of3">
             <div class="head">User Information</div>
             <table class="user-info">
                 <tr><td>First Name:</td><td><?=$feedback->firstname?></td></tr>
                 <tr><td>Last Name:</td><td><?=$feedback->lastname?></td></tr>
                 <tr><td>Email Address:</td><td><?=$feedback->email?></td></tr>
                 <tr><td>Time Sent:</td><td><?=$feedback->date?></td></tr>
                 <tr><td>Phone:</td><td>-</td></tr>
                 <tr><td>Address:</td><td>-</td></tr>
             </table>
        </div> 
        <div class="g2of3">
             <div class="head">Display Information</div>
             <table class="user-info">
                 <span id="toggle_url" hrefaction="<?=URL::to('/feedback/toggle_feedback_display')?>"></span>
                 <tr><th></th><th style="text-align:left; font-size: 9px">edit</th><th style="font-size: 9px">display?</th></tr>
                 <tr>
                     <td>Display Name:</td>
                     <td><?=$feedback->firstname?> <?=$feedback->lastname?></td>
                     <td align="center"><?=Form::checkbox('displayName', $feedback->displayname, ($feedback->displayname ? True : Null))?></td>
                 </tr>
                 <tr>
                     <td>Display Image:</td>
                     <td><?=$feedback->displayimg?></td>
                     <td align="center"><?=Form::checkbox('displayImg', $feedback->displayimg, ($feedback->displayimg ? True : Null))?></td>
                 </tr>
                 <tr>
                     <td>Company Name:</td>
                     <td><?=$feedback->companyname?></td>
                     <td align="center"><?=Form::checkbox('displayCompany', $feedback->displaycompany, ($feedback->displaycompany ? True : Null))?></td>
                 </tr>
                 <tr>
                     <td>Designation / Position:</td>
                     <td><?=$feedback->position?></td>
                     <td align="center"><?=Form::checkbox('displayPosition', $feedback->displayposition, ($feedback->displayposition ? True : Null))?></td>
                 </tr>
                 <tr>
                     <td>Website Url:</td>
                     <td><?=$feedback->url?></td> 
                     <td align="center"><?=Form::checkbox('displayURL', $feedback->displayurl, ($feedback->displayurl ? True : Null))?></td>
                 </tr>
                 <tr>
                     <td>Country & Flag:</td>
                     <td><?=$feedback->countryname?> <?=$feedback->countrycode?></td> 
                     <td align="center"><?=Form::checkbox('displayCountry', $feedback->displaycountry, ($feedback->displaycountry ? True : Null))?></td>
                 </tr>
                 <tr>
                     <td>Submitted Date:</td>
                     <td><?=$feedback->date?></td> 
                     <td align="center"><?=Form::checkbox('displaySbmtDate', $feedback->displaysbmtdate, ($feedback->displaysbmtdate ? True : Null))?></td>
                 </tr>
             </table>
        </div>
        <!--TODO we need to redesign this portion long db entries mess up layout. 
        <div class="g1of3">
             <div class="head">System Information</div>
             <table class="user-info">
                 <tr><td>First Name:</td><td><?=$feedback->firstname?></td></tr>
                 <tr><td>Last Name:</td><td><?=$feedback->lastname?></td></tr>
                 <tr><td>Email Address:</td><td><?=$feedback->email?></td></tr>
                 <tr><td>Time Sent:</td><td><?=$feedback->date?></td></tr>
                 <tr><td>Phone:</td><td>-</td></tr>
                 <tr><td>Address:</td><td>-</td></tr>
             </table>
        </div>
        -->
    </div>
</div>
</div>
