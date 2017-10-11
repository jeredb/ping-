<?php

	# Leave blank to use server name 
	$server = '';       
	# Just the folder name, no slashes, unless is buried deep 
	$folder = 'ping';  
	# Is your server hosted with HTTPS?
	$secure = false;
	# For the author of the RSS feed 
	$your_name = 'Jeredb';
	
	if ($server == '') {
	  $server = $_SERVER['SERVER_NAME'];
	}
	
	if ($secure == true) {
	  $address = 'https://' . $server . '/' . $folder . '/';
	} else {
	  $address = 'http://' . $server . '/' . $folder . '/';
	}
	
?>
	