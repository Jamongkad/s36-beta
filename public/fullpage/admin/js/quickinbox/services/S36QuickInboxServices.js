angular.module('S36QuickInboxServices', [])
.service('QuickInboxService', function($rootScope) {
    
    var shared_service = {};
   
    shared_service.preview_feeds = function(feed_status, feeds) {         
        $.ajax({
            type: 'POST'    
          , dataType: 'json'
          , data: { 'status': feed_status, 'feeds': feeds }
          , url: '/hosted/preview_feeds'
          , success: function(data) {  
                var fullpageLayout;
                var theme = data.theme_name;

                var fullpageCommon = new S36FullpageCommon;

                console.log(fullpageCommon);

                if(theme == 'timeline') { 
                    var fullpageLayout = new S36FullpageLayoutTimeline;
                    console.log("Timeline");
                    console.log(fullpageLayout);
                }

                if(theme == 'traditional') { 
                    var fullpageLayout = new S36FullpageLayoutTraditional;
                    console.log("Traditional");
                    console.log(fullpageLayout);
                }

                if(theme == 'treble') { 
                    var fullpageLayout = new S36FullpageLayoutTreble;
                    console.log("Treble");
                    console.log(fullpageLayout);
                }

                console.log(fullpageLayout.init_fullpage_layout()); // initialize document ready of the current layout javascripts
                console.log(fullpageCommon.init_fullpage_common()); // initialize document ready of the common javascript

                console.log(S36FeedbackActions.initialize_actions(fullpageLayout));
                $("#feedbackContainer").html(data.view);
            }
        });
    }
 
    return shared_service;
});
