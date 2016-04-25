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
class Colloquium 
{
  var $title;
  var $time;
  var $date;
  var $location;
  var $presentor;
  var $description;
  var $image;

  function Colloquium ($aa)
  {
    foreach ($aa as $k=>$v)
      $this->$k = $aa[$k];
  }
}


function removeEntry($title)
{
  $doc = new DOMDocument();
  $doc->Load('colloquium.xml');
  $to_remove = array();

  foreach ($doc->getElementsByTagName('moldb') as $tagcourses)
  {

    //$tagcourses->molecule;
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
  return new Colloquium($mol);
}

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

/*
if( isset($_POST['new']) )
{
  header("Location: newcolloquium.php");
}


else if( isset($_POST['update']) )
{
  header("Location: updatecolloquium.php");
}
*/

?>

<head>
  <link href="HomePage/screen.css" rel="stylesheet" type="text/css" />
  <title>MCS Website</title>
</head>

<body>
  <div id="header">
	  <img src="HomePage/MCS-Logo.png" alt="MCS Logo">
	</div>
  <!--Menu on left side of page-->
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

  <!--Button to add a new colloquium event-->
	<form method="post" action="colloquium-form.php">
		<div class = "newButton">
		  <input type="submit" name="new" value="New Colloquium" align="right">
		</div>
  </form>
	
  <!--Display info in the xml file-->
	<center>
  <div class ="info">
  
    <?php
	  
		$db = readDatabase("colloquium.xml");
	  
		foreach($db as $col)
		{
      //Clean the title, presentor, location, description
			$ColTitle = $col->title;
			$ColTitle = htmlspecialchars($ColTitle, ENT_QUOTES);
			$ColName = $col->presentor;
			$ColName = htmlspecialchars($ColName, ENT_QUOTES);
			$ColLoca = $col->location;
			$ColLoca = htmlspecialchars($ColLoca, ENT_QUOTES);
			$ColDesc = $col->description;
			$ColDesc = htmlspecialchars($ColDesc, ENT_QUOTES);
      //send the info to the update form when the update button pressed
			echo "<form method='post' action='update-colloquium-form.php?title=$ColTitle&time=$col->time&date=$col->date&location=$ColLoca&presenter=$ColName&description=$ColDesc'>";
			$childName = $col->title + "Text";
			echo "<div class = 'dropDown' onclick='expandInfo(this)'>";
			echo "<p align = left class ='left'>$col->title</p>";
			echo "<div class = 'displayText'>";
			echo "<hr>";
			echo "<p>$col->title</p>";
			//Presenter photo here?
			$StandardHourTime = date("g:i a", strtotime("$col->time"));
			echo "<p>$StandardHourTime, $col->date, $col->location</p>";
			echo "<p>$col->presentor</p>";
			echo "<p>$col->description</p>";
					
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
