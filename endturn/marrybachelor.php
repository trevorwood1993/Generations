<?php 
include($_SERVER["DOCUMENT_ROOT"] . "/inc/database.php");
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$person_id 				= intval($_POST['pPerson_id']);
	$bachelorAge 			= trim(htmlspecialchars($_POST['pAge']));
	$currentyear 			= trim(htmlspecialchars($_POST['pCurrentyear']));
	$gameid 					= intval($_POST['pGameid']);
	// $person_id 		= 1;
	// $currentyear 	= 200;
	// $bachelorAge 	= 20;
	// $gameid				=	1;

	include($_SERVER["DOCUMENT_ROOT"] . "/namelookup.php");

	$womennameSize	 	= sizeof($romanWomennames) - 1;
	$surnameSize 			= sizeof($romanSurnames) - 1;

	$firstnameNumber 	= rand(0, $womennameSize);
	$middlenameNumber = rand(0, $womennameSize);
	while($firstnameNumber == $middlenameNumber){
		$middlenameNumber = rand(0, $femalenameSize);
	}
	$surnameNumber 		= rand(0, $surnameSize);
	// $portrait 				= rand(0,190);

	// echo $romanWomennames[$firstnameNumber]." ".$romanWomennames[$middlenameNumber]." ".$romanSurnames[$surnameNumber];
	$firstname 		= $romanWomennames[$firstnameNumber];
	$middlename 	= $romanWomennames[$middlenameNumber];
	$lastname  		= $romanSurnames[$surnameNumber];
	switch (true) {
		case ($bachelorAge >= 14 && $bachelorAge < 16):
			$femalesAge = rand(14,17);
			break;
		case ($bachelorAge >= 16 && $bachelorAge < 21):
			$femalesAge = rand(14,22);
			break;
		case ($bachelorAge >= 21 && $bachelorAge < 26):
			$femalesAge = rand(14,20);
			break;
		case ($bachelorAge >= 26 && $bachelorAge < 32):
			$femalesAge = rand(14,27);
			break;
		case ($bachelorAge >= 32 && $bachelorAge < 40):
			$femalesAge = rand(14,28);
			break;
		case ($bachelorAge >= 40 && $bachelorAge < 50):
			$femalesAge = rand(16,32);
			break;
		case ($bachelorAge >= 50 && $bachelorAge < 65):
			$femalesAge = rand(16,40);
			break;
		case ($bachelorAge >= 65 && $bachelorAge < 90):
			$femalesAge = rand(16,40);
			break;
		default:
			$femalesAge = rand(16,25);
			break;
	}
	$dob = $currentyear - $femalesAge; 
	$gender = 2;
	$fertility = rand(0,7);
	if($fertility != 4){
		$fertility = rand(0,7);
	}
	if($fertility <= 3){
		$fertility = rand(0,4);
	}
	if($fertility == 0){
		$fertility = rand(0,1);
		if($fertility == 0){
			$fertility = rand(0,1);
		}
	}
	if($fertility >= 5){
		$fertility = rand(4,7);
	}

	try{
	  $results = $db->prepare("INSERT INTO people (firstname, middlename, lastname, dob, gender, spouseid, fertility, gameid)
	  	VALUES(?,?,?,?,?,?,?,?)");
	  $results->bindParam(1,$firstname);
	  $results->bindParam(2,$middlename);
	  $results->bindParam(3,$lastname);
	  $results->bindParam(4,$dob);
	  $results->bindParam(5,$gender);
	  $results->bindParam(6,$person_id);
	  $results->bindParam(7,$fertility);
	  $results->bindParam(8,$gameid);
	  $results->execute();
	  $lastId = $db->lastInsertId();
	} catch (Exception $e) {
	  echo "Data could not be retrieved from the database.";
	  exit();
	}

	try{
	  $results = $db->prepare("UPDATE people SET spouseid = ? WHERE id = ?");
	  $results->bindParam(1,$lastId);
	  $results->bindParam(2,$person_id);
	  $results->execute();
	} catch (Exception $e) {
	  echo "Data could not be retrieved from the database.";
	  exit();
	}
	$spouseportrait = "/img/roman/family/wife.png";
	
	$data = '<div class="links aliveDisaster">
					<img class="smallimg" src="'.$spouseportrait.'">
					<div class="charinfo" style="display:none;">
						<input type="text" class="personid" value="'.$lastId.'">
						<input type="text" class="firstname" value="'.$firstname.'">
						<input type="text" class="middlename" value="'.$middlename.'">
						<input type="text" class="lastname" value="'.$lastname.'">
						<input type="text" class="dob" value="'.$dob.'">
						<input type="text" class="children" value="0">
						<input type="text" class="gender" value="2">
						<input type="text" class="fertility" value="'.$fertility.'">
						<input type="text" class="alive" value="1">
						<input type="text" class="bio" value="">
						<input type="text" class="deathyear" value="">
						<input type="text" class="deathdesc" value="">
					</div>
				</div>';

	

	try{
	  $results = $db->prepare("SELECT * FROM people WHERE id = ?");
	  $results->bindParam(1,$person_id);
	  $results->execute();
	  $hold3 = $results->fetchAll(PDO::FETCH_ASSOC);
	} catch (Exception $e) {
	  echo "Data could not be retrieved from the database.";
	  exit();
	}
	$firstname 		= $hold3[0]['firstname'];
	$middlename 	= $hold3[0]['middlename'];
	$lastname 		= $hold3[0]['lastname'];

	$fullname = $firstname." ".$middlename." ".$lastname;
	
	$array = array(
		'value1' => $person_id, 
		'value2' => $data,
		'value3' => $fullname
	);

	echo json_encode($array);
}
?>