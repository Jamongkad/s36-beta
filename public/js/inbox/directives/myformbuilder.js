angular.module('formbuilder', [])
.directive('myFormbuilder', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) { 
            $(element).formbuilder({'useJson': true});
            $(element).children('ul').sortable({ opacity: 0.6, cursor: 'move', axis: "y" });
        }
    }    
})
