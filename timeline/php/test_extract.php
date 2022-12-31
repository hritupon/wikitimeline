<?php
	$page_name='Grigori_Rasputin';
	$page_name='Jawaharlal_Nehru';
	//$page_name='Indian_independence_movement';
	//$page_name='Mughal_Empire';
	//$page_name='Ahom_kingdom';
	$url = 'https://en.wikipedia.org/w/api.php?action=parse&page='.$page_name.'&format=json&prop=text';
	$ch = curl_init($url);
	$time_log='';
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_USERAGENT, "TestScript"); // required by wikipedia.org server; use YOUR user agent with YOUR contact information. (otherwise your IP might get blocked)
	$c = curl_exec($ch);
	$start_date='0';
	$end_date='2014';
	if(isset($_GET['start'])){
		$start_date=$_GET['start'];
	}
	if(isset($_GET['end'])){
		$end_date=$_GET['end'];
	}
	$json = json_decode($c);
	//var_dump($json);
	//print_r($json);

	$content = $json->{'parse'}->{'text'}->{'*'}; // get the main text content of the query (it's parsed HTML)
	$ref_position=strpos($content,'<span class="mw-headline" id="References">References</span>');
	$content=substr($content,0,$ref_position);
	//var_dump($ref_position);
	
	$content=strip_tags($content);
	$text = ".".str_replace(".", "..", rtrim($content, '.')).".";
	
	$re = '/# Split sentences on whitespace between them.
    (?<=                # Begin positive lookbehind.
      [.!?]             # Either an end of sentence punct,
    | [.!?][\'"]        # or end of sentence punct and quote.
    )                   # End positive lookbehind.
    (?<!                # Begin negative lookbehind.
      Mr\.              # Skip either "Mr."
    | Mrs\.             # or "Mrs.",
    | Ms\.              # or "Ms.",
    | Jr\.              # or "Jr.",
    | Dr\.              # or "Dr.",
    | Prof\.            # or "Prof.",
    | Sr\.              # or "Sr.",
    | T\.V\.A\.         # or "T.V.A.",
    | O\.S\.         # or "T.V.A.",
                        # or... (you get the idea).
    )                   # End negative lookbehind.
	\s+                 # Split on whitespace between sentences.
    /ix';
	
	$sentences = preg_split($re, $text, -1, PREG_SPLIT_NO_EMPTY);
	for ($i = 0; $i < count($sentences); ++$i) {
		$string=$sentences[$i];
		//preg_match_all('/\d\d(?:\d\d)?/i', $string, $sentenceWithYear);
		preg_match_all('/\d\d\d\d?/i', $string, $sentenceWithYear);
		//preg_match_all("(10|11|12|13|14|15|16|17|18|19|20)\d{2}", $string, $sentenceWithYear);
		if(isset($sentenceWithYear[0][0])){
			
			$year=$sentenceWithYear[0][0];
			if(($start_date<=$year)&&( $year<= $end_date)){
				$arr[$year]=$string;
			}
		}
	}
	krsort($arr, SORT_NUMERIC);
	foreach($arr as $key=>$value){
		$time_log.='<div class="timelineMajor">';
		$time_log.='<h2 class="timelineMajorMarker"><span>'.$key.'</span></h2>';
		$time_log.=$value;
		$time_log.='</div>';
	
	}
?>



<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title><?php echo $page_name ?></title>
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
		
		<h1><?php echo $page_name ?></h1>

		<!--p>< ?php echo $summary ?></p-->
		<p><h3>TimeLine</h3></p>
		

		<div id="timelineContainer" class="timelineContainer">

			<div class="timelineToggle"><p><a class="addNew" href="http://localhost/timeline/index.php?page=<?php echo $page_name;?>">+ add new</a></p></div>
			<div class="timelineToggle"><p><a class="expandAll">+ expand all</a></p></div>

			<br class="clear">
			<?php echo $time_log ?>
		
			

				
		<br class="clear">
		</div><!-- /#timelineContainer -->

		<br>
		<br>
		<h2>The Development of WikitimelinE</h2>
		<p>Representing facts in chronological order,as they occured. Please take part and contribute.</p>

		<div id="timelineContainer_2" class="timelineContainer">

			<div class="timelineToggle"><p><a class="expandAll">+ expand all</a></p></div>

			<br class="clear">

			<div class="timelineMajor">
				<h2 class="timelineMajorMarker"><span>Concept</span></h2>
				<dl class="timelineMinor">
					<dt id="born"><a>The idea is born</a></dt>
					<dd class="timelineEvent" id="bornEX" style="display:none;">
						<p>Two completely independent projects, one for the Institute for Educational Leadership and another for the Fund for Investigative Journalism, expressed interest in a timeline component for their website.</p>
						<br class="clear">
					</dd><!-- /.timelineEvent -->
				</dl><!-- /.timelineMinor -->
			</div><!-- /.timelineMajor -->

			<br class="clear">
		</div>

	</div><!-- /.container -->
<!-- /.container -->

	<!-- GLOBAL CORE SCRIPTS -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
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

</body>
</html>
