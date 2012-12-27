<?php

	$obj = curl_init();
	curl_setopt($obj, CURLOPT_URL, 'http://hefzi-pub.ir/');
	curl_setopt($obj, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($obj);
	curl_close($obj);

?>
<textarea>
	<?php echo $output; ?>
</textarea>