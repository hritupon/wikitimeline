<?php
include_once 'db_connection.php';
include_once 'fetch_url.php';

if(isset($_GET['page_name'])){ 
	$page_name=$_GET['page_name'];
	if(isset($_GET['wiki_name'])){ 
		$wiki_name=$_GET['wiki_name'];
		$summary=fetch_wiki_data($wiki_name);
		$summary=mysql_real_escape_string($summary);
		$sql="update topic set description='$summary' where LOWER(topic)='".strtolower($page_name)."'";  
		$result = mysqli_query($db_conx, $sql);
		
		$pic='';
		$image=wikipediaImageUrls($wiki_name);
		if(isset($image[0])){
			$pic='<img src="'.$image[0].'" width="200" height="200">';
		}
		$summary=fetch_wiki_data($wiki_name);
		$sql="update topic set image='$pic' where LOWER(topic)='".strtolower($page_name)."'";  
		$result = mysqli_query($db_conx, $sql);
		header("Location: fetch_data.php?page=".$page_name);
		exit(0);	
	}		

}
?>