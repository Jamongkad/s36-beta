var app = angular.module("QuickInbox", ['S36QuickInboxDirectives', 'S36QuickInboxServices', 'ngSanitize']);

app.controller("AppCtrl", function($scope, $compile, QuickInboxService) {

    $scope.feedbacks = [];

    $scope.featured;
    $scope.published;
    $scope.deleted;

    var poll_server = true;
 
    (function feed_request() { 
        if(poll_server) { 
            $.ajax({
                type: 'GET'    
              , dataType: 'json'
              , async: false
              , url: '/hosted/quick_inbox'
              , success: function(data) {  
                    $scope.feedbacks = data;
                    $scope.$apply($scope.feedbacks);
                    setTimeout(function() { 
                        feed_request();  
                        QuickInboxService.info_block_behavior();
                        $('.widget-list').jScrollPane();
                    }, 30000); 
                }
            });
        }

        $('#quickInbox').unbind('mouseenter.widget').bind('mouseenter.widget', function() { 
            poll_server = false;      
        });

        $('#quickInbox').unbind('mouseleave.widget').bind('mouseleave.widget', function() { 
            poll_server = true;      
            feed_request();  
        });
    })();

    $scope.publish = function(id) {
        $scope.published = id;
        QuickInboxService.change_feedback_state(id, 'publish');
    }

    $scope.feature = function(id) { 
        $scope.featured = id;
        QuickInboxService.change_feedback_state(id, 'feature');
    }

    $scope.delete = function(id) {
        $scope.deleted = id;
        QuickInboxService.change_feedback_state(id, 'delete');
    }

    $scope.info_block = function(data) {

        var template, subcontent_check = data['subcontent']; ;

        if(subcontent_check) {
            template = '<div class="additional-info">';            
            template += $scope.metadata_block(data);
            template += $scope.media_block(data);
            template += '</div>';
        }

        return template;
    }

    $scope.metadata_block = function(data) {
        if(data.hasOwnProperty('metadata')) { 
            var meta = data['metadata'];

            var template = '<div class="custom-meta-list grids">'
            for(var i=0; i < meta.length; i++) {
                template += '<div class="custom-meta">'           
                template += '<div class="custom-meta-name">' + meta[i].key + ' : <span class="value">' + meta[i].value + '</span></div>'
                template += '</div>'
            }
            template += '</div>';
            return template;
        }
    }

    $scope.media_block = function(data) {
        if(data.hasOwnProperty('media')) { 
            var meta = data['media'];

            var template = '<div class="uploaded-images-and-links grids">';
            for(var i=0; i < meta.length; i++) {

                template += '<div class="image-block ' + meta[i].type +'">';

                if(meta[i].type == 'video') {
                    template += '<div class="video-circle"></div>';
                }
               
                template += '<div class="delete-block" punch mid="' + meta[i].mid + '">x</div>';
                //this should refer to pic or youtube link location...
                template += '<div class="the-thumb"><img src="fullpage/admin/img/sample-inbox-image2.jpg" width="100%" /></div>';
                template += '</div>';

            }
            template += '</div>';
            return template;
        }
        
    }

});
