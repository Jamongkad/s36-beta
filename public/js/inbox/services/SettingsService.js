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
                       + "<a id='${id}' text='${text}' class='msg-reply-link' href='#'>${short_text}</a>"
                       + "<div id='${id}' class='msg-reply-text'>"
                           + "<h4>Edit</h4><input type='text' class='regular-text' name='msg' value='${text}' /><br/>"
                           + "<div class='add-msg-box-buttons'>"
                              + "<input type='button' class='small-btn' value='Cancel'/>&nbsp;"
                              + "<input type='submit' class='small-btn' value='Update' />"
                           + "</div>"
                       + "</div>"
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
            var id = $(this).attr('id');
            var msg_reply_text = $("#"+id+".msg-reply-text");

            msg_reply_text.dialog('open');
            console.log(msg_reply_text.children('input'));
            
            e.preventDefault();
        })

        msgsel.children('div.edit-controls').children('a.del-reply-msg').bind('click', function(e) {
            console.log($(this));
            e.preventDefault();
        })
        
        //initialize dialog fuck this is durty
        $('.msg-reply-text').dialog({
            autoOpen: false  
          , height: 110
          , width: 200
          , modal: true
        });
    }

    return shared_service;
});
