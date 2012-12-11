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
.directive('myFormbuilderload', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) { 
            var widget_key = $(element).attr('widget_key');
            $(element).formbuilder({'load_url': '/feedsetup/load_formbuilder/' + widget_key, 'useJson': true});	
            $(element).children('ul').sortable({ opacity: 0.6, cursor: 'move', axis: "y" });
        }
    }    
})
.directive('myCreateform', function() {
    return {
        restrict: 'A'      
      , link: function(scope, element, attrs) {

           $(element.parents('form')).validate({
            submitHandler: function(form) {

                var form_db_id; 

                $(form).ajaxSubmit({
                    dataType: 'json'       
                  , beforeSubmit: function(formData, jqForm, options) {
                        new Status().notify("Processing...", 1000); 
                    }
                  , success: function(responseText, statusText, xhr, $form) {     
                        var widget_key      = responseText.submit.widget.widgetkey;
                        var widget_store_id = responseText.submit.widget.widgetstoreid;
                        var company_id      = responseText.submit.widget.company_id;

                        var formcode_url = $("#formcode-manager-url").attr('hrefaction') + "/" + widget_key;

                        $.ajax({
                            type: "POST"
                          , url: "/feedsetup/buildmetadata_options"
                          , data: $("ul[id^=frmb-]").serializeFormList({prepend: "frmb"}) + "&form_id=" + widget_store_id + "&company_id=" + company_id
                          , success: function() {
                                window.location = formcode_url;                             
                            }
                        });
                    }
                });
            }
          , errorElement: "em"
          , rules: {
                theme_name: { required: true }    
            }
        });
          /*
            $(element).bind('click', function(e) {
                $(element.parents('form')).ajaxSubmit();
                e.preventDefault();
            })
        }
        */
    }    
})
/*
window.onbeforeunload = function() {
    return "Are you sure you want to navigate away from this page?";
};
*/
