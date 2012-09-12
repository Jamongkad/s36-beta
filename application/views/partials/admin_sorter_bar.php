<?
$regex = '/(dashboard|feedsetup|displaysetup|displaypreview|contacts|admin|settings|help|feedback\/(modifyfeedback|reply_to|requestfeedback|addfeedback))/';
if(!preg_match_all($regex, Request::uri(), $matches) and S36Auth::check()):?>
<div class="admin-sorter-bar">
    <div class="sorter-bar">
        <div class="left">
            <input type="checkbox" class="click-all"/>
        </div>
        <div class="right">
            <div class="select-options">
                <?=View::make('partials/feedback_select_controls')?>
            </div>
            <div class="select-options">
                <label>Date</label>
                <select name="date-filter">
                    <option value="default">-</option>
                    <option value="date_new" <?=(Input::get('date') == "date_new") ? "selected" : null?>>Newest</option>
                    <option value="date_old" <?=(Input::get('date') == "date_old") ? "selected" : null?>>Oldest</option>
                </select>
            </div>
            <div class="select-options">
                <label>Priority</label>
                <select name="priority-filter">
                    <option value="default">-</option>
                    <option value="low" <?=(Input::get('priority') == "low") ? "selected" : null?>>Low</option>
                    <option value="medium" <?=(Input::get('priority') == "medium") ? "selected" : null?>>Medium</option>
                    <option value="high" <?=(Input::get('priority') == "high") ? "selected" : null?>>High</option>
                </select>
            </div>
            <div class="select-options">
                <label>Status</label>
                <select name="status-filter">
                    <option value="default">-</option>
                    <option value="new" <?=(Input::get('status') == "new") ? "new" : null?>>New</option>
                    <option value="inprogress" <?=(Input::get('status') == "inprogress") ? "selected" : null?>>In progress</option>
                    <option value="closed" <?=(Input::get('status') == "closed") ? "selected" : null?>>Closed</option>
                </select>
            </div>
            <div class="select-options">
                <label>Rating</label>
                <select name="rating-limit">
                    <option value="default">-</option>
                    <?foreach(array_reverse(range(1, 5)) as $rating):?>
                        <option value="<?=$rating?>" <?=((Input::get('rating') == $rating) ? 'selected' : null)?>><?=$rating?></option>
                    <?endforeach?> 
                </select>
            </div>
            <?
            $regex = Helpers::nav_regex();
            if($regex->filed):?>
            <div class="select-options">
                <label>Category</label>
                <?$cat = new DBCategory; ?>
                <select name="category-filter" style="width: 50%">
                    <option value="default">-</option>
                    <?foreach($cat->pull_site_categories() as $category):?>
                        <option value="<?=$category->intname?>" <?=((Input::get('category') == $category->intname) ? 'selected' : null)?>><?=$category->name?></option> 
                    <?endforeach?>
                </select>
            </div>
            <?endif?>
            <div class="select-options">
                <label>Display</label>
                <?$limit = Input::get('limit')?>
                <select name="feedback-limit">
                    <option value="default">-</option>
                    <option value="10" <?=($limit == 10) ? "selected" : null?>>10</option>
                    <option value="20" <?=($limit == 20) ? "selected" : null?>>20</option>
                    <option value="50" <?=($limit == 50) ? "selected" : null?>>50</option>
                </select>
            </div>
        </div>
        <div class="c"></div>
    </div>
</div>
<?endif?>
