<!--start of undo bar-->
<input type="hidden" name="undo-count" value="0" />
<div class="undo-bar" delete_action="<?=URL::to('/feedback/undodelete/')?>" goto_trash="<?=URL::to('/inbox/deleted')?>"></div>
<!--
<div class="checky-bar"></div>
-->
<!--end of undo bar-->
<!-- top navigation bar -->
<? 
    $nav_links = Array('inbox', 'inbox/published', /*'inbox/featured',*/ 'inbox/filed');
    $links = Helpers::nav_switcher(); 
    $nav_regex = Helpers::nav_regex();

    if($nav_regex->published) { 
        $nav_links_name = Array(
              Array('key' => 'SHOW ALL', 'val' => 'all')
            , Array('key' => 'CONTAINS PROFANITY', 'val' => 'profanity') 
            , Array('key' => 'FLAGGED', 'val' => 'flagged')
            , Array('key' => 'MOST CONTENT', 'val' => 'mostcontent')
        );
    } else {  
        $nav_links_name = Array(
              Array('key' => 'SHOW ALL', 'val' => 'all')
            , Array('key' => 'POSITIVE', 'val' => 'positive')
            , Array('key' => 'NEGATIVE', 'val' => 'negative')
            , Array('key' => 'NEUTRAL', 'val' => 'neutral')  
            , Array('key' => 'CONTAINS PROFANITY', 'val' => 'profanity') 
            , Array('key' => 'FLAGGED', 'val' => 'flagged')
            , Array('key' => 'MOST CONTENT', 'val' => 'mostcontent')
        );
    }

?>
<?if(!preg_match('/(deleted|contacts)/', Request::uri())):?>
    <div class="admin-nav-bar">
            <ul>
                <?for($i=0; $i < count($links); $i++):?>
                    <li>
                        <?=HTML::link($links[$i].((Input::get('site_id')) ? '?site_id='.Input::get('site_id') : Null), $nav_links_name[$i]['key'], 
                                      Array('class' => (Helpers::filter_highlighter($nav_links, $nav_links_name[$i]['val'])) ? 'selected' : null));?>   
                    </li>
                <?endfor?>
                 
                <!--TODO goodness please think of a more robust solution for this view...-->
                <?if(preg_match_all('/feedsetup/', Request::uri(), $matches)):?>
                    <?
                        $feedsetup_nav = Array();
                        if(   $display = preg_match('~feedsetup/overview/(display|submit)~', Request::uri(), $matches)
                           or $edit_widget = preg_match('~feedsetup/edit/([a-zA-Z0-9]+)/(display|submit)~', Request::uri(), $matches) 
                           or $create_display_widget = preg_match('~feedsetup/wizard/(embed|modal)|feedsetup/hosted_widgets~', Request::uri(), $matches) 
                           or $create_form_widget = preg_match('~feedsetup/submission_widgets~', Request::uri(), $matches)
                           ) {

                            $dynamic_nav = Array();

                            if (isset($display) and $display == true) {
                                $dynamic_nav = Array(
                                    Request::uri() => 'OVERVIEW'
                                  , 'feedsetup/widget_selection'  => 'CREATE'
                                );
                            }
                            
                            if (isset($edit_widget) and $edit_widget == true) {
                                $dynamic_nav = Array(
                                      'feedsetup/overview/'.$matches[2] => 'OVERVIEW'
                                    , Request::uri() => 'EDIT'
                                );
                            }
                            
                            if ((isset($create_display_widget) and $create_display_widget == true) || (isset($create_form_widget) and $create_form_widget == true)) {
                                $dynamic_nav = Array(
                                      'feedsetup/widget_selection'  => 'SELECTION'
                                    , $matches[0] => 'CREATE'
                                );
                            }
                            

                            $feedsetup_nav = Array( 
                                 'feedsetup'  => 'DASHBOARD' 
                            );

                            $feedsetup_nav = $feedsetup_nav + $dynamic_nav; 

                        } else {
                            if(!preg_match_all('~feedsetup/formcode_manager~', Request::uri(), $matches)) {
                                $feedsetup_nav = Array(
                                     'feedsetup'  => 'DASHBOARD'
                                   , 'feedsetup/widget_selection' => 'CREATE'
                                );           
                            } //Default Nav     
                        }
                    ?> 
                    <?foreach($feedsetup_nav as $name => $value):?>
                        <li>
                            <?=HTML::link(  $name.((Input::get('site_id')) ? '?site_id='.Input::get('site_id') : Null), $value
                                          , Array('class' => (Helpers::filter_highlighter($name) ? 'selected' : null)) )?>
                        </li>
                    <?endforeach?> 
                <?endif?>   

                <?if(preg_match_all('/settings/', Request::uri(), $matches)):?>
                    <?
                        $settings = Array(
                             'settings' => 'SETTINGS'
                           , 'settings/company' => 'COMPANY'
                           //, 'settings/upgrade' => 'UPGRADE'
                           //, 'settings/change_card' => 'UPDATE CREDIT CARD'
                           //, 'settings/cancel_account' => 'CANCEL ACCOUNT'
                        );
                    ?>

                    <?foreach($settings as $name => $value):?>
                        <li>
                            <?=HTML::link(  $name.((Input::get('site_id')) ? '?site_id='.Input::get('site_id') : Null), $value
                                          , Array('class' => (Helpers::filter_highlighter($name) ? 'selected' : null)) )?>
                        </li>
                    <?endforeach?>  
                <?endif?>   
            </ul>
    </div>
<?endif?>
<!-- end of top navigation bar -->
<!-- top blue bar with filter options -->
<?=View::make('partials/admin_sorter_bar')?>
<!-- end of top blue bar with filter options -->
