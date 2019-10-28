<?php
	$email = 'eman@gm.com';
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo 0;
	}else{
		echo 1;
	}
?>