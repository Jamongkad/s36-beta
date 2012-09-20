angular.module('Components', [])
.directive('helloSettings', function() {
    return {
        restrict: 'E'     
      , template: '<h3>EMAIL SETTINGS</h3>'
    }  
})
.directive('msgsel', function() {
    var msgsel_fn;

    msgsel_fn = function(scope, element, attrs) {
        $(element).children('li[id]').bind('click', function(e) {
            console.log($(this).text());     
            e.preventDefault();
        });
    }

    return {
        restrict: 'C'     
      , link: msgsel_fn
    }  
})
.directive('reply', function() {
    return {
        restrict: 'C'     
      , link: function(scope, element, attrs) {
            $(document).delegate(element, 'click', function(e) {
                console.log(element);
                e.preventDefault();
            });
        }
    }   
})
