<?php

	$notify = array();
	$notify[15] = array(
		"client" => array(
			"name" => "gholi 1"
		)
	);
	$notify[1578] = array(
		"client" => array(
			"name" => "gholi 2"
		)
	);
	$notify[2] = array(
		"client" => array(
			"name" => "gholi 3"
		)
	);

	// var_dump($notify);	

	$notifyKeys = array_keys($notify);
	for($i=0; $i<count($notifyKeys); $i++){
		$key = $notifyKeys[$i];
		foreach($notify[$key] as $notifyKey => $notifyVal){
			if($notifyKey == 'client'){
				$name = $notify[$key][$notifyKey]['name'];
				echo $name . "<br />";
			}
		}
	}


?>