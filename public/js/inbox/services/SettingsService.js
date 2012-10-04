angular.module('Services', [])
.service('MessageService', function($rootScope) {

    var shared_service = {};
    shared_service.message;

    shared_service.get_messages = function(type) { 
        $.ajax({
            type: 'GET'    
          , dataType: 'json'
          , async: false
          , url: '/message/get_msgs'
          , data: {"type": type}
          , success: function(data) {
                shared_service.message = data;
            }
        });
    }

    shared_service.render_message = function(feedid) { 
        var msgsel = $('ul.msg-sel[id='+feedid+']')
        var markup = "<li id='${id}' text='${text}'><a href='#'>${short_text}</a></li>";
        $.template("li_template", markup);
        $.tmpl("li_template", shared_service.message).appendTo(msgsel.empty());

        msgsel.children('li[id]').bind('click', function(e) {
            var quickmessage = $(this).attr('text');
            var textarea = $(this).parents('td').prev('td').children('textarea');

            textarea.val(quickmessage); 
            e.preventDefault();
        });
    }

    return shared_service;
});
