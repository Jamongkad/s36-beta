angular.module('formbuilder', [])
.directive('myFormbuilder', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) { 
            $(element).formbuilder({
              , 'useJson': true
              , messages: { 
                    save				: "Save",
                    add_new_field		: "Add New Field...",
                    text				: "Text Field",
                    title				: "Title",
                    paragraph			: "Paragraph",
                    checkboxes			: "Checkboxes",
                    radio				: "Radio",
                    select				: "Select List",
                    text_field			: "Text Field",
                    label				: "Label",
                    paragraph_field		: "Paragraph Field",
                    select_options		: "Select Options",
                    add					: "Add",
                    checkbox_group		: "Checkbox Group",
                    remove_message		: "Are you sure you want to remove this element?",
                    remove				: "Remove",
                    radio_group			: "Radio Group",
                    selections_message	: "Allow Multiple Selections",
                    hide				: "Hide",
                    required			: "Required",
                    show				: "Show"
                }
            });

            $(element).children('ul').sortable({ opacity: 0.6, cursor: 'move'});
        }
    }    
})
