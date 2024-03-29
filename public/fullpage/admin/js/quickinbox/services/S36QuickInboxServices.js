angular.module('S36QuickInboxServices', [])
.service('QuickInboxService', function($rootScope) {
    
    var shared_service = {};

    shared_service.change_feedback_status = function(feedstatus, feeds) { 
        $.ajax({
            type: 'POST'    
          , data: { 'feedstatus': feedstatus, 'feeds': unique(feeds) }
          , url: '/hosted/change_feedback_status'
          , success: function() {    
                window.location.reload(true);
            }
        });
    }
   
    shared_service.render_feeds = function(mystatus, feeds) {         
        
        if(mystatus !== 'delete') { 
            $.ajax({
                type: 'POST'    
              , dataType: 'json'
              , data: { 'feeds': unique(feeds) }
              , url: '/hosted/render_feeds'
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
    }
 
    return shared_service;
});

function unique(myarray) { 
    var unique = [];
    $.each(myarray, function(i, el){
        if($.inArray(el, unique) === -1) unique.push(el);
    });

    return unique
}
