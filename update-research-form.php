<!-- PHP contact form that writes to file-->
<html>
<head>
    <title>Update Research</title>
    <link href="format.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="box">
	
    <?php
	$display = array(
    	'name' => $_REQUEST['title'],
    	'degree' => $_REQUEST['degree'],
	'university' => $_REQUEST['university'],
	'research' => $_REQUEST['research'],
	'webpage' => $_REQUEST['website']
	);

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
    		foreach($_POST as $key => $value){
        		if(isset($display[$key])){
            			$display[$key] = htmlspecialchars($value);
        		}
    		}
	}
	?>

    <form  action="updateResearchForm.php" method="POST" enctype="multipart/form-data"> 
    <input type="hidden" name="action" value="submit"> 
    *Name:<br> 
    <input name="name" type="text" value="<?php echo $display['name']; ?>" size="30"/><br> 
    *Degree Name:<br> 
    <input name="degree" type="text" value="<?php echo $display['degree']; ?>" size="30"/><br> 
    <!--*Degree Level:<br> 
    <input name="level" type="text" value="<?php echo $display['level']; ?>" size="30"/><br>-->
    *University:<br>
    <input name="university" type="text" value="<?php echo $display['university']; ?>" size="30"/><br>
    *Research Areas:<br>
    <input name="research" type="text" value="<?php echo $display['research']; ?>" size="50"/><br>
    <br>
    Personal Webpage<br>
    <input name="webpage" type="url" value="<?php echo $display['webpage']; ?>" size="30"/><br>
    <br>
    <input name="send" type="submit" value="Update"/> 
    </form> 
    <form action="Research.php" method="POST">
    <input name="canel" type="submit" value="Cancel"/>
    </form>
    Please fill in *required fields
	<?php
		
	if(isset($_POST['send']))
	{
		if(empty($_POST['name'])) 
  		{
    			$errorMessage = "Please enter a name!";
			echo "$errorMessage <br>";
  		}
		if(empty($_POST['degree'])) 
  		{
    			$errorMessage = "Please enter a degree type or title!";
			echo "$errorMessage <br>";
  		}
		/*if(empty($_POST['level'])) 
  		{
    			$errorMessage = "Please enter a degree level (PhD, Student, Etc...)!";
			echo "$errorMessage <br>";
  		}*/
		if(empty($_POST['university'])) 
  		{
    			$errorMessage = "Please enter a university!";
			echo "$errorMessage <br>";
  		}
		if(empty($_POST['research'])) 
  		{
    			$errorMessage = "Please enter research areas!";
			echo "$errorMessage <br>";
  		}

		
  		if(empty($errorMessage)) 
  		{
    			if(isset($_POST['name']) and isset($_POST['degree']) and isset($_POST['university']) and isset($_POST['research'])) {
			$name = $_POST['name'];
			$degree = $_POST['degree'];
			//$level = $_POST['level'];
			$university = $_POST['university'];
			$research = $_POST['research'];
			$web = $_POST['webpage'];
			
			header("Location: Research.php");
		
			}
  		}
	} 
	else if( isset($_POST['cancel']) )
	{
		header("Location: Research.php");
	}
	?>



     </div>

</body>
</html>
