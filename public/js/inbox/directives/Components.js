angular.module('Components', ['reply', 'request', 'formbuilder', 'feedback'])
.directive('bcc', function() {
    return {  
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {
                console.log('clicked');
                attrs.$observe('feedid', function(at) {
                    console.log(at); 
                }) 
                e.preventDefault();
            });

        }
    }    
})
.directive('helloSettings', function() {
    return {
        restrict: 'E'     
      , template: '<h3>EMAIL SETTINGS</h3>'
    }  
})
.directive('execItem', function(MessageService) { 
    return {
        restrict: 'A'
      , link: function(scope, element, attr) {
            $(element).bind("click", function(e) {
                var configure = $('.modal-configure');
                var msgid = configure.children('#msgid').val();
                var text  = configure.children('.regular-text').val();
                var msgtype = configure.children('#msgtype').val();

                if(text.length == 0) {
                    alert("This field cannot be blank.");
                } else {      
                    if(msgid || msgid.length > 0) {

                        var msg_obj = {'type': msgtype, 'msg': text, 'id': msgid}
                        MessageService.update(msg_obj);

                        var a_msg = $("a#"+msgid);
                        a_msg.attr('req-text', MessageService.editdata.text);
                        a_msg.attr('id', MessageService.editdata.id);
                        a_msg.html(MessageService.editdata.short_text);

                    } else {    
                        MessageService.save({'type': msgtype, 'msg': text});

                        if(msgtype == 'msg') {
                            MessageService.fetch_messages(msgtype);     
                            MessageService.register_reply_message();
                        }

                        if(msgtype == 'rqs') {
                            MessageService.fetch_messages(msgtype);     
                            MessageService.register_request_message();
                        }
                       
                    }
                    configure.dialog("close");
                }
            });
        }
    }    
})
