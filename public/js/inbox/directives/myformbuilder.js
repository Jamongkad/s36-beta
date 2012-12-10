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
.directive('myCreateform', function() {
    return {
        restrict: 'A'      
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {
                console.log("pwets");
                e.preventDefault();
            })
            /* 
            $(document).delegate("#create-form-widget", "submit", function(e) {
                var form_db_id;
                //save form builder alongside other submission form shit
                $(this).ajaxSubmit({
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
                            type: "POST",
                            url: "/feedsetup/buildmetadata_options",
                            data: $("ul[id^=frmb-]").serializeFormList({prepend: "frmb"}) + "&form_id=" + widget_store_id + "&company_id=" + company_id
                        });
                         
                        //window.location = formcode_url;
                    }
                });
                e.preventDefault();    
            });
            */
        }
    }    
})
