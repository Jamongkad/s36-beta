<?php if( ! is_null($user) ): ?>
    <div id="notification">
        <div id="notification-design">
            <div id="notification-message">
                Loading... Please Wait... you bits.
            </div>
        </div>
    </div>
    <?//=View::make('hosted/partials/fullpage_admin_panel_view', Array('patterns' => $fullpage_patterns, 'panel' => $panel))?>
<?php endif; ?>
<div id="maskDisabler">
 <div id="maskPreloader">
        <div class="loading-icon"></div>
        <div class="loading-text">
            Please wait while we change your layout...
        </div>
    </div>
</div>

<?= View::make('hosted/partials/fullpage_bar_view'); ?>
<?= View::make('hosted/partials/fullpage_background_view'); ?>

<div id="mainWrapper">
    <div id="fadedContainer">
        <div id="mainContainer">
            
            <?= View::make('hosted/partials/fullpage_cover_view'); ?>            
            <?= View::make('hosted/partials/fullpage_company_summary_view', array('company' => $company, 'widget_loader' => $widget_loader, 'user' => $user)); ?>
            
            <?php if( $feed_count->published_feed_count == 0 ): ?>
                <div id="blankHostedPage">
                    <h1 class="first-head">Hey! Looks like you're the first one here. </h1>
                    <h1>Send in some feedback for <?php echo ucfirst(HTML::entities($company->company_name)); ?> by clicking on the stars.</h1>
                    <? /*<p class="send-button" widgetkey="<?=$company->widgetkey?>">
                        <a href="javascript:;">
                            Send in feedback
                        </a>
                    </p>*/ ?>
                </div>
            <?php endif; ?>
            
            
            <?php if( $feed_count->published_feed_count > 0 ): ?>
                <div id="feedbackContainer">
                    <div id="threeColumnLayout" class="hosted-layout">
                        <?=View::make('hosted/partials/fullpage_'.strtolower($panel->theme_name).'_layout_view', Array('collection' => $feeds, 'user' => $user))?>
                        <div id="feedback-infinitescroll-landing"></div>
                    </div>
                </div>
                <script type="text/javascript">
                    <? // hack to hide the first .feedback-date and show the first .spine-spacer. ?>
                    $('.feedback-date:first').css('display', 'none');
                    $('.spine-spacer:first').css({'display' : 'block', 'height' : '20px'});
                </script>
            <?php endif ?>
        </div>
    </div>
</div>

<?php
/*
|--------------------------------------------------------------------------
| Start adding JS and CSS Initialization and Override
|--------------------------------------------------------------------------
*/
?>
<?= HTML::style('/fullpage/layout/'.strtolower($panel->theme_name).'/css/S36FullpageLayout'.ucfirst($panel->theme_name).'.css'); ?>
<?= HTML::script('/fullpage/layout/'.strtolower($panel->theme_name).'/js/S36FullpageLayout'.ucfirst($panel->theme_name).'.js'); ?>

<script type="text/javascript">
    $(document).ready(function(){
        var fullpageCommon = new S36FullpageCommon;
        var fullpageLayout = fullpageCommon.create_layout('<?php echo $panel->theme_name; ?>'); 
        fullpageLayout.init_fullpage_layout(fullpageCommon); // initialize document ready of the current layout javascripts
        fullpageCommon.init_fullpage_common(); // initialize document ready of the common javascript
        
        <?php if($user): //then display the admin bar by default ?> 
            //var fullpageAdmin  = new S36FullpageAdmin(fullpageLayout);
            //fullpageAdmin.init_fullpage_admin();
        <?php endif; ?>

        /*
        / Infinite Scroll
        */
        S36FeedbackActions.initialize_actions(fullpageLayout, fullpageCommon);

        var container = $('#feedback-infinitescroll-landing');
        if( fullpageLayout.layout_name == 'treble' ) {
            container = $('.feedback-list');   
        }

        var counter = 0;    
        //lets get the first 6 months of feedback if there are any...
        for(var i=0; i<<?=$feed_advance_count?>; i++) {
            counter += 1; 
            var pg_c = counter + 1;

            render_children(container, pg_c);
        }

        function update() {
            if( $(window).scrollTop() + $(window).height() == $(document).height() ) {
                if( $('#adminWindowBox').length && $('#adminWindowBox').css('display') == 'block' ) return;
                
                counter += 1;
                var page_counter = counter + 1;

                render_children(container, page_counter);
            }
            
            fullpageLayout.init_fullpage_layout(fullpageCommon); // initialize document ready of the current layout javascripts
            fullpageCommon.init_fullpage_common(); // initialize document ready of the common javascript
            S36FeedbackActions.initialize_actions(fullpageLayout, fullpageCommon);

        }

        function render_children(container, counter) { 
            $.ajax({ 
                async: false,
                url: '/hosted/fullpage_partial/' + counter
              , success: function(msg) { 
                  var boxes = $(msg);
                  if( fullpageLayout.layout_name == 'treble' ) container.append(boxes.find('.feedback')); 
                  else container.append(boxes); 
                }
            });
        }
        //rate limit this bitch
        var throttled = _.throttle(update, 1000);
        $(window).scroll(throttled);
        /*
        / FancyBox
        */

        $("a.the-thumb-ajs").fancybox({
          openEffect : 'none',
          closeEffect : 'none'
         });

        $(".fullpage-fancybox").fancybox({
          openEffect : 'none',
          closeEffect : 'none'
         });
        $(".fancybox-video").click(function() {
            $.fancybox({
                'padding'       : 0,
                'autoScale'     : false,
                'transitionIn'  : 'none',
                'transitionOut' : 'none',
                'title'         : this.title,
                'width'         : 640,
                'height'        : 385,
                'href'          : this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
                'type'          : 'swf',
                'swf'           : {
                    'wmode'             : 'transparent',
                    'allowfullscreen'   : 'true'
                }
            });
            return false;
        });
    });
</script>

<? if($user): ?> 
<?= HTML::script('/js/angular.compilehtml.js'); ?>
<?= HTML::script('/fullpage/admin/js/quickinbox/controllers/S36QuickInbox.js'); ?>
<?= HTML::script('/fullpage/admin/js/quickinbox/directives/S36QuickInboxDirectives.js'); ?>
<?= HTML::script('/fullpage/admin/js/quickinbox/services/S36QuickInboxServices.js'); ?>
<? endif ?>
<?php 
/*
/ In-line css for fullpage
*/
?>
<div id="fullpage_css"><?php echo $fullpage_css; ?></div>

<div id="flagBoxDiv" style="display:none">
<div id="flagBox">
<input class="flag-feedback-id" type="hidden" value=""/>
<div class="flagbox-content">
        <div class="flagbox-head">
            <h2>Flag as Inappropriate</h2>
        </div>
        <div class="alert-message" style="display:none">
        </div>
        <div id="report_type_list" class="flagbox-body">
            <div class="padded-5">
                <ul>
                <?php
                foreach($reportTypes as $report_id=>$report_desc):
                ?>
                    <li>
                        <input class="feedbackReportItem flag-item-<?=$report_id?>" type="radio" name="flag-item" value="<?=$report_id?>" />
                        <label id="flag-item-<?=$report_id?>" class="reportTypeLabel"><?=$report_desc?></label>
                    </li>
                <?php endforeach; ?>
                </ul>
            </div>
            <div class="flagbox-foot">
                <div class="fdback-buttons">
                    <ul>
                        <li><a class="continue_report" href="#">Continue</a></li>
                        <li><a onClick="parent.jQuery.fancybox.close();" href="#">Cancel</a></li>
                    </ul>                   
                </div>
            </div>
        </div>
        
        <div id="report_user_info" class="flagbox-body" style="display:none">
            <div class="padded-5">
                <ul>
                    <li>To Continue, Fill up the fields below <br /><br /></li>
                        <li>
                            <label>Your Name :</label><br />
                            <input id="report_name" type="text" name="flagger-name" class="regular-text" title="Your Name" />
                        </li>
                        <li>
                            <label>Your Email :</label><br />
                            <input id="report_email" type="text" name="flagger-email" class="regular-text" title="Your Email" />
                        </li>
                        <li>
                            <label>Your Company (optional) :</label><br />
                            <input id="report_company" type="text" name="flagger-company" class="regular-text" title="Your Company (optional)" />
                        </li>
                        <li>
                            <label>Comments (optional) :</label><br />
                            <textarea id="report_comment" title="Comments"></textarea>
                        </li>
                    </ul>
                </div>
            <div class="flagbox-foot">
            <div class="fdback-buttons">
                    <ul>
                        <li><a id="back_report" href="#">Back</a></li>
                        <li><a class="continue_report" href="#">Continue</a></li>
                        <li><a onClick="parent.jQuery.fancybox.close();" href="#">Cancel</a></li>
                    </ul>                   
            </div>
            </div>
        </div>

        <div id="report_final" class="flagbox-body" style="display:none">
            <div class="flagbox-foot">
            <div class="fdback-buttons">
                    <ul>
                        <li><a onClick="parent.jQuery.fancybox.close();" href="#">Close</a></li>
                    </ul>                   
            </div>
            </div>
        </div>

    </div>
</div>
</div>
