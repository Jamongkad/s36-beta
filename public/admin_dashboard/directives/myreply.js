angular.module('reply', [])
.directive('myReply', function(MessageService) {    
    return {
        restrict: 'A'       
      , scope: {
            feedid: "=feedid"   
        }
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) { 

                var feedid = scope.feedid;
                MessageService.fetch_messages('msg');
                MessageService.register_reply_message();

                MessageService.get_replybody(feedid);
                MessageService.register_replybody();
                
                $('div#reply-to-user').draggable();
                $('div#reply-to-user.lightbox').show();

                $(".dialog-form[feedid="+feedid+"]").show();

                e.preventDefault();

            });
        }
    } 
})
.directive('replyCancel', function(MessageService){
    return function($scope, element, attrs){
        $(element).bind('click', function(e) {

            var choice = $(this).attr('value');
              
            $scope.$apply(function() {
                $scope.template = { name: "reply_form", url: "/feedback/load_reply_form" };     
            });

            if(choice == 'Cancel') { 
                $('textarea[name=bcc]').clearFields();
                $('textarea[name=message]').clearFields();
                $(this).parents(".dialog-form").fadeOut();
                $('div#reply-to-user').draggable("destroy");
                $(".reply_cancel_button").val("Cancel");
            }

            if(choice == 'Back') {
                $(".reply_cancel_button").val("Cancel");
            }

            $(".reply_send_button").val("Send");

            MessageService.fetch_messages('msg');     
            MessageService.register_reply_message();
 
            e.preventDefault();
        });
    }
})
.directive('replySend', function(MessageService) {
    return {
        restrict: 'A' 
      , link: function($scope, element, attrs) {
            $(element).bind('click', function(e) {
            
                var choice = $(this).attr('value');

                if(choice == 'Save') { 
 
                    if($('#mymessage').val() == "") {
                        $('#mymessage').css({
                            'border': '1px solid red'
                        })
                    } else {

                        $('#mymessage').removeAttr('style');

                        MessageService.save(MessageService.msgdata);

                        var msgtype = MessageService.msgdata.msgtype;

                        if(msgtype == 'msg') {
                            MessageService.fetch_messages(msgtype);     
                            MessageService.register_reply_message();
                        }

                        $scope.$apply(function() {
                            $scope.template = { name: "reply_form", url: "/feedback/load_reply_form" };     
                        });
                    }
                }

                if(choice == 'Send') { 
                    var data = $('form.reply-form').serializeForm();
                    if($('#email_message').val() == "") {
                        $('#email_message').css({
                            'border': '1px solid red'
                        })
                    } else {
                        $('#email_message').removeAttr('style');
                        MessageService.send_email(data, function() { 
                            alert("Email Sent!");
                            $('textarea[name=bcc]').clearFields();
                            $('textarea[name=message]').clearFields();
                            $(".dialog-form").fadeOut();
                            $('div#reply-to-user').draggable("destroy");
                            $(".reply_cancel_button").val("Cancel");
                        });           
                    }
                   
                }

                $(".reply_cancel_button").val("Cancel");
                $(".reply_send_button").val("Send");
                e.preventDefault();
            });
        }
    }
})
.directive('addReply', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {
                var quickmessage = $(this).attr('req-text');
                var textarea = $("textarea[name=message]");
                textarea.val(quickmessage); 
                e.preventDefault();
            });
        }
    }  
})
.directive('deleteReply', function() {
    return {
        restrict: 'A'
      , link: function(scope, element, attrs) {
            $(element).bind("click", function(e) {
                $(this).parents('li').remove();
                e.preventDefault();
            })
        }
    }    
})
.directive('editReply', function() {
    return {
        restrict: 'A'
      , link: function($scope, element, attrs) {
            $(element).bind("click", function(e) {  
                $(".reply_send_button").val("Save");
                $(".reply_cancel_button").val("Back");
                e.preventDefault();
            })
        }
    }     
})
.directive('configureReply', function() { 
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {  
                $(".reply_send_button").val("Save");
                $(".reply_cancel_button").val("Back");
                e.preventDefault();
            })
        }
    }   
})
.directive('bcc', function() {
    return {  
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {
                var feedid = $(this).attr('feedid');
                var email = $(this).attr('email');
                var textarea = $('textarea[name=bcc][feedid=' + feedid + ']');
                var values = textarea.val() + email + ',';

                textarea.val(values);
                e.preventDefault();
            });

        }
    }    
})
.directive('editReplySettings', function(MessageService) {
    return {
        restrict: 'A'     
      , scope: {
            msgid: '=msgid'   
          , action: '@action'
        }
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {
                          
                var deselect_this = false;

                var id = scope.msgid;   
                var action = scope.action;

                var me = $(this);
 
                var input = $("textarea#" + id + ".dashboard-text");
                //input.autoGrow();
                var span = $("span#" + id + ".replymsg-text");

                if(action == 'edit') {
                    var sib = me.next();     
                } else { 
                    var sib = me.prev();     
                }

                me.parents("div#replymsg-list").children('div').children().children().children('textarea').each(function() { 
                    $(this).siblings('span').show();
                    $(this).hide();
                    var edit_links = $(this).parents('div.g1of3').siblings('div.g1of3').children('a[action=edit]:hidden');
  
                    if(edit_links) { 
                      $(this).parents('div.g1of3').siblings('div.g1of3').children('a[action=update]').hide();
                      $(this).parents('div.g1of3').siblings('div.g1of3').children('a[action=edit]').show();
                    } else { 
                      $(this).parents('div.g1of3').siblings('div.g1of3').children('a[action=update]').show();
                      $(this).parents('div.g1of3').siblings('div.g1of3').children('a[action=edit]').hide();
                    }
                
                })
 
                if(action == 'edit') { 

                    if(!deselect_this) {
                        input.show(); 
                        me.hide();
                        sib.show();
                        span.hide();                
                    }
            
                } else { 

                    if(input.val() == "") {
                        alert("Please provide a reply message.");
                    } else {
                        me.hide();
                        sib.show();
                        input.hide();
                        span.show();                
                        
                        var data = { 'msgtype': 'msg', 'id': id, 'text': input.val() };
                        MessageService.save(data);
                        span.html(MessageService.pushdata.short_text);
                    }

                }
                e.preventDefault();
            });
        }
    }    
})
