<?php 
include($_SERVER["DOCUMENT_ROOT"] . "/namelookup.php");

$portrait = rand(0,400);
$malenameSize	 		= sizeof($romanFirstnames) - 1;
$femalenameSize	 	= sizeof($romanWomennames) - 1;

$malefirstnameNumber 	= rand(0, $malenameSize);
$malemiddlenameNumber = rand(0, $malenameSize);
while($malefirstnameNumber == $malemiddlenameNumber){
	$malemiddlenameNumber = rand(0, $malenameSize);
}


$femalefirstnameNumber 	= rand(0, $femalenameSize);
$femalemiddlenameNumber = rand(0, $femalenameSize);
while($femalefirstnameNumber == $femalemiddlenameNumber){
	$femalemiddlenameNumber = rand(0, $femalenameSize);
}


echo 'Male: '.$romanFirstnames[$malefirstnameNumber]." ".$romanFirstnames[$malemiddlenameNumber]." Portrait: ".$portrait;
echo '<br>';
echo 'Female: '.$romanWomennames[$femalefirstnameNumber]." ".$romanWomennames[$femalemiddlenameNumber];
?>