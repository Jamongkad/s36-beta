angular.module('Components', [])
.directive('myReply', function() {
    return function(scope, element, attrs) {
        $(element).bind('click', function(e) {
            var feedid = $(this).attr('feedid'); 
            $('.dialog-form[feedid='+feedid+']').dialog('open'); 
            e.preventDefault();
        });
    }
})
