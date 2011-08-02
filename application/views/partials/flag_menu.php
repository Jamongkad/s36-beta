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
    $nav_links = Array('inbox', 'inbox/published', 'inbox/featured', 'inbox/filed');
    $links = Helpers::nav_switcher();
    $nav_links_name = Array(
          Array('key' => 'SHOW ALL', 'val' => 'all')
        , Array('key' => 'POSITIVE', 'val' => 4)
        , Array('key' => 'NEGATIVE', 'val' => 1)
        , Array('key' => 'NEUTRAL', 'val' => 3)  
        , Array('key' => 'CONTAINS PROFANITY', 'val' => 'profanity') 
        , Array('key' => 'FLAGGED', 'val' => 'flagged')
        , Array('key' => 'MOST CONTENT', 'val' => 'mostcontent')
    );
?>
<div class="admin-nav-bar">
    <ul>
        <?for($i=0; $i < count($links); $i++):?>
            <li>
                <?=HTML::link($links[$i], $nav_links_name[$i]['key'], 
                              Array('class' => (Helpers::filter_highlighter($nav_links, $nav_links_name[$i]['val'])) ? 'selected' : null));?>   
            </li>
        <?endfor?>
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
