<?php 
include($_SERVER["DOCUMENT_ROOT"] . "/inc/database.php");
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$person_id 			= intval($_POST['pPerson_id']);
	$gameid 				= intval($_POST['pGameid']);
	$deathyear 			= trim(htmlspecialchars($_POST['pDeathyear']));
	$deathdesc 			= trim(htmlspecialchars($_POST['pDeathdesc']));
	$dead						=	0;

	try{
	  $results = $db->prepare("UPDATE people SET alive = ?, deathyear = ?, deathdesc = ? WHERE id = ? AND gameid = ?");
	  $results->bindParam(1,$dead);
	  $results->bindParam(2,$deathyear);
	  $results->bindParam(3,$deathdesc);
	  $results->bindParam(4,$person_id);
	  $results->bindParam(5,$gameid);
	  $results->execute();
	} catch (Exception $e) {
	  echo "Data could not be retrieved from the database.";
	  exit();
	}
}
?>