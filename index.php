<?php

/*
 * Index
 * Uses the functions from the Template class, to show the final product.
 * 
 * @author     Mathias Bærentsen
 *
 */

include("class/template.class.php");

$array = [
    "head_titel" => "My Page",
    "titel" => "My Titel"
];

$html_template = "";
if(file_exists("templates/example.txt")) {
    $html_template = file_get_contents("templates/example.txt");
}
$template = new Template($html_template);
$template->set_data_from_array($array);
$template->set_data_manual("text", "This is my text.");

echo $template->get_template_output();

?>