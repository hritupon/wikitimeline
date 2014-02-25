<?php
	$content="I am a boy.[2] Although I am good.[33] I dont.";
	$result=preg_replace("/\\[\d*\\]/", "", $content);
	echo $result;

?>