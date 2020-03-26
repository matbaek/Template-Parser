<?php

/*
 * Template class
 * Takes a HTML template in, as a txt file, and takes an array.
 * Returns the replaced HTML Template with data.
 * 
 * @author     Mathias Bærentsen
 *
 */

class Template {
    
    private $html_template;
    private $data = [];
    private $errors = [];

    // When the object is created, there is gonna be passed a string with the HTML template
    public function __construct($html_template) {
        $this->html_template = $html_template;
    }

    // Set the array, that are passed into the function, to the $data array
    public function set_data_from_array($array) {
        if(is_array($array) == 1) {
            $this->data = $array;
        } 
    }

    // Gets a placeholder_key and a value that are added to the $data array
    public function set_data_manual($placeholder_key, $value) {
        $this->data[$placeholder_key] = $value;
    }

    /* 
     * First the function is looking to see if the $html_template is not empty, or it will add an error message.
     * After that the function is looking to see if the $data is not empty, or it will add an error message.
     * if $data is not empty, it will go through to see if the placeholder is present in the HTML template.
     * if it is, it will replace the placeholder with the data, if it is not, it will add an error message.
     * 
     * Then it will check if there is any errors. If there is, it will return them and not the HTML Template. 
     * if there is no error, it will return the HTML template with the data.
     */
    public function get_template_output() {
        $output = $this->html_template;
        if(empty($output)) {
            $this->errors[] =  "The HTML Template is empty.";
        }

        if(!empty($this->data)) {
            foreach($this->data as $placeholder_key => $value) {
                if(strpos($output, $placeholder_key) !== false) {
                    $placeholder = "{{". $placeholder_key ."}}";
                    $output = str_replace($placeholder, $value, $output);
                } else {
                    $this->errors[] =  $placeholder_key ." was not a placeholder in the HTML Template.";
                }
            }
        } else {
            $this->errors[] =  "The data is empty.";
        }

        if(!empty($this->errors)) {
            $output = "<ul>";
            foreach($this->errors as $error) {
                $output .= "<li>" . $error . "</li>";
            }
            $output .= "</ul>";
        }
        return $output;
    }
}

?>