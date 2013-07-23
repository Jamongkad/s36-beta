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
.directive('categoryAdd', function() {
    return {
        restrict: 'A'       
      , link: function(scope, element, attrs) {
            $(element).bind('keyup', function(e) {
                console.log($(this).val().length());
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
                    
                    if(ctgy_nm_val == 'undefined' || ctgy_nm_val == null || ctgy_nm_val == "")  { 
                        alert("Cannot be blank!");
                    } else { 
                        that.text("Rename") 
                            .parents('div')
                            .siblings('div')
                            .children('.ctgy-name')
                            .html( ctgy_nm_val ).end().end().end();

                        Category.modify({ctgy_id: scope.catid, ctgy_nm: ctgy_nm_val});
                    }
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
.directive('deleteCtgy', function(Category) { 
    return {
        restrict: 'A'
      , scope: {
            catid: "@catid"
        }
      , link: function(scope, element, attrs) {
           $(element).bind("click", function(e) {
                if(confirm("Are you sure you want to delete this category?")) {
                    var myparent = $(this).parents('div#category-' + scope.catid);
                    myparent.remove();
                    Category.delete(scope.catid);
                }
                e.preventDefault();
            });
        }
    }
})
