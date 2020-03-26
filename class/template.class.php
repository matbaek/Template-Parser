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

    private $placeholder_start = "{{";
    private $placeholder_end = "}}";

    /*
     * When the object is created, there is gonna be passed a string with the HTML template.
     * If the passed in variable is not empty, it will save it.
     * If the passed in variable is empty, it will add an error message.
     */
    public function __construct($html_template) {
        if(!empty($html_template)) {
            $this->html_template = $html_template;
        } else {
            $this->errors[] =  "The HTML Template is empty.";
        }
    }

    /* 
     * The function is checking if the passed in variable is an array. 
     * If the passed in variable is an array, it will save it.
     * If the passed in variable is not an array, it will add an error message.
     */
    public function set_data_from_array($array) {
        if(is_array($array) == 1) {
            $this->data = $array;
        } else {
            $this->errors[] = "Data is not an array.";
        }
    }

    /* 
     * The function is calling three functions, replace placeholder with data, find missing placeholder
     * and displaying errors that could have come.
     * It will then return the $html_template.
     */
    public function get_template_output() {
        if(empty($this->errors)) {
            $this->replace_placeholder_with_data();
            $this->find_missing_placeholder();
        }
        $this->display_errors();

        return $this->html_template;
    }

    /*
     * The function is looking to see if the $data is not empty, or it will add an error message.
     * If $data is not empty, it will go through to see if the placeholder is present in the HTML template.
     * If it is, it will replace the placeholder with the data, if it is not, it will add an error message.
     */
    private function replace_placeholder_with_data() {
        if(!empty($this->data)) {
            foreach($this->data as $placeholder_key => $value) {
                if(strpos($this->html_template, $placeholder_key) !== false) {
                    $placeholder = $this->placeholder_start . $placeholder_key . $this->placeholder_end;
                    $this->html_template = str_replace($placeholder, $value, $this->html_template);
                } else {
                    $this->errors[] = "Placeholder not in HTML template: <b>". $placeholder_key ."</b>.";
                }
            }
        } else {
            $this->errors[] =  "The data is empty.";
        }
    }

    /*
     * The function will be checking the $html_template if there is some placeholders left, 
     * that haven't been replaced with data.
     * If there is some placeholder left, there will be made a error message. 
     */
    private function find_missing_placeholder() {
        $count_missing_placeholder = substr_count($this->html_template, $this->placeholder_start);
        $start_position = 0;
        while($count_missing_placeholder != 0) {
            $start_position = strpos($this->html_template, $this->placeholder_start, $start_position);
            $start_position += strlen($this->placeholder_start);

            $word_length = strpos($this->html_template, $this->placeholder_end, $start_position) - $start_position;
            $this->errors[] = "Missing data for placeholder: <b>". substr($this->html_template, $start_position, $word_length) ."</b>.";

            $count_missing_placeholder--;
        }
    }

    /*
     * The function will check if there is any errors. If there is, it will return them and override the HTML template. 
     * If there is no error, it will not override the HTML template.
     */
    private function display_errors() {
        if(!empty($this->errors)) {
            $this->html_template = "<ul>";
            foreach($this->errors as $error) {
                $this->html_template .= "<li>" . $error . "</li>";
            }
            $this->html_template .= "</ul>";
        }
    }
}

?>