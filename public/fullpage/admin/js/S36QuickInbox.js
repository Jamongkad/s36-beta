var app = angular.module("QuickInbox", []);

app.controller("AppCtrl", function($scope, $http, $timeout, $compile, QuickInboxService) {

    $scope.feedbacks = [];

    (function feed_request() { 
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
                    //QuickInboxService.info_block_behavior();
                    $('.widget-list').jScrollPane();
                }, 10000);
            }
        });
    })();

    $scope.publish = function(id) {
        alert("Publishing! " + id);
    }

    $scope.feature = function(id) { 
        alert("Featuring! " + id);
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
               
                template += '<div class="delete-block" ng-click="delete_media(' + meta[i].mid + ')" mid="' + meta[i].mid + '">x</div>';
                //this should refer to pic or youtube link location...
                template += '<div class="the-thumb"><img src="fullpage/admin/img/sample-inbox-image2.jpg" width="100%" /></div>';
                template += '</div>';

            }
            template += '</div>';
            return $compile(template)($scope);
        }
        
    }

    $scope.delete_media = function(id) {
        alert('Deleting Media id of ' + id);
    }

});


app.service('QuickInboxService', function($rootScope) {
    
    var shared_service = {};
    shared_service.message;

    shared_service.info_block_behavior = function(cb) { 
        $('.delete-block').bind('click', function(e) {
            alert('Delete Media Id: ' + $(this).attr('mid'));
        })
    }
 
    return shared_service;
});
