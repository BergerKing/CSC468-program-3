<!-- PHP contact form that writes to file-->
<html>
<head>
    <title>Contact Marcus</title>
    <link href="format.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="box">
	
    <?php
	$display = array(
    	'title' => 'test',
    	'time' => '17:39',
    	'date' => '1996-12-19',
	'location' => 'test',
	'presenter' => 'test',
	'description' => 'test'
	);

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
    		foreach($_POST as $key => $value){
        		if(isset($display[$key])){
            			$display[$key] = htmlspecialchars($value);
        		}
    		}
	}
	?>

    <form  action="updateColloquiumForm.php" method="POST" enctype="multipart/form-data"> 
    <input type="hidden" name="action" value="submit"> 
    *Colloquium Title:<br> 
    <input name="title" type="text" value="<?php echo $display['title']; ?>" size="30"/><br> 
    *Presentation Time:<br> 
    <input name="time" type="time" value="<?php echo $display['time']; ?>" size="30"/><br> 
    *Presentation Date:<br> 
    <input name="date" type="date" value="<?php echo $display['date']; ?>" size="30"/><br>
    *Location:<br>
    <input name="location" type="text" value="<?php echo $display['location']; ?>" size="30"/><br>
    *Presenter Name:<br>
    <input name="presenter" type="text" value="<?php echo $display['presenter']; ?>" size="30"/><br>
    <br>
    *Description<br>
    <input name="description" type="text" value="<?php echo $display['description']; ?>" size="50"/><br>
    <br>
    <input name="send" type="submit" value="Update"/> 
    <br>
    Please fill in *required fields	
    </form> 
	<?php
		
	if(isset($_POST['send']))
	{
		if(empty($_POST['title'])) 
  		{
    			$errorMessage = "Please enter a title!";
			echo "$errorMessage <br>";
  		}
		if(empty($_POST['time'])) 
  		{
    			$errorMessage = "Please enter a time!";
			echo "$errorMessage <br>";
  		}
		if(empty($_POST['date'])) 
  		{
    			$errorMessage = "Please enter a date!";
			echo "$errorMessage <br>";
  		}
		if(empty($_POST['location'])) 
  		{
    			$errorMessage = "Please enter a location!";
			echo "$errorMessage <br>";
  		}
		if(empty($_POST['presenter'])) 
  		{
    			$errorMessage = "Please enter presenter!";
			echo "$errorMessage <br>";
  		}
		if(empty($_POST['description'])) 
  		{
    			$errorMessage = "Please enter description!";
			echo "$errorMessage <br>";
  		}

		
  		if(empty($errorMessage)) 
  		{
    			if(isset($_POST['title']) and isset($_POST['time']) and isset($_POST['date']) and isset($_POST['location']) and isset($_POST['research']) 
				and isset($_POST['description'])) {
				$title = $_POST['title'];
				$time = $_POST['time'];
				$date = $_POST['date'];
				$location = $_POST['location'];
				$presenter = $_POST['presenter'];
				$description = $_POST['description'];
		
			}
  		}
	} 
	?>



     </div>

</body>
</html>

