angular.module('Components', ['reply', 'request'])
.directive('helloSettings', function() {
    return {
        restrict: 'E'     
      , template: '<h3>EMAIL SETTINGS</h3>'
    }  
})

$('.reply-configure, .request-configure, .modal-configure').dialog({
    autoOpen: false  
  , height: 402
  , width: 456
  , modal: true
});
