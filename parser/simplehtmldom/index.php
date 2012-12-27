<?php
include('./simple_html_dom.php');

$html = file_get_html('http://hefzi-pub.ir/');

$content = array();

foreach($html->find('a') as $aTag){
	$content[] = json_encode(array(
		"group" => "a",
		"id" => ($aTag->id)?$aTag->id:''
	));
}

print_r($content);

?>