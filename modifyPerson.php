<?php
include($_SERVER["DOCUMENT_ROOT"] . "/inc/database.php");
if($_SERVER['REQUEST_METHOD'] == "POST"){

	$personid 		= trim(intval($_POST['personid']));
	$dob 					= trim(htmlspecialchars($_POST['dob']));
	$fertility 		= trim(intval($_POST['fertility']));
	$alive 				= trim(intval($_POST['alive']));
	$gender 			= trim(intval($_POST['gender']));
	$deathyear 		= trim(htmlspecialchars($_POST['deathyear']));
	$portrait 		= trim(intval($_POST['portrait']));
	$portrait 		= ltrim($portrait, '0');

	$firstname 		= trim(htmlspecialchars($_POST['firstname']));
	$middlename 	= trim(htmlspecialchars($_POST['middlename']));
	$lastname 		= trim(htmlspecialchars($_POST['lastname']));

	$bio 					= trim(htmlspecialchars($_POST['bio']));
	$deathdesc 		= trim(htmlspecialchars($_POST['deathdesc']));



	try{
	  $results = $db->prepare("UPDATE people SET firstname = ?, middlename = ?, lastname = ?, dob = ?, 
	  	portrait = ?, bio = ?, fertility = ?, alive = ?, deathyear = ?, deathdesc = ?, gender = ? WHERE id = ?");
	  $results->bindParam(1,$firstname);
	  $results->bindParam(2,$middlename);
	  $results->bindParam(3,$lastname);
	  $results->bindParam(4,$dob);
	  $results->bindParam(5,$portrait);
	  $results->bindParam(6,$bio);
	  $results->bindParam(7,$fertility);
	  $results->bindParam(8,$alive);
	  $results->bindParam(9,$deathyear);
	  $results->bindParam(10,$deathdesc);
	  $results->bindParam(11,$gender);
	  $results->bindParam(12,$personid);
	  $results->execute();
	} catch (Exception $e) {
	  echo "Data could not be retrieved from the database.";
	  exit();
	}
	try{
	  $results = $db->prepare("SELECT * FROM people WHERE id = ?");
	  $results->bindParam(1,$personid);
	  $results->execute();
	  $hold = $results->fetchAll(PDO::FETCH_ASSOC);
	} catch (Exception $e) {
	  echo "Data could not be retrieved from the database.";
	  exit();
	}
	$gameid = $hold[0]['gameid'];


	header('Location: ../../play.php?id='.$gameid);
	// echo 'worked';
}
?>