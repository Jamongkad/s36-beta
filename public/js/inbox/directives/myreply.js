angular.module('reply', [])
.directive('myReply', function() {
    /*
    return function(scope, element, attrs) {
        $(element).bind('click', function(e) {
            var feedid = $(this).attr('feedid'); 
            $('.dialog-form[feedid='+feedid+']').dialog('open'); 
            e.preventDefault();
        });
    }
    */
    var linkfn = function(scope, element, attrs) {
        $(element).bind('click', function(e) {
            var feedid = $(this).attr('feedid'); 
            $('.dialog-form[feedid='+feedid+']').dialog('open'); 
            console.log(feedid);
            e.preventDefault();
        });
    }

    return {
        link: linkfn
    }

})
