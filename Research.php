<html>

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
	
//	print($xml);
	$xml->asXML($file);
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

<title> Research </title>
<head>
  <center>
    <h1>Research</h1>
  </center>
  <a href=Colloquium.php>Colloquium</a>
</head>
<body>
  <div>
    <center>
      <?php
	  
		//$db = readDatabase("moldb.xml");
		$db = readDatabase("Research.xml");
	  
		foreach($db as $research)
		{
			echo "<hr>";
			echo "<p>$research->name: $research->title</p>";
			//Presenter photo here?
			echo "<p>$research->degree, $research->university</p>";
			echo "<p>Research Areas: $research->research</p>";
			echo "<a href='$research->website'>$research->website</a>";
		}
      ?>
    </center>
  <div>
</body>
</html>