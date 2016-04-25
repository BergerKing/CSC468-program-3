<html>

<script>
function expandInfo(elmnt) 
{
  var txt = "";
  var child = elmnt.childNodes;
  if(child[1].style.display == "block")
    child[1].style.display = "none";
  else
    child[1].style.display = "block";
}
</script>

<?php

class Research 
{
  var $name;
  var $title;
  var $degree;
  var $university;
  var $research;
  var $website;
  var $image;
	
  function Research ($aa)
  {
	  foreach ($aa as $k=>$v)
      $this->$k = $aa[$k];
  }
}

function readDatabase($filename) 
{
  // read the XML database of aminoacids
  $data = implode("", file($filename));
  $parser = xml_parser_create();
  xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
  xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
  xml_parse_into_struct($parser, $data, $values, $tags);
  xml_parser_free($parser);

  // loop through the structures
  foreach ($tags as $key=>$val) 
  {
    if ($key == "molecule") 
    {
      $molranges = $val;
      // each contiguous pair of array entries are the 
      // lower and upper range for each molecule definition
      for ($i=0; $i < count($molranges); $i+=2) 
      {
        $offset = $molranges[$i] + 1;
        $len = $molranges[$i + 1] - $offset;
        $tdb[] = parseMol(array_slice($values, $offset, $len));
      }
    } 
    else 
    {
      continue;
    }
  }
  return $tdb;
}

function parseMol($mvalues) 
{
  for ($i=0; $i < count($mvalues); $i++) 
  {
    $mol[$mvalues[$i]["tag"]] = $mvalues[$i]["value"];
  }
  return new Research($mol);
}

//add new research to the xml file.
function addNewRes ()
{
	$file = 'research.xml';

	$xml = simplexml_load_file($file);

	$galleries = $xml->moldb;

	$gallery = $xml->addChild('molecule');
	$gallery->addChild('name', 'info');
	$gallery->addChild('title', 'info');
	$gallery->addChild('degree', 'info');
	$gallery->addChild('university', 'info');
	$gallery->addChild('research', 'info');
	$gallery->addChild('website', 'info');
	$gallery->addChild('image', 'info');
		
	$xml->asXML($file);
}

if( isset($_POST['new']) )
{
  header("Location: research-form.php");
}

else if( isset($_POST['delete']) )
{
  header("Location: deleteresearch.php");
}

else if( isset($_POST['update']) )
{
  header("Location: update-research-form.php");
}

/*
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
  if(empty($_POST['level'])) 
  {
    $errorMessage = "Please enter a degree level (PhD, Student, Etc...)!";
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

  if(empty($errorMessage)) 
  {
    if(isset($_POST['name']) and isset($_POST['degree']) and isset($_POST['level']) and isset($_POST['university']) and isset($_POST['research'])) 
    {
      $name = $_POST['name'];
      $degree = $_POST['degree'];
      $level = $_POST['level'];
      $university = $_POST['university'];
      $research = $_POST['research'];
      $web = $_POST['webpage'];
      addNewRes();
      echo "Things";
      header("Location: Research.php");
    }
  }
}*/
?>

<head>
  <title>MCS Website</title>
	<link href="HomePage/screen.css" rel="stylesheet" type="text/css" />
</head>	

<body>
	<div id="header">
		<img src="HomePage/MCS-Logo.png" alt="MCS Logo">
	</div>
  <!--menu on the left side of the screen-->
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

  <!--Button to add a new research-->
	<form method="post" action="research.php">
		<div class = "newButton">
		  <input type="submit" name="new" value="New Research" align="right">
		</div>
  </form>
	
	<center>
  <div class ="info">
		<?php
	  //loop through all of the entries in the xml file
		$db = readDatabase("research.xml");
		foreach($db as $research)
		{
      //Clean the name, title, degree, university, and research
			$ResName = $research->name;
			$ResName = htmlspecialchars($ResName, ENT_QUOTES);
			$ResTitle = $research->title;
			$ResTitle = htmlspecialchars($ResTitle, ENT_QUOTES);
			$ResDegr = $research->degree;
			$ResDegr = htmlspecialchars($ResDegr, ENT_QUOTES);
			$ResUniv = $research->university;
			$ResUniv = htmlspecialchars($ResUniv, ENT_QUOTES);
			$ResArea = $research->research;
			$ResArea = htmlspecialchars($ResArea, ENT_QUOTES);

      //send info to the update research form
			echo "<form method='post' action='update-research-form.php?name=$ResName&title=$ResTitle&degree=$ResDegr&university=$ResUniv&research=$ResArea&website=$research->website'>";
			
      //Display the info on the screen
			echo "<div class = 'dropDown' onclick='expandInfo(this)'>";
			echo "<p align = left class ='left'> $research->name</p>";
			echo "<div class = 'displayText'>";
			echo "<hr>";

			echo "<p>$research->title: $research->degree, $research->university</p>";
			echo "<p>Research Areas: $research->research</p>";
			echo "<a href='$research->website'>$research->website</a>";
			echo "<p>";
 			echo "<input type='submit' name='update' value='Update'>";
			echo "</p>";
			echo "</div>";
			echo "</div>";
			echo "</form>";
			echo "<br><br>";
		}
    ?>
    
  </div>
  </center>
  <div id = "footer">
	  <p class = "white-text">605.394.2471 | <a href="mailto:kyle.riley@sdsmt.edu" onfocus="this.blur()" class = "white-text">email</a></p>
	</div>
	<br>
	<br>
	<br>
	<br>
  
</body>
</html>
