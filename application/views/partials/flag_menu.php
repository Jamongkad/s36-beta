<!-- gray status bar -->
<div class="admin-status-bar">
<?if(preg_match_all('/inbox\/(all|profanity|flagged|mostcontent|[0-9]+)/', Request::uri(), $matches)):?>
    <div class="current-page inbox"> 
        INBOX <!--<span>There were 27 new feedback since your last visit.</span>--> 
    </div>
<?endif?>
<?if(preg_match_all('/published\/(all|profanity|flagged|mostcontent|[0-9]+)/', Request::uri(), $matches)):?>
    <div class="current-page published"> 
        PUBLISHED <!--<span>There were 27 new feedback since your last visit.</span>--> 
    </div>
<?endif?>
<?if(preg_match_all('/featured\/(all|profanity|flagged|mostcontent|[0-9]+)/', Request::uri(), $matches)):?>
    <div class="current-page featured"> 
        FEATURED <!--<span>There were 27 new feedback since your last visit.</span>--> 
    </div>
<?endif?>
<?if(preg_match_all('/filed\/(all|profanity|flagged|mostcontent|[0-9]+)/', Request::uri(), $matches)):?>
    <div class="current-page filed"> 
        FILED <!--<span>There were 27 new feedback since your last visit.</span>--> 
    </div>
<?endif?>
</div>
<!-- end of gray status bar -->

<!--start of undo bar-->
<input type="hidden" name="undo-count" value="0" />
<div class="undo-bar">
</div>
<!--end of undo bar-->
<!-- top navigation bar -->
<?
    $all = Array('inbox/all', 'inbox/published/all', 'inbox/featured/all', 'inbox/filed/all');
    $positive = Array('inbox/4', 'inbox/published/4', 'inbox/featured/4', 'inbox/filed/4');
    $negative = Array('inbox/1', 'inbox/published/1', 'inbox/featured/1', 'inbox/filed/1');
    $neutral = Array('inbox/3', 'inbox/published/3', 'inbox/featured/3', 'inbox/filed/3');
    $profanity = Array('inbox/profanity', 'inbox/published/profanity', 'inbox/featured/profanity', 'inbox/filed/profanity');
    $flagged = Array('inbox/flagged', 'inbox/published/flagged', 'inbox/featured/flagged', 'inbox/filed/flagged');
    $content = Array('inbox/mostcontent', 'inbox/published/mostcontent', 'inbox/published/mostcontent', 'inbox/filed/mostcontent');

    $links = Helpers::nav_switcher();
?>
<div class="admin-nav-bar">
    <ul>
        <li><?=HTML::link($links[0], 'SHOW ALL', Array('class' => (Helpers::filter_highlighter($all)) ? 'selected' : null) )?></li>
        <li><?=HTML::link($links[1], 'POSITIVE', Array('class' => (Helpers::filter_highlighter($positive)) ? 'selected' : null))?></li>
        <li><?=HTML::link($links[2], 'NEGATIVE', Array('class' => (Helpers::filter_highlighter($negative)) ? 'selected' : null))?></li>
        <li><?=HTML::link($links[3], 'NEUTRAL', Array('class' => (Helpers::filter_highlighter($neutral)) ? 'selected' : null))?></li>
        <li><?=HTML::link($links[4], 'CONTAINS PROFANITY', Array('class' => (Helpers::filter_highlighter($profanity)) ? 'selected' : null))?></li>
        <li><?=HTML::link($links[5], 'FLAGGED' , Array('class' => (Helpers::filter_highlighter($flagged)) ? 'selected' : null))?></li>
        <li><?=HTML::link($links[6], 'MOST CONTENT', Array('class' => (Helpers::filter_highlighter($content)) ? 'selected' : null))?></li>
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
