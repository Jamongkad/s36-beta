<?php namespace Widget\Services\Formbuilder;

class FormbuilderValidation {

    private $validation = Array();
    private $input;

    public function __construct($input) {
        $this->input = $input;   
    }

    public function validate() { 
        foreach($this->input as $controls) {         
            if($controls['cssClass'] != 'input_text') { 
                if(!$controls['title']) {
                    $this->validation[] = $controls['groupId'];
                }

                if($controls['values']) {  
                    foreach($controls['values'] as $elements) {
                        if(!$elements['value']) {
                            $this->validation[] = $elements['id'];
                        }
                    }
                }
            } else {
                if(!$controls['values']) {
                    $this->validation[] = $controls['groupId'];     
                } 
            }
        }
    }

    public function get_validation_array() {
        return $this->validation;     
    }
}
