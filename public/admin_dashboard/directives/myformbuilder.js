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
                              , dataType: 'json'       
                              , url: "/feedsetup/buildmetadata_options"
                              , data: $("ul[id^=frmb-]").serializeFormList({ prepend: "frmb" }) + "&form_id=" + widget_store_id + "&company_id=" + company_id
                              , success: function(msg) {
                                    if(msg.status == 'invalid' && msg.validation.length > 0) {
                                        for(var i=0; i<msg.validation.length; i++) {
                                            var elm = $("#" + msg.validation[i]);
                                            elm.css({'border': '2px solid red'});
                                        }
                                    } else {
                                        window.location = formcode_url;                             
                                        //console.log("All good to go");
                                    }                             
                                }
                            });

                        }
                    });
                }
              , errorElement: "em"
              , rules: {
                    theme_name: { 
                        required: true 
                      , minlength: 8
                      , maxlength: 50
                    }    
                  , submit_form_text: {
                        required: true   
                      , minlength: 8
                      , maxlength: 50
                    } 
                  , submit_form_question: { 
                        required: true   
                      , minlength: 8
                    }
                }
               , messages: {
                    theme_name: { 
                        required: "This is field is required"   
                      , minlength: "Must be atleast 8 characters."
                      , maxlength: "50 character length reached."
                    }
                  , submit_form_text: {
                        required: "This is field is required"   
                      , minlength: "Must be atleast 8 characters."
                      , maxlength: "50 character length reached."
                    }
                  , submit_form_question: { 
                        required: "This is field is required"   
                      , minlength: "Must be atleast 8 characters."
                    }
                }
            });
        }    
    }
})
/*
window.onbeforeunload = function() {
    return "Are you sure you want to navigate away from this page?";
};
*/
