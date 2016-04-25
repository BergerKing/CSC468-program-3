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
class Colloquium {
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
	return new Colloquium($mol);

}

function addNewTest($name, $title, $degree, $university, $research, $website)
{

$file = 'Research.xml';

$xml = simplexml_load_file('Research.xml');

$galleries = $xml->moldb;

$test = $galleries->addChild('molecule');
$test->addChild('title',$name);
$test->addChild('time',$title);
$test->addChild('date',$degree);
$test->addChild('location',$university);
$test->addChild('presentor',$research);
$test->addChild('description',$website);


  $xml->asXML();
  $xml->asXML($file);
}

if( isset($_POST['new']) )
{
  header("Location: colloquiumForm.php");
}

else if( isset($_POST['delete']) )
{
  header("Location: Colloquium.php");
}

else if( isset($_POST['update']) )
{
  header("Location: updateColloquiumForm.php");
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
<link href="HomePage/screen.css" rel="stylesheet" type="text/css" />
<title>MCS Website</title>
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
	<form method="post" action="Colloquium.php">
      
		<div class = "newButton">
		<input type="submit" name="new" value="New Colloquium" align="right">
		</div>
    </form>
	
	<center>
  <div class ="info">

		
  
      <?php
	  
		$db = readDatabase("Colloquium.xml");
	  
		foreach($db as $col)
		{
			$ColTitle = $col->title;
			$ColTitle = htmlspecialchars($ColTitle, ENT_QUOTES);
			$ColName = $col->presenter;
			$ColName = htmlspecialchars($ColName, ENT_QUOTES);
			$ColLoca = $col->location;
			$ColLoca = htmlspecialchars($ColLoca, ENT_QUOTES);
			$ColDesc = $col->description;
			$ColDesc = htmlspecialchars($ColDesc, ENT_QUOTES);
			echo "<form method='post' action='updateColloquiumForm.php?title=$ColTitle&time=$col->time&date=$col->date&location=$ColLoca&presenter=$ColName&description=$ColDesc'>";
			$childName = $col->title + "Text";
			echo "<div class = 'dropDown' onclick='expandInfo(this)'>";
			echo "<p align = left class ='left'>$col->title</p>";
			echo "<div class = 'displayText'>";
			echo "<hr>";
			echo "<p>$col->title</p>";
			//Presenter photo here?
			$StandardHourTime = date("g:i a", strtotime("$col->time"));
			echo "<p>$StandardHourTime, $col->date, $col->location</p>";
			echo "<p>$col->presenter</p>";
			echo "<p>$col->description</p>";
					
			echo "<p>";
			//if(User::hasPermission("ColloquiumPermission"))
			//{
				echo "<input type='submit' name='delete' value='Delete'>";
           			echo "<input type='submit' name='update' value='Update'>";
			//}
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
