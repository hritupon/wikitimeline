<?php 
	$topic_name='Event title';
	if(isset($_GET['page'])){
		$topic_name=$_GET['page'];
	}
?>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TimeLine</title>
	<link rel="icon" type="image/ico" href="images/favicon.ico" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/datepicker.css">
	
	<script src="js/bootstrap.js"></script>
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/bootstrap-dropdown.js"></script>
    <script type="text/javascript">
            $(document).ready(function () {
                
                $('.input-daterange').datepicker({
                    todayBtn: "linked"
                });
            
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
      <!--a class="navbar-brand" href="#"><img src="images/hourglass.png" style="margin-top:-20px;"></a-->
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



<div class="container">
<table width="100%">
<tr>
<td width="100%">
<form class="form-horizontal" action="form_submit.php" method="post">
<fieldset>

<!-- Form Name -->
<legend>Add Timeline</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="Event_Title">Event Title</label>  
  <div class="col-md-4">
  <input id="Event_Title" name="Event_Title" type="text" placeholder="<?php echo $topic_name ?>" class="form-control input-md" required="">
  <span class="help-block">Please provide a short event title</span>  
  </div>
</div>


<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="Date">Event Time</label>  
  <!--div class="col-md-4">
  <input id="Date" name="Date" type="text" placeholder="Time of the event" class="form-control input-md" required="">
  
  </div-->
  <div class="col-md-8 input-daterange" id="datepicker" >
        <input type="text" class="input-small" name="start" id="Start_Date"/>
        <span class="add-on" style="vertical-align: top;height:25px">to</span>
        <input type="text" class="input-small" name="end" id="End_Date"/>
	 <span class="help-block">Time when the event happend</span> 				
  </div>
  
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="Event_Desc">Event Description</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="Event_Desc" name="Event_Desc">Event Description</textarea>
  </div>
</div>


<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="Link">External Link</label>  
  <div class="col-md-4">
  <input id="Link" name="Link" type="text" placeholder="Please provide a valid link validating the event" class="form-control input-md" required="">
  <span class="help-block">External Link</span>  
  </div>
</div>

<!-- Button (Double) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="Add_Event"></label>
  <div class="col-md-8">
    <button id="Add_Event" name="Add_Event" class="btn btn-success">Add Event</button>
    <button id="Cancel" name="Cancel" class="btn btn-danger">Cancel</button>
  </div>
</div>

</fieldset>
</form>
</td>
</tr>
</table>

</div>
</body>
</html>