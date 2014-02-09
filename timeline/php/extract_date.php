<?php
	$page_name='Grigori_Rasputin';
	$page_name='Indian_independence_movement';
	$page_name='Mughal_Empire';
	$url = 'http://en.wikipedia.org/w/api.php?action=parse&page='.$page_name.'&format=json&prop=text';
	$ch = curl_init($url);
	$time_log='';
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_USERAGENT, "TestScript"); // required by wikipedia.org server; use YOUR user agent with YOUR contact information. (otherwise your IP might get blocked)
	$c = curl_exec($ch);

	$json = json_decode($c);
	//var_dump($json);
	//print_r($json);

	$content = $json->{'parse'}->{'text'}->{'*'}; // get the main text content of the query (it's parsed HTML)
	$ref_position=strpos($content,'<span class="mw-headline" id="References">References</span>');
	$content=substr($content,0,$ref_position);
	//var_dump($ref_position);
	
	$content=strip_tags($content);
	$string = ".".str_replace(".", "..", rtrim($content, '.')).".";
	
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
                        # or... (you get the idea).
    )                   # End negative lookbehind.
	((10|11|12|13|14|15|16|17|18|19|20)\d{2})
    \s+                 # Split on whitespace between sentences.
    /ix';
	
	
	$text = 'This is sentence one. Sentence two! Sentence thr'.
        'ee? Sentence "four". 1920 Sentence "five"! Sentence "'.
        'six"? Sentence "seven." Sentence \'eight!\' Dr. '.
        'Jones said: 1942 "Mrs. Smith you have a lovely daught'.
        'er!" The T.V.A. is a big project!';

	$sentences = preg_split($re, $text, -1, PREG_SPLIT_NO_EMPTY);
	for ($i = 0; $i < count($sentences); ++$i) {
		printf("Sentence[%d] = [%s]\n", $i + 1, $sentences[$i]);
	}


	/*preg_match_all("~\.[^.]*?((10|11|12|13|14|15|16|17|18|19|20)\d{2})[^.]*?\.~", $string, $sentenceWithYear);
	
	$sentence_arr=$sentenceWithYear[0];
	$year_arr=$sentenceWithYear[1];
	$arr='';
	foreach($sentence_arr as $key=>$value){
					$s_value=strip_tags($value);
					$s_value = preg_replace('/(<[^>]+) class=".*?"/i', '$1', $s_value);
					$s_value = preg_replace('/class=".*?">/i', '$1', $s_value);
					$y_value=$year_arr[$key];
					if(isset($arr[$y_value])){
						$arr[$y_value].='<br>'.$s_value;
					}
					else{
						$arr[$y_value]=$s_value;
					}
	}
	
	krsort($arr, SORT_NUMERIC);
	foreach($arr as $key=>$value){
		$time_log.='<div class="timelineMajor">';
		$time_log.='<h2 class="timelineMajorMarker"><span>'.$key.'</span></h2>';
		$time_log.=$value;
		$time_log.='</div>';
	
	}
	*/
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
			<div class="timelineMajor">
				<h2 class="timelineMajorMarker"><span>1954</span></h2>
				<dl class="timelineMinor">
					<dt id="19540517"><a>Brown v. Board of Education</a></dt>
					<dd class="timelineEvent" id="19540517EX" style="display:none;">
						<h3>May 17, 1954</h3>
						<p>
							The U.S. Supreme Court hands down a unanimous 9-0 decision in the Brown v. Board of Education of Topeka case, opening the door for the civil rights movement and ultimately racial integration in all aspects of U.S. society. In overturning Plessy v. Ferguson (1896), the court rules that “separate educational facilities are inherently unequal.”<sup>1</sup></p>

							<br class="clear">
					</dd><!-- /.timelineEvent -->
				</dl><!-- /.timelineMinor -->
			</div><!-- /.timelineMajor -->

			<div class="timelineMajor">
				<h2 class="timelineMajorMarker"><span>1955</span></h2>
				<dl class="timelineMinor">
					<dt id="19550828"><a>Emmett Till</a></dt>
					<dd class="timelineEvent" id="19550828EX" style="display:none;">
						<h3>August 28, 1955</h3>

						<div class="media">
							<a href="#inline-1955-08-282" class="CBmodal"><img src="http://img.youtube.com/vi/GU1wuqyOP98/0.jpg" width="240" height="180" alt="Related Video: The Emmett Till Murder"></a>
							<p class="mediaLink"><a href="#inline-1955-08-282" class="CBmodal" title="Related Video: The Emmett Till Murder">Watch: The Emmett Till Murder</a></p>
							<div style="display:none">
								<div id="inline-1955-08-282" class="modalBox">
									<object>
										<param name="movie" value="http://www.youtube.com/v/GU1wuqyOP98?fs=1&amp;hd=0&amp;showsearch=0&amp;showinfo=0&amp;width=640&amp;height=380">
										<param name="allowFullScreen" value="true">
										<param name="allowScriptAccess" value="always">
										<embed src="http://www.youtube.com/v/GU1wuqyOP98?fs=1&amp;hd=0&amp;showsearch=0&amp;showinfo=0&amp;width=640&amp;height=380" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="640" height="380">
										</object>
									</div>
								</div>
						</div><!-- /.media -->

						<p>
							Fourteen-year-old African-American Emmett Till is brutally murdered after reportedly flirting with a white woman while visiting relatives in Mississippi. For the first time, both black and white reporters cover the trial epitomizing “one of the most shocking and enduring stories of the twentieth century.”<sup>2</sup> The white defendants, Roy Bryant and J.W. Milam, are acquitted by an all-white jury in only 67 minutes; later they describe in full detail to Look magazine (which paid them $4,000) how they killed Till.<sup>3</sup> His mother insists on an open casket funeral, and the powerful image of his mutilated body sparks a strong reaction across the country and the world.</p>

						<br class="clear">
					</dd><!-- /.timelineEvent -->
				</dl><!-- /.timelineMinor -->


				<dl class="timelineMinor">
					<dt id="19551201"><a>Rosa Parks</a></dt>
					<dd class="timelineEvent" id="19551201EX" style="display:none;">
						<h3>December 1, 1955</h3>
						<p>
							The arrest of Rosa Parks, a 42-year-old African-American seamstress and civil rights activist who refused to give up her bus seat to a white passenger, sets off a long anticipated bus boycott by residents of Montgomery, Ala. The 13-month protest and ensuing litigation eventually make it to the U.S. Supreme Court, which declares that segregation on public buses is unconstitutional.<sup>4</sup> The Montgomery bus boycott brings the Rev. Dr. Martin Luther King Jr. and his nonviolent approach to social change to the forefront of the civil rights movement.</p>

							<br class="clear">
					</dd><!-- /.timelineEvent -->
				</dl><!-- /.timelineMinor -->
			</div><!-- /.timelineMajor -->

			<div class="timelineMajor">
				<h2 class="timelineMajorMarker"><span>1957</span></h2>
				<dl class="timelineMinor">
					<dt id="19570904"><a>Little Rock</a></dt>
					<dd class="timelineEvent" id="19570904EX" style="display:none;">
						<h3>September 4, 1957</h3>

						<div class="media">
							<a href="#inline-1957-09-044" class="CBmodal"><img src="http://img.youtube.com/vi/h148GEIgUeA/0.jpg" width="240" height="180" alt="Related Video: Reporting Little Rock"></a>
							<p class="mediaLink"><a href="#inline-1957-09-044" class="CBmodal" title="Related Video: Reporting Little Rock">Watch: Reporting Little Rock</a></p>
							<div style="display:none">
								<div id="inline-1957-09-044" class="modalBox">
									<object>
										<param name="movie" value="http://www.youtube.com/v/h148GEIgUeA?fs=1&amp;hd=0&amp;showsearch=0&amp;showinfo=0&amp;width=640&amp;height=380">
										<param name="allowFullScreen" value="true">
										<param name="allowScriptAccess" value="always">
										<embed src="http://www.youtube.com/v/h148GEIgUeA?fs=1&amp;hd=0&amp;showsearch=0&amp;showinfo=0&amp;width=640&amp;height=380" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="640" height="380">
										</object>
									</div>
								</div>
						</div><!-- /.media -->

						<p>
							Three years removed from the Brown v. Board of Education decision, Arkansas Gov. Orval Faubus orders the National Guard to stop nine black students from attending the all-white Little Rock Central High School. President Dwight D. Eisenhower intervenes by federalizing the National Guard and deploying Army troops to protect the students, stripping the state of power. Media coverage of the physical and verbal harassment the black students were subjected to is reported and broadcast around the world. In the end, they successfully integrate Central High. <sup>5</sup></p>

						<br class="clear">
					</dd><!-- /.timelineEvent -->
				</dl><!-- /.timelineMinor -->
			</div><!-- /.timelineMajor -->

			<div class="timelineMajor">
				<h2 class="timelineMajorMarker"><span>1961</span></h2>
				<dl class="timelineMinor">
					<dt id="19610504"><a>Freedom Rides</a></dt>
					<dd class="timelineEvent" id="19610504EX" style="display:none;">
						<h3>May 4, 1961</h3>

						<div class="media">
							<a href="#inline-1961-05-045" class="CBmodal"><img src="http://img.youtube.com/vi/Sxe9dJoZ-AQ/0.jpg" width="240" height="180" alt="Related Video: Freedom Rides"></a>
							<p class="mediaLink"><a href="#inline-1961-05-045" class="CBmodal" title="Related Video: Freedom Rides">Watch: Freedom Rides</a></p>
							<div style="display:none">
								<div id="inline-1961-05-045" class="modalBox">
									<object>
										<param name="movie" value="http://www.youtube.com/v/Sxe9dJoZ-AQ?fs=1&amp;hd=0&amp;showsearch=0&amp;showinfo=0&amp;width=640&amp;height=380">
										<param name="allowFullScreen" value="true">
										<param name="allowScriptAccess" value="always">
										<embed src="http://www.youtube.com/v/Sxe9dJoZ-AQ?fs=1&amp;hd=0&amp;showsearch=0&amp;showinfo=0&amp;width=640&amp;height=380" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="640" height="380">
										</object>
									</div>
								</div>
						</div><!-- /.media -->

					<p>
						The first of many civil rights “Freedom Rides” leaves Washington, D.C., for New Orleans. The Freedom Riders want to test the validity of the Supreme Court’s decision to outlaw racial segregation in bus terminals and through interstate bus travel.<sup>6</sup> Angry white mobs – with the blessing of Alabama law enforcement – meet the convoy in Anniston and Birmingham, brutally beating the Freedom Riders and firebombing one of the buses.<sup>7</sup></p>
						<br class="clear">
					</dd><!-- /.timelineEvent -->
				</dl><!-- /.timelineMinor -->
			</div><!-- /.timelineMajor -->

			<div class="timelineMajor">
				<h2 class="timelineMajorMarker"><span>1963</span></h2>
				<dl class="timelineMinor">
					<dt id="19630828"><a>"I Have a Dream"</a></dt>
					<dd class="timelineEvent" id="19630828EX" style="display:none;">
						<h3>August 28, 1963</h3>
						<div class="media">
							<a href="#inline-1963-08-287" class="CBmodal"><img src="http://img.youtube.com/vi/gvAQE66jwcg/0.jpg" width="240" height="180" alt="Related Video: Black Press"></a>
							<p class="mediaLink"><a href="#inline-1963-08-287" class="CBmodal" title="Related Video: Black Press">Watch: Black Press</a></p>
							<div style="display:none">
								<div id="inline-1963-08-287" class="modalBox">
									<object>
										<param name="movie" value="http://www.youtube.com/v/gvAQE66jwcg?fs=1&amp;hd=0&amp;showsearch=0&amp;showinfo=0&amp;width=640&amp;height=380">
										<param name="allowFullScreen" value="true">
										<param name="allowScriptAccess" value="always">
										<embed src="http://www.youtube.com/v/gvAQE66jwcg?fs=1&amp;hd=0&amp;showsearch=0&amp;showinfo=0&amp;width=640&amp;height=380" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="640" height="380">
										</object>
									</div>
								</div>
						</div><!-- /.media -->

						<p>
							In one of the largest gatherings in the nation’s capital and one of the first to be broadcast live on national television, at least 200,000 civil rights protesters stage a March on Washington concluding at the Lincoln Memorial. The march is dedicated to jobs and freedom and takes place 100 years after the&nbsp;Emancipation Proclamation. The highlight of the event is Martin Luther King Jr.’s historic “I Have a Dream” speech.</p>

						<blockquote>
							I have a dream that one day this nation will rise up and live out the true meaning of its creed: "We hold these truths to be self-evident: that all men are created equal."
							<div class="attribution">&mdash;Martin Luthar King Jr.</div>
						</blockquote>

						<br class="clear">
					</dd><!-- /.timelineEvent -->
				</dl><!-- /.timelineMinor -->

			</div><!-- /.timelineMajor -->

			<div class="timelineMajor">
				<h2 class="timelineMajorMarker"><span>1964</span></h2>

				<dl class="timelineMinor">
					<dt id="19640702"><a>Civil Rights Act</a></dt>
					<dd class="timelineEvent" id="19640702EX" style="display:none;">
						<h3>July 2, 1964</h3>
						<p>
							President Lyndon B. Johnson signs the Civil Rights Act of 1964, mandating equal opportunity employment, and complete desegregation of schools and other public facilities. It also outlaws unequal voter registration requirements.<sup>13</sup> Although it would take years for these changes to take effect in communities around the country, the law is a monumental victory for the civil rights movement.</p>

							<br class="clear">
					</dd><!-- /.timelineEvent -->
				</dl><!-- /.timelineMinor -->

				<dl class="timelineMinor">
					<dt id="19641014"><a>Nobel Peace Prize</a></dt>
					<dd class="timelineEvent" id="19641014EX" style="display:none;">
						<h3>October 14, 1964</h3>
						<p>Martin Luther King Jr. is awarded the Nobel Peace Prize; at 35, he is the youngest recipient.</p>
						<br class="clear">
					</dd><!-- /.timelineEvent -->
				</dl><!-- /.timelineMinor -->

			</div><!-- /.timelineMajor -->
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
