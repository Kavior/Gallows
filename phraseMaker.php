<?php
	$file = file_get_contents('phrases.txt');
	$line = explode(PHP_EOL, $file);
	$wordsArray = array();

	foreach($line as $txt){	
		$wordsArray[] = $txt;
	}

?>