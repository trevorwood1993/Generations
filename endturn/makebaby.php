<?php 
include($_SERVER["DOCUMENT_ROOT"] . "/inc/database.php");
if($_SERVER['REQUEST_METHOD'] == "POST"){

	$fatherid 				= intval($_POST['pFatherid']);
	$motherid 				= intval($_POST['pMotherid']);
	$fatherlastname 	= trim(htmlspecialchars($_POST['pFatherlastname']));
	$gender 					= intval($_POST['pGender']);
	$currentyear 			= trim(htmlspecialchars($_POST['pCurrentyear']));
	$gameid 					= intval($_POST['pGameid']);
	$newLineLink  		= intval($_POST['pPassLink']);


	include($_SERVER["DOCUMENT_ROOT"] . "/namelookup.php");

	if($gender == 1){//male
		$malenameSize	 		= sizeof($romanFirstnames) - 1;

		$firstnameNumber 	= rand(0, $malenameSize);
		$middlenameNumber = rand(0, $malenameSize);
		while($firstnameNumber == $middlenameNumber){
			$middlenameNumber = rand(0, $malenameSize);
		}

		$firstname 				= $romanFirstnames[$firstnameNumber];
		$middlename 			= $romanFirstnames[$middlenameNumber];
		$portrait 				= rand(0,478);
	}else{//female
		$femalenameSize	 	= sizeof($romanWomennames) - 1;

		$firstnameNumber 	= rand(0, $femalenameSize);
		$middlenameNumber = rand(0, $femalenameSize);
		while($firstnameNumber == $middlenameNumber){
			$middlenameNumber = rand(0, $femalenameSize);
		}
		
		$firstname 				= $romanWomennames[$firstnameNumber];
		$middlename 			= $romanWomennames[$middlenameNumber];
		$portrait 				= "";
	}
	$fertility = rand(0,7);
	if($fertility != 4){
		$fertility = rand(0,7);
	}
	if($fertility <= 3){
		$fertility = rand(0,4);
	}
	if($fertility == 0){
		$fertility = rand(0,1);
		// if($fertility == 0){
		// 	$fertility = rand(0,1);
		// }
	}
	if($fertility >= 5){
		$fertility = rand(4,7);
	}

	try{
	  $results = $db->prepare("SELECT * FROM linknumbers WHERE fatherid = ? AND motherid = ? AND game_id = ?");
	  $results->bindParam(1,$fatherid);
	  $results->bindParam(2,$motherid);
	  $results->bindParam(3,$gameid);
	  $results->execute();
	  $hold = $results->fetchAll(PDO::FETCH_ASSOC);
	} catch (Exception $e) {
	  echo "Data could not be retrieved from the database.1";
	  exit();
	}

	if($hold[0]['linkid'] == ""){
		try{
		  $results = $db->prepare("INSERT INTO linknumbers(game_id,linkid,personid,fatherid,motherid)VALUES(?,?,0,?,?)");
		  $results->bindParam(1,$gameid);
		  $results->bindParam(2,$newLineLink);
		  $results->bindParam(3,$fatherid);
		  $results->bindParam(4,$motherid);
		  $results->execute();
		} catch (Exception $e) {
		  echo "Data could not be retrieved from the database.2";
		  exit();
		}
		$linknumber = $newLineLink;
		$lineLink = "lineLinkStart".$linknumber;
	}else{
		$linknumber = $hold[0]['linkid'];
		$lineLink = "lineLinkEnd".$linknumber;
	}

	try{
	  $results = $db->prepare("INSERT INTO people 
	  	(firstname, middlename, lastname, dob, portrait, gender, fatherid, motherid, fertility, gameid, linelinknumber)
	  	VALUES(?,?,?,?,?,?,?,?,?,?,?)");
	  $results->bindParam(1,$firstname);
	  $results->bindParam(2,$middlename);
	  $results->bindParam(3,$fatherlastname);
	  $results->bindParam(4,$currentyear);
	  $results->bindParam(5,$portrait);
	  $results->bindParam(6,$gender);
	  $results->bindParam(7,$fatherid);
	  $results->bindParam(8,$motherid);
	  $results->bindParam(9,$fertility);
	  $results->bindParam(10,$gameid);
	  $results->bindParam(11,$linknumber);
	  $results->execute();
	  $lastId = $db->lastInsertId();
	} catch (Exception $e) {
	  echo "Data could not be retrieved from the database.3";
	  exit();
	}
	try{
	  $results = $db->prepare("UPDATE linknumbers SET personid = ? WHERE fatherid = ? OR motherid = ?");
	  $results->bindParam(1,$lastId);
	  $results->bindParam(2,$fatherid);
	  $results->bindParam(3,$motherid);
	  $results->execute();
	} catch (Exception $e) {
	  echo "Data could not be retrieved from the database.4";
	  exit();
	}
	try{
	  $results = $db->prepare("UPDATE people SET children = children+1 WHERE id = ? OR id = ?");
	  $results->bindParam(1,$fatherid);
	  $results->bindParam(2,$motherid);
	  $results->execute();
	} catch (Exception $e) {
	  echo "Data could not be retrieved from the database.5";
	  exit();
	}
	if($portrait <= 9){
		$portrait = "00".$portrait;
	}elseif($portrait <= 99){
		$portrait = "0".$portrait;
	}
	if($gender == 1){//male
		$imgsrc = "../../img/roman/family/son.png";
	}else{//female
		$imgsrc = "../../img/roman/family/daughter.png";
	}

	$data =
	'<li>
		<div class="personOrCouple">
			<div class="links aliveDisaster">
				<div class="parentLinkSmall '.$lineLink.'"></div>
				<img class="smallimg" src="'.$imgsrc.'">
				<div class="charinfo" style="display:none;">
					<input type="text" class="personid" value="'.$lastId.'">
					<input type="text" class="firstname" value="'.$firstname.'">
					<input type="text" class="middlename" value="'.$middlename.'">
					<input type="text" class="lastname" value="'.$fatherlastname.'">
					<input type="text" class="dob" value="'.$currentyear.'">
					<input type="text" class="portrait" value="'.$portrait.'">
					<input type="text" class="gender" value="'.$gender.'">
					<input type="text" class="children" value="0">
					<input type="text" class="alive" value="1">
					<input type="text" class="bio" value="">
					<input type="text" class="deathyear" value="">
					<input type="text" class="deathdesc" value="">
					<input type="text" class="fertility" value="'.$fertility.'">
				</div>
			</div>
		</div>
	</li>';
	
	$fullname = $firstname." ".$middlename." ".$fatherlastname;
	$array = array(
		'value1' => $fullname, 
		'value2' => $data,
		'value3' => $lastId,
		'value4' => $newLineLink
	);
	echo json_encode($array);


	// $array = array(
	// 	'value1' => 'test1', 
	// 	'value2' => 'test2',
	// 	'value3' => 'test3'
	// );
	// echo json_encode($array);


}
?>