<!--start of undo bar-->
<input type="hidden" name="undo-count" value="0" />
<div class="undo-bar" delete_action="<?=URL::to('/feedback/undodelete/')?>" goto_trash="<?=URL::to('/inbox/deleted')?>"></div>
<div class="checky-bar"></div>
<!--end of undo bar-->
<!-- top navigation bar -->
<? 
    $nav_links = Array('inbox', 'inbox/published', 'inbox/featured', 'inbox/filed');
    $links = Helpers::nav_switcher();
    $nav_links_name = Array(
          Array('key' => 'SHOW ALL', 'val' => 'all')
        , Array('key' => 'POSITIVE', 'val' => 'positive')
        , Array('key' => 'NEGATIVE', 'val' => 'negative')
        , Array('key' => 'NEUTRAL', 'val' => 'neutral')  
        , Array('key' => 'CONTAINS PROFANITY', 'val' => 'profanity') 
        , Array('key' => 'FLAGGED', 'val' => 'flagged')
        , Array('key' => 'MOST CONTENT', 'val' => 'mostcontent')
    );
?>
<?if(!preg_match('/deleted/', Request::uri())):?>
    <div class="admin-nav-bar">
            <ul>
                <?for($i=0; $i < count($links); $i++):?>
                    <li>
                        <?=HTML::link($links[$i].((Input::get('site_id')) ? '?site_id='.Input::get('site_id') : Null), $nav_links_name[$i]['key'], 
                                      Array('class' => (Helpers::filter_highlighter($nav_links, $nav_links_name[$i]['val'])) ? 'selected' : null));?>   
                    </li>
                <?endfor?>

                <?if(preg_match_all('/feedsetup/', Request::uri(), $matches)):?>
                    <?
                        $feedsetup_nav = Array(
                             'feedsetup' => 'CREATE WIDGETS'
                           , 'feedsetup/displayfeedback' => 'MY WIDGETS'
                        );
                    ?>

                    <?foreach($feedsetup_nav as $name => $value):?>
                        <li><?=HTML::link($name, $value, Array('class' => (Helpers::filter_highlighter(array($name)) ? 'selected' : null)))?></li>
                    <?endforeach?>
                   
                <?endif?>
               
                <?if(preg_match_all('/contacts/', Request::uri(), $matches)):?>
                    <li><?=HTML::link('contacts', 'LIST OF CONTACTS', 
                           Array('class' => (Helpers::filter_highlighter(array('contacts')) ? 'selected' : null)))?></li>
                    <li><?=HTML::link('contacts/important', 'IMPORTANT',
                           Array('class' => (Helpers::filter_highlighter(array('contacts/important')) ? 'selected' : null)))?></li>
                    <li><?=HTML::link('contacts/request', 'REQUEST FEEDBACK', 
                           Array('class' => (Helpers::filter_highlighter(array('contacts/request')) ? 'selected' : null)))?></li>
                <?endif?>
            </ul>
    </div>
<?endif?>
<!-- end of top navigation bar -->
<?if(!preg_match_all('/(feedsetup|displaysetup|displaypreview|contacts)/', Request::uri(), $matches)):?>
    <?if(!preg_match('/deleted/', Request::uri())):?>
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
    <?endif;?>
    <!-- top blue bar with filter options -->
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
                    <?$cat = new Category; ?>
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
<!-- end of top blue bar with filter options -->
