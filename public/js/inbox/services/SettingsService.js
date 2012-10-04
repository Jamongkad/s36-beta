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

        var markup = "<div class='edit-controls'><a id='${id}' class='edit-reply-msg' href='#'>edit</a>"
                   + "&nbsp;&nbsp;<a id='${id}' class='del-reply-msg' href='#'>del</a></div>"
                   + "<li style='width: 150px;'>"
                   + "<a id='${id}' text='${text}' href='#'>${short_text}</a>"
                   + "<input id='${id} 'type='text' name='msg' value='${text}' style='display:none'/>"
                   + "</li>"; 
        
        $.template("li_template", markup);
        $.tmpl("li_template", shared_service.message).appendTo(msgsel.empty());

        msgsel.children('li').children('a[id]').bind('click', function(e) {
            var quickmessage = $(this).attr('text');
            var textarea = $(this).parents('td').prev('td').children('textarea');

            textarea.val(quickmessage); 
            e.preventDefault();
        });

        msgsel.children('div.edit-controls').children('a.edit-reply-msg').bind('click', function(e) {
            console.log($(this));
            console.log($(this).attr('id'));
            e.preventDefault();
        })

        msgsel.children('div.edit-controls').children('a.del-reply-msg').bind('click', function(e) {
            console.log($(this));
            e.preventDefault();
        })
 
    }

    return shared_service;
});
