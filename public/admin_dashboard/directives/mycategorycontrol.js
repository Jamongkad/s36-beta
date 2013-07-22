angular.module('categorycontrol', [])
.directive('add', function() {    
    return {
        restrict: 'A'       
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {
                e.preventDefault();
            });
        }
    }
})
.directive('renameCtgy', function(Category) {
    return {
        restrict: 'A'       
      , scope: {
          catid: "@catid"    
        }
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {
                var that = $(this);

                var input = $('<input type="text" name="ctgy_nm"/>').val(
                    that.parents('div').siblings('div').children('.ctgy-name').html()
                );

                if(that.text() == "Update") {
                    var ctgy_nm_val = $('input[name="ctgy_nm"]').val()

                    that.text("Rename") 
                        .parents('div')
                        .siblings('div')
                        .children('.ctgy-name')
                        .html( ctgy_nm_val ).end().end().end();

                    Category.modify({ctgy_id: scope.catid, ctgy_nm: ctgy_nm_val});

                } else {
                    that.text("Update")     
                        .parents('div')
                        .siblings('div')
                        .children('.ctgy-name')
                        .html( input ).end().end().end()
                }
                e.preventDefault();
            });
        }
    }
    
})
