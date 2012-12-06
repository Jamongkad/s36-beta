angular.module('formbuilder', [])
.directive('myFormbuilder', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) { 
            $(element).formbuilder({
                'save_url': 'pwet'
              , 'load_url': 'irene'
              , 'useJson': true
              , messages { 
                    save				: "Pwet",
                    add_new_field		: "Add New Pwet...",
                }
            });

            $(element).children('ul').sortable({ opacity: 0.6, cursor: 'move'});
        }
    }    
})
