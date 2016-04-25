<!-- PHP contact form that writes to file-->
<html>
<?php
//Add new Colloquium event
function addNewCol($title, $time, $date, $location, $presentor, $description)
{
  $file = 'colloquium.xml';

  $xml = simplexml_load_file($file);

  $galleries = $xml->moldb;

  $test = $xml->addChild('molecule');
  $test->addChild('title',$title);
  $test->addChild('time',$time);
  $test->addChild('date',$date);
  $test->addChild('location',$location);
  $test->addChild('presentor',$presentor);
  $test->addChild('description',$description);
	
  $xml->asXML($file);
}

//Remove a Colloquium event
function removeEntry($title)
{
	$doc = new DOMDocument();
	$doc->Load('colloquium.xml');
	$to_remove = array();

  foreach ($doc->getElementsByTagName('moldb') as $tagcourses)
  {
    foreach ( $tagcourses ->getElementsByTagName('molecule') as $tagcourse)
    {
	    $thing = $tagcourse ->getElementsByTagName('title');
	    $length = $tagcourse ->getElementsByTagName('title')->length;
	
	    if(strcmp((string)$thing->item($indexX)->nodeValue , $title) == 0)
      {
	      $to_remove[] = $tagcourse;
     	}
    }
  }
	
  // Remove the nodes stored in your array
  // by removing it from its parent
  foreach ($to_remove as $node)
  {
     $node->parentNode->removeChild($node);
  }
  $doc->Save('colloquium.xml');
  $doc->Save();
}

//Update the Colloquium event
function updateCol($title, $oldtitle, $time, $date, $location, $presentor, $description)
{
	removeEntry( $_REQUEST['oldtitle'] );
	addNewCol($title, $time, $date, $location, $presentor, $description);	
}
?>

<head>
  <link href="HomePage/screen.css" rel="stylesheet" type="text/css" />
  <title>MCS Website</title>
</head>

<body>
  <div id="header">
		<img src="HomePage/MCS-Logo.png" alt="MCS Logo">
	</div>
  <!--Menu on the left-->
	<div  class="colmid">
		<ul class="menu">
			<li><a href="http://www.sdsmt.edu/">SDSM&T Home</a></li>
			<li><a href="HomePage/homepage.html">MCS Home</a></li>
			<li><a href="https://wa-sdsmt.prod.sdbor.edu/WebAdvisor/webadvisor">Web Advisor</a></li>
			<li><a href="outside.html">Submit It</a></li>
			<li><a href="outside.html">Faculty, Student, and Alumni</a></li>
			<li><a href="outside.html">Department Directory</a></li>
			<li><a href="outside.html">Building Map</a></li>
			<li><a href="outside.html">CS Courses</a></li>
			<li><a href="outside.html">Math Courses</a></li>
			<li><a href="outside.html">CS Checklist</a></li>
			<li><a href="outside.html">CS Flowchart</a></li>
			<li><a href="outside.html">CS Scheduler</a></li>
			<li><a href="colloquium.php">MCS Colloquium</a></li>
			<li><a href="research.php">Research</a></li>
			<li><a href="outside.html">Student Organizations</a></li>
			<li><a href="outside.html">Tutorials</a></li>
			<li><a href="outside.html">Forms, Coding Standards, and Policy</a></li>
		</ul>
	</div>

<br><br><br><br><br><br><br>
	
	<center>
  <div class ="info"  id = "whiteBox">
    <div class="box">
	
	  <p class = "titleText"> Colloquium </p>
	  <hr>
    <div class="box">
	
    <?php
    $display = array(
    'title' => $_REQUEST['title'],
    'oldtitle' => $_REQUEST['oldtitle'],
    'time' => $_REQUEST['time'],
    'date' => $_REQUEST['date'],
    'location' => $_REQUEST['location'],
    'presenter' => $_REQUEST['presenter'],
    'description' => $_REQUEST['description']
    );

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
		  foreach($_POST as $key => $value)
      {
  		  if(isset($display[$key]))
        {
  			  $display[$key] = htmlspecialchars($value);
    		}
  		}
	  }
	
	  $titleRemove = (string)$_REQUEST['title'];
	  ?>

    <?php
    //Button to update the Colloquium event
	  echo "<form  action='update-colloquium-form.php?oldtitle=$titleRemove' method='POST' enctype='multipart/form-data'>" 
    ?>
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
    </form>
    <?php
	  $titleRemove = (string)$_REQUEST['title'];
    //Button to delete the Colloquium event
	  echo "<form action='update-colloquium-form.php?title=$titleRemove' method='POST'>";
    echo "<input type='submit' name='delete' value='Delete'>";
    echo '</form> ';
    ?> 

    <!--Button to cancel the update to the colloquium-->
    <form action="update-colloquium-form.php" method="POST">
    <input name="cancel" type="submit" value="Cancel"/>
    </form>
    Please fill in *required fields

	  <?php
	  if( isset($_POST['cancel']) )
	  {
		  header("Location: colloquium.php");
	  }
	  else if( isset($_POST['delete']) )
	  {	
		  removeEntry( $_REQUEST['title'] );
		  header("Location: colloquium.php");
	  }
	  else if(isset($_POST['send']))
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

		  //If there are no errors in the forms then update the colloquium event
		  if(empty($errorMessage)) 
		  {
			  if(isset($_POST['title']) and isset($_POST['time']) and isset($_POST['date']) and isset($_POST['location']) and isset($_POST['presenter']) 
			  and isset($_POST['description'])) 
        {
			    $title = $_POST['title'];
			    $time = $_POST['time'];
			    $date = $_POST['date'];
			    $location = $_POST['location'];
			    $presenter = $_POST['presenter'];
			    $description = $_POST['description'];
			    updateCol($title, $oldtitle, $time, $date, $location, $presenter, $description);
			    header("Location: colloquium.php");
		    }
		  }
	  } 
	
	  ?>

     </div>
  </div>
</center>
</body>
</html>





