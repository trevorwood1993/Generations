<?php
include($_SERVER["DOCUMENT_ROOT"] . "/inc/database.php");

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$user_id 				= 1;
	$factiontype 		= trim(htmlspecialchars($_POST['factiontype']));
	$savename 			= trim(htmlspecialchars($_POST['savename']));

	if($savename == ""){
		$savename = "emptygamesavename";
	}

	include($_SERVER["DOCUMENT_ROOT"] . "/namelookup.php");

	$firstnameSize = sizeof($romanFirstnames) - 1;
	$surnameSize = sizeof($romanSurnames) - 1;

	$firstnameNumber 	= rand(0, $firstnameSize);
	$middlenameNumber = rand(0, $firstnameSize);
	$surnameNumber 		= rand(0, $surnameSize);
	$portrait 				= rand(0,478);

	// echo $romanFirstnames[$firstnameNumber]." ".$romanFirstnames[$middlenameNumber]." ".$romanSurnames[$surnameNumber];
	$leaderfirstname 		= $romanFirstnames[$firstnameNumber];
	$leadermiddlename 	= $romanFirstnames[$middlenameNumber];
	while($leaderfirstname == $leadermiddlename){
		$leadermiddlename = rand(0, $firstnameSize);
	}
	$leaderlastname  		= $romanSurnames[$surnameNumber];
	$dob 								= 180;


	try{
	  $results = $db->prepare("INSERT INTO people (firstname,middlename,lastname,dob,portrait)VALUES(?,?,?,?,?)");
	  $results->bindParam(1,$leaderfirstname);
	  $results->bindParam(2,$leadermiddlename);
	  $results->bindParam(3,$leaderlastname);
	  $results->bindParam(4,$dob);
	  $results->bindParam(5,$portrait);
	  $results->execute();
	  $lastId = $db->lastInsertId();
	} catch (Exception $e) {
	  echo "Data could not be retrieved from the database.";
	  exit();
	}

	try{
	  $results = $db->prepare("INSERT INTO gamesave (leaderid, savename, factiontype, user_id)VALUES(?,?,?,?)");
	  $results->bindParam(1,$lastId);
	  $results->bindParam(2,$savename);
	  $results->bindParam(3,$factiontype);
	  $results->bindParam(4,$user_id);
	  $results->execute();
	  $lastId2 = $db->lastInsertId();
	} catch (Exception $e) {
	  echo "Data could not be retrieved from the database.";
	  exit();
	}
	try{
	  $results = $db->prepare("UPDATE people SET gameid = ? WHERE id = ?");
	  $results->bindParam(1,$lastId2);
	  $results->bindParam(2,$lastId);
	  $results->execute();
	} catch (Exception $e) {
	  echo "Data could not be retrieved from the database.";
	  exit();
	}
	echo '<script type="text/javascript">
					window.location.replace("../../play.php?id='.$lastId2.'");
				</script>';
}
?>













