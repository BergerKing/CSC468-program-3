<!-- PHP contact form that writes to file-->
<html>
<?php
//Add a new research event
function addNewRes($name, $degree, $title, $university, $research, $web)
{
  $file = 'research.xml';

  $xml = simplexml_load_file($file);

  $galleries = $xml->moldb;

  $gallery = $xml->addChild('molecule');
  $gallery->addChild('name', $name);
  $gallery->addChild('title', $title);
  $gallery->addChild('degree', $degree);
  $gallery->addChild('university', $university);
  $gallery->addChild('research', $research);
  $gallery->addChild('website', $web);
  $gallery->addChild('image', $image);

  echo $xml->asXML();	
  $xml->asXML($file);
}

//Remove a research event
function removeEntry($name)
{
  $doc = new DOMDocument();
  $doc->Load('research.xml');
  $to_remove = array();

  foreach ($doc->getElementsByTagName('moldb') as $tagcourses)
  {
  //$tagcourses->molecule;
    foreach ( $tagcourses ->getElementsByTagName('molecule') as $tagcourse)
    {
      $thing = $tagcourse ->getElementsByTagName('name');
      $length = $tagcourse ->getElementsByTagName('name')->length;

      if(strcmp((string)$thing->item($indexX)->nodeValue , $name) == 0)
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
  $doc->Save('research.xml');
  $doc->Save();

}

//Update Research
function updateResearch($name, $degree, $level, $university, $research, $web)
{
	removeEntry( $_REQUEST['oldtitle'] );
	addNewRes($name, $degree, $level, $university, $research, $web);
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
	
    <p class = "titleText"> Research </p>
    <hr>
    <?php
    //initialize the elements in the text boxes
    $display = array(
    'name' => $_REQUEST['name'],
    'oldtitle' => $_REQUEST['oldtitle'],
    'title' => $_REQUEST['title'],
    'degree' => $_REQUEST['degree'],
    'university' => $_REQUEST['university'],
    'research' => $_REQUEST['research'],
    'webpage' => $_REQUEST['website']
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
    $titleToRemove = (string)$_REQUEST['name'];
    ?>

    <?php
    //Button to update the Research
    echo "<form  action='update-research-form.php?oldtitle=$titleRemove' method='POST' enctype='multipart/form-data'>" ?>
    <input type="hidden" name="action" value="submit"> 
    *Name:<br> 
    <input name="name" type="text" value="<?php echo $display['name']; ?>" size="30"/><br> 
    *Title:<br> 
    <input name="title" type="text" value="<?php echo $display['title']; ?>" size="30"/><br> 
    *Degree Name:<br> 
    <input name="degree" type="text" value="<?php echo $display['degree']; ?>" size="30"/><br> 
    <!--*Degree Level:<br> <input name="level" type="text" value="<?php //echo $display['level']; ?>" size="30"/><br>-->
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

    <!--Button to delete the research-->
    <?php    
	  echo "<form action='update-research-form.php?oldtitle=$titleToRemove' method='POST'>";
    echo "<input type='submit' name='delete' value='Delete'>";
    echo "</form>"; 
    ?>
    
    <!--Cancel button-->
    <form action="research.php" method="POST">
    <input name="cancel" type="submit" value="Cancel"/>
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
	    if(empty($_POST['title'])) 
	    {
  			$errorMessage = "Please enter a title (PhD, Student, Etc...)!";
	      echo "$errorMessage <br>";
	    }
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

	    //Updates the research if there are no errors on the form
	    if(empty($errorMessage)) 
	    {
  			if(isset($_POST['name']) and isset($_POST['degree']) and isset($_POST['title']) and isset($_POST['university']) and isset($_POST['research'])) 
        {
	      $name = $_POST['name'];
	      $degree = $_POST['degree'];
	      $title = $_POST['title'];
	      $university = $_POST['university'];
	      $research = $_POST['research'];
	      $web = $_POST['webpage'];
	      updateResearch($name, $degree, $title, $university, $research, $web);
	      header("Location: research.php");
	      }
	    }
    } 
    else if( isset($_POST['cancel']) )
    {
	    header("Location: research.php");
    }
    else if( isset($_POST['delete']) )
    {	
      $titleToRemove = $_REQUEST['oldtitle'];
	    $titleToRemove = htmlspecialchars($titleToRemove, ENT_QUOTES);
	    removeEntry($titleToRemove);
	    header("Location: research.php");
    }
    ?>

     </div>
  </div>
</center>
</body>
</html>

