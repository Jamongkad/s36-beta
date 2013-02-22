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

                if(theme == 'timeline') { 
                    var fullpageLayout = new S36FullpageLayoutTimeline;
                }

                if(theme == 'traditional') { 
                    var fullpageLayout = new S36FullpageLayoutTraditional;
                }

                if(theme == 'treble') { 
                    var fullpageLayout = new S36FullpageLayoutTreble;
                }

                fullpageLayout.init_fullpage_layout(); // initialize document ready of the current layout javascripts
                fullpageCommon.init_fullpage_common(); // initialize document ready of the common javascript

                S36FeedbackActions.initialize_actions(fullpageLayout);

                $("#feedbackContainer").html(data.view);
            }
        });
    }
 
    return shared_service;
});
