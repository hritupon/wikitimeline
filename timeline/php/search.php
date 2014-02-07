<?php
	include_once 'db_connection.php';
	$search_result='';
	if(isset($_POST['q'])){
		$search_term=$_POST['q'];
		$searchTerm = trim($search_term);

		//check whether the name parsed is empty
		if($searchTerm == "")
		{
			echo "Enter name you are searching for.";
			exit();
		}
		$query = "SELECT * FROM topic WHERE topic LIKE '%$searchTerm%'";
		$results = mysqli_query($db_conx, $query);
		if(mysqli_num_rows($results) >= 1)
		{
			$output = "";
			while($row = mysqli_fetch_array($results))
			{
				$link='fetch_data.php?page='.$row['topic'];
				$output .= "topic: <a href='".$link."' >" . $row['topic'] . "</a><br />";
				$output .= "Desc: " . $row['Description'] . "<br />";
				
			}
			$search_result= $output;
		}
		else
			$search_result="There was no matching record for the name " . $searchTerm;

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
      <form class="navbar-form navbar-left" role="search">
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
	echo $search_result;
	
?>
<br>

</body>
</html>