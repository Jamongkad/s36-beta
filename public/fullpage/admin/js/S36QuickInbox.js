var app = angular.module("QuickInbox", ['S36QuickInboxDirectives', 'S36QuickInboxServices', 'CompileHtml']);

app.controller("AppCtrl", function($scope, $compile, QuickInboxService) {

    $scope.feedbacks = [];

    $scope.featured;
    $scope.published;
    $scope.deleted;

    $scope.info_block_html = "";

    var poll_server = true; 
    var timer;  

    (function feed_request() { 
        if(poll_server) { 
            $.ajax({
                type: 'GET'    
              , dataType: 'json'
              , async: false
              , url: '/hosted/quick_inbox'
              , success: function(data) {  

                    timer = new Timer(function() { 
                        feed_request();  
                        $('.widget-list').jScrollPane();
                    }, 30000); 

                    $scope.feedbacks = data;
                    $scope.$apply($scope.feedbacks); 
                }
            });
        }

        $('#quickInbox').unbind('mouseenter.widget').bind('mouseenter.widget', function() { 
            poll_server = false;      
            timer.pause();
            console.log("Stopping");
        });

        $('#quickInbox').unbind('mouseleave.widget').bind('mouseleave.widget', function() { 
            poll_server = true;      
            timer.resume();
            console.log("Starting");
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

    $scope.test_punch = function(data) {
        console.log(data);
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
               
                template += '<div class="delete-block" ng-click="test_punch(1000)" punch mid="' + meta[i].mid + '">x</div>';
                //this should refer to pic or youtube link location...
                template += '<div class="the-thumb"><img src="fullpage/admin/img/sample-inbox-image2.jpg" width="100%" /></div>';
                template += '</div>';

            }
            template += '</div>';
            return template;
        }
        
    }

});

function Timer(callback, delay) {

    var timerId, start, remaining = delay;

    this.pause = function() {
        window.clearTimeout(timerId);
        remaining -= new Date() - start;
    };

    this.resume = function() {
        start = new Date();
        timerId = window.setTimeout(callback, remaining);
    };

    this.resume();        
}
