<?php
include($_SERVER["DOCUMENT_ROOT"] . "/inc/database.php");
if($_SERVER['REQUEST_METHOD'] == "POST"){

	$personid 		= trim(intval($_POST['personid']));

	try{
	  $results = $db->prepare("SELECT * FROM people WHERE id = ?");
	  $results->bindParam(1,$personid);
	  $results->execute();
	  $hold = $results->fetchAll(PDO::FETCH_ASSOC);
	} catch (Exception $e) {
	  echo "Data could not be retrieved from the database.";
	  exit();
	}
	$fatherid = $hold[0]['fatherid'];
	$motherid = $hold[0]['motherid'];
	$spouseid = $hold[0]['spouseid'];
	$gameid = $hold[0]['gameid'];
	try{
	  $results = $db->prepare("UPDATE people SET children = children-1 WHERE id = ? OR id = ?");
	  $results->bindParam(1,$fatherid);
	  $results->bindParam(2,$motherid);
	  $results->execute();
	} catch (Exception $e) {
	  echo "Data could not be retrieved from the database.";
	  exit();
	}
	try{
	  $results = $db->prepare("UPDATE people SET spouseid = NULL WHERE id = ?");
	  $results->bindParam(1,$spouseid);
	  $results->execute();
	} catch (Exception $e) {
	  echo "Data could not be retrieved from the database.";
	  exit();
	}
	try{
	  $results = $db->prepare("DELETE FROM people WHERE id = ?");
	  $results->bindParam(1,$personid);
	  $results->execute();
	} catch (Exception $e) {
	  echo "Data could not be retrieved from the database.";
	  exit();
	}


	header('Location: ../../play.php?id='.$gameid);
	// echo 'worked';
}
?>