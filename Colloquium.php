<html>

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
  header("Location: newcolloquium.php");
}

else if( isset($_POST['delete']) )
{
  header("Location: deletecolloquium.php");
}

else if( isset($_POST['update']) )
{
  header("Location: updatecolloquium.php");
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

<title> Colloquium </title>
<head>
  <center>
    <h1>Colloquium Schedule</h1>
  </center>
  <div>
    <form method="post" action="Coloquium.php">
      <div style="float:left;">
        <a href=Research.php>Research</a>
      </div>
      <div style="float:right;">
        <input type="submit" name="new" value="New Coloquium Event" align="right">
      </div>
    </form>
  </div>
<br>
</head>
<body>
  <div>
    <center>
      <?php
	  
		$db = readDatabase("Colloquium.xml");
	  
		foreach($db as $col)
		{
			echo "<hr>";
			echo "<p>$col->title</p>";
			//Presenter photo here?
			echo "<p>$col->time, $col->date, $col->location</p>";
			echo "<p>$col->presentor</p>";
			echo "<p>$col->description</p>";
			?>
			<form method="post" action="Colloquium.php">
			<p>
			<input type="submit" name="delete" value="Delete">
                        <input type="submit" name="update" value="Update">
			</p>
			</form>
			<?php
		}
      ?>
    </center>
  </div>
</body>
</html>
