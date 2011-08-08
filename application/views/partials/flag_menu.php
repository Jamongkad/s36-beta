<!--start of undo bar-->
<input type="hidden" name="undo-count" value="0" />
<div class="undo-bar" delete_action="<?=URL::to('/feedback/undodelete/')?>" goto_trash="<?=URL::to('/inbox/deleted')?>"></div>
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

            <?if(preg_match_all('/feedsetup/', Request::uri(), $matches)):?>
                <?
                    $feedsetup_nav = Array(
                         'feedsetup' => 'FEATURED FEEDBACK SETUP'
                       , 'feedsetup/displayfeedback' => 'FEEDBACK DISPLAY SETUP'
                       , 'feedsetup/displaysetup' => 'POPUP DISPLAY SETUP'
                       , 'feedsetup/displaypreview' => 'DISPLAY PREVIEW'
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
<!-- end of top navigation bar -->
<?if(!preg_match_all('/(feedsetup|displaysetup|displaypreview|contacts)/', Request::uri(), $matches)):?>
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
                        <?foreach(array_reverse(range(1, 5)) as $rating):?>
                            <option><?=$rating?></option>
                        <?endforeach?> 
                    </select>
                </div>
                <div class="g1of5" style="width: 25%">
                    <label>CATEGORY</label>
                    <?$cat = new Category; ?>
                    <select>
                        <option>All</option>
                        <?foreach($cat->pull_site_categories() as $category):?>
                            <option><?=$category->name?></option> 
                        <?endforeach?>
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
<?endif?>
<!-- end of top blue bar with filter options -->
