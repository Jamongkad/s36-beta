<!-- gray status bar -->
<div class="admin-status-bar">
    <div class="current-page inbox">INBOX <!--<span>There were 27 new feedback since your last visit.</span>--></div>
</div>
<!-- end of gray status bar -->

<!--start of undo bar-->
<div class="undo-bar">
<?
    $user = new S36Auth;
    $feedback = new Feedback;
    $userid = $user->user()->userid;
    if($deleted = $feedback->fetched_delete_feedback($userid)) {
        echo "Deleted Feedback";
        foreach($deleted as $val) {
            echo "<div class='dickies'>".HTML::link('feedback/undodelete/'.$val->id, $val->id, array('restore-id' => $val->id))."</div>";
        }
    } 
?>

</div>
<!--end of undo bar-->

<!-- top navigation bar -->
<div class="admin-nav-bar">

    <ul>
        <li><?=HTML::link('inbox', 'SHOW ALL', Array('class' => (Request::uri() == 'inbox') ? 'selected' : null) )?></li>
        <li><?=HTML::link('inbox/rating/4', 'POSITIVE', Array('class' => (Request::uri() == 'inbox/rating/4') ? 'selected' : null))?></li>
        <li><?=HTML::link('inbox/rating/1', 'NEGATIVE', Array('class' => (Request::uri() == 'inbox/rating/1') ? 'selected' : null))?></li>
        <li><?=HTML::link('inbox/rating/2', 'NEUTRAL', Array('class' => (Request::uri() == 'inbox/rating/2') ? 'selected' : null))?></li>
        <li><?=HTML::link('inbox/rating/profanity', 'CONTAINS PROFANITY', Array('class' => (Request::uri() == 'inbox/rating/profanity') ? 'selected' : null))?></li>
        <li><?=HTML::link('inbox/rating/flagged', 'FLAGGED' , Array('class' => (Request::uri() == 'inbox/rating/flagged') ? 'selected' : null))?></li>
        <li><?=HTML::link('inbox/rating/mostcontent', 'MOST CONTENT', Array('class' => (Request::uri() == 'inbox/rating/mostcontent') ? 'selected' : null))?></li>
    </ul>
</div>
<!-- end of top navigation bar -->

<div class="admin-filter-bar">
    <div class="admin-filter-select">
        <select>
            <option>Select form</option>
        </select>
    </div>
    
    <div class="admin-filter-search">
        <input type="text" class="search" value="Search..." />
    </div>
    
    <div class="admin-filter-datepicker">
        <input type="text" class="datepicker" value="Jan 12, 2011 - Jan 12, 2011" />
    </div>
    <div class="c"></div>
</div>
<!-- top blue bar with filter options -->
<div class="admin-sorter-bar">
    <div class="sorter-bar">
        <div class="left">
            <input type="checkbox" />
        </div>
        <div class="right">
            <div class="g1of5">
                <label>SORT BY</label>
                <select>
                    <option>Date</option>
                </select>
            </div>
            <div class="g1of5">
                <label>RATING</label>
                <select>
                    <option>All</option>
                </select>
            </div>
            <div class="g1of5">
                <label>CATEGORY</label>
                <select>
                    <option>All</option>
                </select>
            </div>
            <div class="g1of5 right-align">
                <label>Display</label>
                <?$limit = Input::get('limit')?>
                <select name="feedback-limit">
                    <option value="10" <?=($limit == 10) ? "selected" : null?>>10</option>
                    <option value="20" <?=($limit == 20) ? "selected" : null?>>20</option>
                    <option value="50" <?=($limit == 50) ? "selected" : null?>>50</option>
                </select>
            </div>
        </div>
        <div class="c"></div>
    </div>
</div>
<!-- end of top blue bar with filter options -->
