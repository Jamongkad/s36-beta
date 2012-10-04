angular.module('reply', [])
.directive('myReply', function(MessageService) {
    
    return {
        restrict: 'A'       
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) { 

                var feedid = $(this).attr('feedid'); 
                var msgsel = $('.dialog-form[feedid='+feedid+'] form div.reply-box-form table td ul.msgsel')
                var type = "msg";//"rqs"; 

                MessageService.get_messages(type);
                var mes = MessageService.message;

                var markup = "<li id='${id}' text='${text}'><a href='#'>${short_text}</a></li>";
                $.template("li_template", markup);
                $.tmpl("li_template", mes).appendTo(msgsel.empty());

                msgsel.children('li[id]').bind('click', function(e) {
                    var quickmessage = $(this).attr('text');
                    var textarea = $(this).parents('td').prev('td').children('textarea');

                    textarea.val(quickmessage); 
                    e.preventDefault();
                });

                $('.dialog-form[feedid='+feedid+']').dialog('open'); 

                e.preventDefault();
            });
        }
    } 

})
.directive('replyCancel', function(){
    return function(scope, element, attrs){
        $(element).bind('click', function(e) {
            $(this).parents('form textarea[name=bcc] textarea[name=message]').clearFields();
            $(this).parents('.dialog-form').dialog('close');
            e.preventDefault();
        });
    }
})
.directive('replySend', function() {
    return function(scope, element, attrs){
        $(element).parents('form').validate({
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    success: function() {
                        alert("Your reply has been sent!");
                        $(element).parents('.dialog-form').dialog('close'); 
                        $(element).parents('form textarea[name=bcc] textarea[name=message]').clearFields();
                    }        
                });
            }
		  , errorElement: "em"
          , rules: {
                message: {
                    required: true     
                }
            }
        });
    }
})
.directive('replyBcc', function() {
    return function(scope, element, attrs){
        $(element).children('li').bind('click', function(e) {
            var children = $(this).children('a');
            var email = children.attr('email');
            var my_id = children.attr('feedid');
            var textarea = $(".bcc-target[feedid="+my_id+"]").children('textarea');

            textarea.val(textarea.val() + email + ","); 
            e.preventDefault();
        });
    }
 
})
.directive('configureReply', function() { 
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {  
                var id = $(this).attr('id');  
                $('.reply-configure[id='+id+']').dialog('open'); 
                e.preventDefault();
            })
        }
    }   
})
.directive('replyConfigure', function() { 
    return {
        restrict: 'C'     
      , transclude: true
      , scope: {}
      , controller: function($scope, $element, $rootScope) {
            $scope.name = "Add Message Item"; 
        }
    }   
})
.directive('cancelAdd', function() { 
    return {
        require: '^replyConfigure'   
      , restrict: 'A'
      , link: function(scope, element, attr, tabsCtrl) {
            console.log(element);
            console.log(tabsCtrl);
        }
    }    
})

function ReplyConfigure($scope) {
    $scope.name = "Add Mathew Item";
}

//dialog form init
$('.dialog-form').dialog({
    autoOpen: false  
  , height: 670
  , width: 700 
  , modal: true
  , close: function(e, ui) {    
        $(".regular-text[name=bcc], .regular-text[name=message]").val("");
    }
});

$('.reply-configure').dialog({
    autoOpen: false  
  , height: 110
  , width: 200
  , modal: true
});
