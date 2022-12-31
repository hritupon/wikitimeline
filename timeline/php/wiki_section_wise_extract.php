<?php
	include_once 'fetch_url.php';
	ini_set('max_execution_time', 300); //300 seconds = 5 minutes
	$time_log='';
	$page_name='Grigori_Rasputin';
	$page_name='Jawaharlal_Nehru';
	
	if(isset($_GET['wiki_name'])){
		$page_name=$_GET['wiki_name'];
	}
	
	//$page_name='Indian_independence_movement';
	//$page_name='Mughal_Empire';
	//$page_name='Ahom_kingdom';
	$summary=fetch_wiki_data($page_name);
	$title='';
	$url ='https://en.wikipedia.org/w/api.php?format=json&action=parse&page='.$page_name.'&prop=sections';
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
	
	$json = json_decode($c,true);
	//var_dump($json);
	$data=$json['parse'];
	$title=$data['title'];
	$sections=$data['sections'];
	foreach( $sections as $key=>$value){
		$section=$value;
		//var_dump($section);
		$index=$section['index'];
		$line_title=$section['line'];
		//var_dump($line_title);
		if(($line_title=='External links') 
		|| ($line_title=='Further reading') 
		|| ($line_title=='Bibliography')
		||($line_title=='Biographies')
		||($line_title=='References')
		||($line_title=='See also')
		|| ($line_title=='Citations')
		|| ($line_title=='Notes')
		|| ($line_title=='Historiography')  
		|| ($line_title=='Primary sources')  
		|| ($line_title=='Specialty studies')  
		|| ($line_title=='Biographical studies')  
		|| ($line_title=='Ancestry')  
		|| ($line_title=='Bibliography and online texts') 
		|| ($line_title=='Articles and entries') 
		|| ($line_title=='Footnotes') 
		){
			continue;
		}
		
		if(startsWith($line_title, "Commentaries on")){
			continue;
		}
		
		$section_url='https://en.wikipedia.org/w/api.php?format=json&action=parse&page='.$page_name.'&prop=text&section='.$index;
		$ch_sections = curl_init($section_url);
		
		curl_setopt ($ch_sections, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch_sections, CURLOPT_USERAGENT, "TestScript"); // required by wikipedia.org server; use YOUR user agent with YOUR contact information. (otherwise your IP might get blocked)
		$c_sections = curl_exec($ch_sections);
		$section_json = json_decode($c_sections,true);
		
		
		$parse_section=$section_json['parse'];
		$pre_text=$parse_section['text'];
		$sections_text=$pre_text['*'];
		//var_dump($sections_text);
		$content=$sections_text;
		
		
		$content=strip_tags($content,'<img>');
		//$text = ".".str_replace(".", "..", rtrim($content, '.')).".";
		$content=preg_replace("/\\[\d*\\]/", "", $content);
		$content=preg_replace("/\\[edit\]/i", "", $content);

		$text=$content;
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
			//preg_match_all('/\d\d\d\d?/i', $string, $sentenceWithYear);
			preg_match_all('/ (?<! \d)(?!0000)\d{4}(?!\d)/i', $string, $sentenceWithYear);
			//preg_match_all("(10|11|12|13|14|15|16|17|18|19|20)\d{2}", $string, $sentenceWithYear);
			if(isset($sentenceWithYear[0][0])){
				
				$year=$sentenceWithYear[0][0];
				if(($start_date<=$year)&&( $year<= $end_date)){
					$arr[$year]=$string;
				}
			}
		}
		
		
	}
	krsort($arr, SORT_NUMERIC);
	$count=0;
	foreach($arr as $key=>$value){
		$time_log.='<div class="timelineMajor">';
		$time_log.='<h2 class="timelineMajorMarker"><span>'.$key.'</span></h2>';
		$time_log.='<dl class="timelineMinor">';
		$time_log.='<dt id="'.$count.'"><a>'.''.'</a></dt>';
		$time_log.='<dd class="timelineEvent" id="'.$count.'EX" style="display:none;">';
		$time_log.=$value;
		$time_log.='</dd>';
		$time_log.='</dl>';
		$time_log.='</div>';
		$count++;
	}
?>
<?php 
function startsWith($haystack, $needle)
{
    return $needle === "" || strpos($haystack, $needle) === 0;
}
function endsWith($haystack, $needle)
{
    return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
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
		
		<h1><?php echo $title ?></h1>
		<p><?php echo $summary ?></p>
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
