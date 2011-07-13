<div class="main_content grids"> 
<h3>Feedback Information</h3>
<div class="grids">
    <div class="grids">
        <div class="g1of2">
             <div class="head">Entry by <?=$feedback->firstname?> <?=$feedback->lastname?></div>
             <?=Form::textarea('text', $feedback->text, Array('class' => 'feedback-textarea', 'rows' => 5, 'cols' => 30))?>
        </div> 
        <div class="g1of2">
             <div class="savebox">
                 <div class="save-head">
                 Select a Category for this feedback.
                 <ul>
                     <?foreach($categories as $cat):?>
                         <li><?=$cat->name?></li>
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
        <?=HTML::link('/', 'Delete')?> | 
        <?=HTML::link('/', 'Publish')?> | 
        <?=HTML::link('/', 'Make Sticky')?> | 
        <?=HTML::link('/', 'Flag for followup')?> 

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
        <div class="g1of3">
             <div class="head">Display Information</div>
             <table class="user-info">
                 <tr><td>First Name:</td><td><?=$feedback->firstname?></td></tr>
                 <tr><td>Last Name:</td><td><?=$feedback->lastname?></td></tr>
                 <tr><td>Email Address:</td><td><?=$feedback->email?></td></tr>
                 <tr><td>Time Sent:</td><td><?=$feedback->date?></td></tr>
                 <tr><td>Phone:</td><td>-</td></tr>
                 <tr><td>Address:</td><td>-</td></tr>
             </table>
        </div>
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
    </div>
</div>
</div>
