<?php 
include($_SERVER["DOCUMENT_ROOT"] . "/inc/database.php");
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$person_id 				= intval($_POST['pPerson_id']);
	$bacheloretteAge 	= trim(htmlspecialchars($_POST['pAge']));
	$currentyear 			= trim(htmlspecialchars($_POST['pCurrentyear']));
	$gameid 					= intval($_POST['pGameid']);
	// $person_id 		= 1;
	// $currentyear 	= 200;
	// $bachelorAge 	= 20;
	// $gameid				=	1;

	include($_SERVER["DOCUMENT_ROOT"] . "/namelookup.php");

	$mennameSize	 		= sizeof($romanFirstnames) - 1;
	$surnameSize 			= sizeof($romanSurnames) - 1;

	$firstnameNumber 	= rand(0, $mennameSize);
	$middlenameNumber = rand(0, $mennameSize);
	while($firstnameNumber == $middlenameNumber){
		$middlenameNumber = rand(0, $femalenameSize);
	}
	$surnameNumber 		= rand(0, $surnameSize);
	$portrait 				= rand(0,478);

	// echo $romanFirstnames[$firstnameNumber]." ".$romanFirstnames[$middlenameNumber]." ".$romanSurnames[$surnameNumber];
	$firstname 		= $romanFirstnames[$firstnameNumber];
	$middlename 	= $romanFirstnames[$middlenameNumber];
	$lastname  		= $romanSurnames[$surnameNumber];
	switch (true) {
		case ($bacheloretteAge >= 14 && $bacheloretteAge < 16):
			$malesAge = rand(14,17);
			break;
		case ($bacheloretteAge >= 16 && $bacheloretteAge < 21):
			$malesAge = rand(14,22);
			break;
		case ($bacheloretteAge >= 21 && $bacheloretteAge < 26):
			$malesAge = rand(14,28);
			break;
		case ($bacheloretteAge >= 26 && $bacheloretteAge < 32):
			$malesAge = rand(16,34);
			break;
		case ($bacheloretteAge >= 32 && $bacheloretteAge < 40):
			$malesAge = rand(18,38);
			break;
		case ($bacheloretteAge >= 40 && $bacheloretteAge < 50):
			$malesAge = rand(21,45);
			break;
		case ($bacheloretteAge >= 50 && $bacheloretteAge < 65):
			$malesAge = rand(21,50);
			break;
		case ($bacheloretteAge >= 65 && $bacheloretteAge < 90):
			$malesAge = rand(21,50);
			break;
		default:
			$malesAge = rand(16,25);
			break;
	}
	$dob = $currentyear - $malesAge; 
	$gender = 1;
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
	  $results = $db->prepare("INSERT INTO people (firstname, middlename, lastname, dob, portrait, gender, spouseid, fertility, gameid)
	  	VALUES(?,?,?,?,?,?,?,?,?)");
	  $results->bindParam(1,$firstname);
	  $results->bindParam(2,$middlename);
	  $results->bindParam(3,$lastname);
	  $results->bindParam(4,$dob);
	  $results->bindParam(5,$portrait);
	  $results->bindParam(6,$gender);
	  $results->bindParam(7,$person_id);
	  $results->bindParam(8,$fertility);
	  $results->bindParam(9,$gameid);
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
	if($portrait <= 9){
		$portrait = "00".$portrait;
	}elseif($portrait <= 99){
		$portrait = "0".$portrait;
	}

	if($malesAge >= 50){
		//old
		$spouseportrait = "/img/roman/old/".$portrait.".png";
	}else{
		//young
		$spouseportrait = "/img/roman/young/".$portrait.".png";
	}
	
	
	$data = '<div class="links aliveDisaster">
					<img class="bigimg" src="'.$spouseportrait.'">
					<div class="charinfo" style="display:none;">
						<input type="text" class="personid" value="'.$lastId.'">
						<input type="text" class="firstname" value="'.$firstname.'">
						<input type="text" class="middlename" value="'.$middlename.'">
						<input type="text" class="lastname" value="'.$lastname.'">
						<input type="text" class="dob" value="'.$dob.'">
						<input type="text" class="children" value="0">
						<input type="text" class="portrait" value="'.$portrait.'">
						<input type="text" class="gender" value="1">
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