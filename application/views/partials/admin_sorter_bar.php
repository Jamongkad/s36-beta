<?if(!preg_match_all('/(dashboard|feedsetup|displaysetup|displaypreview|contacts|settings|help)/', Request::uri(), $matches)):?>
<div class="admin-sorter-bar">
    <div class="sorter-bar">
        <div class="left">
            <input type="checkbox" class="click-all"/>
        </div>
        <div class="right">
            <div class="g1of5">
                <?=View::make('partials/feedback_select_controls')?>
            </div>
            <div class="g1of5">
                <label>SORT BY</label>
                <select>
                    <option>Date</option>
                    <option>Status</option>
                    <option>Priority</option>
                </select>
            </div>
            <div class="g1of5">
                <label>RATING</label>
                <select name="rating-limit">
                    <option>All</option>
                    <?foreach(array_reverse(range(1, 5)) as $rating):?>
                        <option value="<?=$rating?>" <?=((Input::get('rating') == $rating) ? 'selected' : null)?>><?=$rating?></option>
                    <?endforeach?> 
                </select>
            </div>
            <?
            $regex = Helpers::nav_regex();
            if($regex->filed):?>
            <div class="g1of5">
                <label>CATEGORY</label>
                <?$cat = new DBCategory; ?>
                <select style="width: 50%">
                    <option>All</option>
                    <?foreach($cat->pull_site_categories() as $category):?>
                        <option><?=$category->name?></option> 
                    <?endforeach?>
                </select>
            </div>
            <?endif?>
            <div class="g1of5">
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
<?endif?>
