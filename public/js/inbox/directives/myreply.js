angular.module('reply', [])
.directive('myReply', function() {
    return function(scope, element, attrs) {
        $(element).bind('click', function(e) {
            var feedid = $(this).attr('feedid'); 
            $('.dialog-form[feedid='+feedid+']').dialog('open'); 
            console.log(feedid); 
            console.log($('.dialog-form[feedid='+feedid+']'));
            e.preventDefault();
        });
    }
})
