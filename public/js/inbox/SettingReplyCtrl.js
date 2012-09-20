var myModule = angular.module('myModule', []);
myModule.factory('mySettingsService', function($rootScope) {
    var shared_service = {};

    shared_service.message = null;

    shared_service.msg = $.ajax({
        type: 'GET'    
      , dataType: 'json'
      , async: true
      , url: 'settings/get_msgs'
      , success: function(data) {
            shared_service.message = data;
        }
    });

    return shared_service;
});

function SettingReplyCtrl($scope, mySettingsService) {

    console.log(mySettingsService);
    $scope.msgs = mySettingsService.message;
    /* 
    function my_msg() { 
        $.ajax({
            type: 'GET'    
          , dataType: 'json'
          , async: true
          , url: 'settings/get_msgs'
          , success: function(data) {
                $scope.$apply(function(){
                    $scope.msgs = data;      
                }) 
            }
        });
    }
    
    my_msg();
    */

    $scope.get_msgs = function() {
        return $scope.msgs;   
    };

    $scope.add_msg = function($event) {

        if(!$scope.form_msg_text) {
            alert("cannot be blank!");
        } else { 
            $.ajax({
                type: 'POST'
              , url: 'settings/save_reply_msg'     
              , dataType: 'json'
              , data: {"msg": $scope.form_msg_text}
              , success: function(data) {
                    $scope.$apply(function(){
                        $scope.msgs.push(data);
                    }) 
                }
            })
            $scope.form_msg_text = null;
        }
        $event.preventDefault();
    };

    $scope.delete_msg = function(data, $event) {
        $.ajax({
            url: 'settings/delete_msg/' + data
          , success: function() { $("div#" + data + ".grids").remove(); }
        }); 
        $event.preventDefault();
    };

    $scope.edit_msg = function(id, $event) {        

        var me = $($event.target);
        var sib = me.next();

        var input = $("input#" + id + "[name=reply_message]");
        var span = $("span#" + id + ".replymsg-text");
     
        me.hide();
        sib.show();
        input.show();
        span.hide();
        $event.preventDefault();
    };

    $scope.update_msg = function(id, $event) {

        var me = $($event.target);
        var sib = me.prev();
 
        var input = $("input#" + id + "[name=reply_message]");
        var span = $("span#" + id + ".replymsg-text");

        $.ajax({
            type: 'POST'
          , url: 'settings/update_reply_msg' 
          , dataType: 'json'
          , data: {"msg": input.val(), "id": id}
        }); 

        span.text(input.val());
        
        me.hide();
        sib.show();
        input.hide();
        span.show();
        $event.preventDefault();
    };
}

SettingReplyCtrl.$inject = ['$scope', 'mySettingsService'];
