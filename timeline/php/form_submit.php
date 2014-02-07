<?php
	include_once 'db_connection.php';
	$message='';
	$path='';
	if(isset($_POST['Event_Title'])&&isset($_POST['start'])&&isset($_POST['Link'])){ 
		$Event_Title=$_POST['Event_Title'];
		$start_date=$_POST['start'];
		$start_date=date("Y-m-d",strtotime($start_date));
		$end_date=$_POST['end'];
		$end_date=date("Y-m-d",strtotime($end_date));
		
		
		
		
		
		$event_desc=$_POST['Event_Desc'];
		$link=$_POST['Link'];
	    $sql="insert into event(Event_ID,Event_Title, Event_Starttime,Event_Endtime,Description,Link) values('','$Event_Title','$start_date',".
		"'$end_date','$event_desc','$link')";  
		
		$res_id=mysqli_query($db_conx,$sql);
		$event_id=mysqli_insert_id($db_conx);
		if($res_id>0){
		
			$topic_name = str_replace(' ', '_', $Event_Title);
			
			$sql="SELECT * FROM topic where topic='$topic_name'";
			$result = mysqli_query($db_conx, $sql);
			$row_cnt = mysqli_num_rows($result);
			if($row_cnt==0){
				$post_fix=rand(5, 10);
				$timeline_id=$topic_name.$post_fix;
				$sql="insert into topic(topic,timeline_id) values('$topic_name','$timeline_id')";  
				$result = mysqli_query($db_conx, $sql);
				$sql="insert into timeline(timeline_id,Event_ID,Start_Date) values('$timeline_id','$event_id','$start_date')";  
				$result = mysqli_query($db_conx, $sql);
			}
			else{
				while ($row = $result->fetch_assoc()) {
					$timeline_id=$row['timeline_id'];
					$sql="insert into timeline(timeline_id,Event_ID,Start_Date) values('$timeline_id','$event_id','$start_date')";  
					$result = mysqli_query($db_conx, $sql);
					break;
				}
			}
			$message= "<br>Your Event is saved"; 
			$path='http://localhost/timeline/fetch_data.php?page='.$Event_Title;
		} 
	}
	else{
				$message= "<br>Your event is not saved";  
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
      <a class="navbar-brand" href="#"><img src="images/hourglass.png" style="margin-top:-20px;"></a>
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

<?php 
	echo $message;
	
?>
<br>
<a href="<?php echo $path ?>">Visit Timeline<a>

</body>
</html>