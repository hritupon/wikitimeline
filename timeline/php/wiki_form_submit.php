<?php
	include_once 'fetch_url.php';
	$page_name='';
	if(isset($_POST['Event_Title'])){
		$event_title=$_POST['Event_Title'];
		$page_name=$event_title;
		$links=search_wiki_data_here($event_title);
	}
	else{
		header("Location: index.php");
		exit();
	}
	
	
	
function search_wiki_data_here($page_name){
	$wikisearch = "http://en.wikipedia.org/w/api.php?action=opensearch&search=".urlencode($page_name);
	$wikisearchlist = file_get_contents($wikisearch);
	$search_res='Link this event to --<br>';
	$json = json_decode($wikisearchlist);
	if(isset($json[1])){
		$possib_arr=$json[1];
		$count=0;
		foreach($possib_arr as $key=>$val){
			/*if($count==0){
				$count++;
				continue;
			}
			*/
			$search_term='<a href="wiki_section_wise_extract.php?page_name='.$page_name.'&wiki_name='.replace_space_with_($val).'">'.$val.'</a><br>';
			$count++;
			$search_res.=$count.'.&nbsp;'.$search_term;
			
		}
	}
	
	return $search_res;
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title><?php echo $title ?></title>
	<link rel="icon" type="image/ico" href="images/favicon.ico" />
	<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen">
	<link rel="stylesheet" href="css/responsive.css" type="text/css" media="screen">
	<link rel="stylesheet" href="inc/colorbox.css" type="text/css" media="screen">
   	<link rel="stylesheet" href="css/bootstrap.min.css">


	
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/bootstrap-dropdown.js"></script>
	<script type="text/javascript" src="inc/colorbox.js"></script>
	<script type="text/javascript" src="js/timeliner.min.js"></script>
	<script>
		$(document).ready(function() {
			$.timeliner({
				startOpen:['#19550828EX', '#19630828EX']
			});
			$.timeliner({
				timelineContainer: '#timelineContainer_2',
				startState: 'closed',
			});
			// Colorbox Modal
			$(".CBmodal").colorbox({inline:true, initialWidth:100, maxWidth:682, initialHeight:100, transition:"elastic",speed:750});
		});
	</script>
</head>
<body>
	<nav class="navbar navbar-default" role="navigation">
	<!--nav class="navbar navbar-inverse" role="navigation"-->
	  <div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
		  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
		  <!--a class="navbar-brand" href="#"><img src="images/hourglass.png" style="margin-top:-20px;">wikiTimeLine</a-->
		  <a class="navbar-brand" href="#"><img src="images/hourglass.png" style="margin-top:-20px;"><img src="images/wikitimeline.png" style="margin-top:-20px;"></a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		  <form class="navbar-form navbar-left" role="search" action="search.php" method="post">
			<div class="form-group">
			  <!--input type="text" class="form-control input-md" placeholder="Search"-->
			  <input type="text" class="form-control search-query" placeholder="Search" name="q">
			</div>
			<button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
		  </form>
		  <ul class="nav navbar-nav navbar-right">
			<li><a href="#">Log In</a></li>
			<li><a href="http://localhost/timeline/index.php">Create</a></li>
			<li class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Actions <b class="caret"></b></a>
			  <ul class="dropdown-menu">
				<li><a href="#">Create TimeLine</a></li>
				<li><a href="#">Edit TimeLine</a></li>
				<li><a href="#">Today's Timeline</a></li>
				<li class="divider"></li>
				<li><a href="http://localhost/timeline/timeliner.html">Recently Added</a></li>
			  </ul>
			</li>
		  </ul>
		</div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>

	<div class="container" style="margin-top:-20px;">
			<h1><?php echo 'wiki search' ?></h1>
			<?php echo $links ?>
</div>
</body>
</html>