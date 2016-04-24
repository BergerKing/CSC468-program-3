<html>

<script>
function expandInfo(elmnt) {
var txt = "";
	var child = elmnt.childNodes;
	if(child[1].style.display == "block")
		child[1].style.display = "none";
	else
		child[1].style.display = "block";

}
</script>

<?php

class Research {
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
    foreach ($tags as $key=>$val) {
        if ($key == "molecule") {
            $molranges = $val;
            // each contiguous pair of array entries are the 
            // lower and upper range for each molecule definition
            for ($i=0; $i < count($molranges); $i+=2) {
                $offset = $molranges[$i] + 1;
                $len = $molranges[$i + 1] - $offset;
                $tdb[] = parseMol(array_slice($values, $offset, $len));
            }
        } else {
            continue;
        }
    }
    return $tdb;
}

function parseMol($mvalues) 
{
    for ($i=0; $i < count($mvalues); $i++) {
        $mol[$mvalues[$i]["tag"]] = $mvalues[$i]["value"];
    }
//    return new AminoAcid($mol);
	return new Research($mol);

}

function addNewResearch ()
{
	$file = 'Research.xml';

	$xml = simplexml_load_file($file);

	$galleries = $xml->moldb;

	$gallery = $galleries->addChild('molecule');
	$gallery->addChild('name', 'info');
	$gallery->addChild('title', 'info');
	$gallery->addChild('degree', 'info');
	$gallery->addChild('university', 'info');
	$gallery->addChild('research', 'info');
	$gallery->addChild('website', 'info');
	$gallery->addChild('image', 'info');
	
	echo($xml);
	$xml->asXML($file);
}

if( isset($_POST['new']) )
{
  header("Location: newresearch.php");
}

else if( isset($_POST['delete']) )
{
  header("Location: deleteresearch.php");
}

else if( isset($_POST['update']) )
{
  header("Location: updateresearch.php");
}

/*
//$db = readDatabase("moldb.xml");
$db = readDatabase("Research.xml");
echo "** Database of Research objects:<br>";
print_r($db[0]);
echo("<br><br>");
print_r($db[1]);
echo("<br><br>");
print_r($db[1]->title);
addNewResearch();
*/

?>

<head>
	<title>MCS Website</title>
	<link href="Homepage/screen.css" rel="stylesheet" type="text/css" />
</head>	

<body>
	<div id="header">
		<img src="HomePage/MCS-Logo.png" alt="MCS Logo">
	</div>
	<div  class="colmid">
		<ul class="menu">
			<li><a href="http://www.sdsmt.edu/">SDSM&T Home</a></li>
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
			<li><a href="outside.html">MCS Colloquium</a></li>
			<li><a href="outside.html">Research</a></li>
			<li><a href="outside.html">Student Organizations</a></li>
			<li><a href="outside.html">Tutorials</a></li>
			<li><a href="outside.html">Forms, Coding Standards, and Policy</a></li>
		</ul>
	</div>

<br><br><br><br><br><br><br>
	<form method="post" action="Research.php">
      
		<div class = "newButton">
		<input type="submit" name="new" value="New Research" align="right">
		</div>
    </form>
	
	<center>
  <div class ="info">
		<?php
	  
		//$db = readDatabase("moldb.xml");
		$db = readDatabase("Research.xml");
	  	//addNewResearch();
		foreach($db as $research)
		{
			echo "<div class = 'dropDown' onclick='expandInfo(this)'>";
			echo "<p align = left class ='left'>$research->title</p>";
			echo "<div class = 'displayText'>";
			echo "<hr>";
			//Presenter photo here?
			echo "<p>$research->degree, $research->university</p>";
			echo "<p>Research Areas: $research->research</p>";
			echo "<a href='$research->website'>$research->website</a>";
			echo "<form method='post' action='Colloquium.php'>";
			echo "<p>";
			echo "<input type='submit' name='delete' value='Delete'>";
            echo "<input type='submit' name='update' value='Update'>";
			echo "</p>";
			echo "</form>";
			echo "</div>";
			echo "</div>";
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
