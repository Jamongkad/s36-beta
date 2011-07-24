<!-- gray status bar -->
<div class="admin-status-bar">
    <div class="current-page inbox">INBOX <!--<span>There were 27 new feedback since your last visit.</span>--></div>
</div>
<!-- end of gray status bar -->

<!--start of undo bar-->
<div class="undo-bar"></div>
<!--end of undo bar-->

<!-- top navigation bar -->
<div class="admin-nav-bar">
    <ul>
        <li><a href="#" class="selected">SHOW ALL</a></li>
        <li><a href="#">POSITIVE</a></li>
        <li><a href="#">NEGATIVE</a></li>
        <li><a href="#">NEUTRAL</a></li>
        <li><a href="#">CONTAINS PROFANITY</a></li>
        <li><a href="#">FLAGGED</a></li>
        <li><a href="#">MOST CONTENT</a></li>
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
