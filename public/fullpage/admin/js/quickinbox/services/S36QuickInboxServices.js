angular.module('S36QuickInboxServices', [])
.service('QuickInboxService', function($rootScope) {
    
    var shared_service = {};
   
    shared_service.preview_feeds = function(feed_status, feeds) {         

        var unique = [];
        $.each(feeds, function(i, el){
            if($.inArray(el, unique) === -1) unique.push(el);
        });

        $.ajax({
            type: 'POST'    
          , dataType: 'json'
          , data: { 'status': feed_status, 'feeds': unique }
          , url: '/hosted/preview_feeds'
          , success: function(data) {  

                $("#feedbackContainer").html(data.view);

                var fullpageLayout;
                var theme = data.theme_name;

                var fullpageCommon = new S36FullpageCommon;

                if(theme == 'timeline') { 
                    fullpageLayout = new S36FullpageLayoutTimeline;
                    console.log("Timeline");
                }

                if(theme == 'traditional') { 
                    fullpageLayout = new S36FullpageLayoutTraditional;
                    console.log("Traditional");
                }

                if(theme == 'treble') { 
                    fullpageLayout = new S36FullpageLayoutTreble;
                    console.log("Treble");
                }
               
                fullpageLayout.init_fullpage_layout()
                fullpageCommon.init_fullpage_common()
                S36FeedbackActions.initialize_actions(fullpageLayout)

                $('.widget-list').jScrollPane();
            }
        });
    }
 
    return shared_service;
});
