<?php
// $GLOBALS['globalCurrentLinkNumber'] = 1;

function loadFamily($fatherid,$motherid,$db,$gameyear){
	
	try{
	  $results = $db->prepare("SELECT * FROM people WHERE fatherid = ? AND motherid = ? ORDER BY dob");
	  $results->bindParam(1,$fatherid);
	  $results->bindParam(2,$motherid);
	  $results->execute();
	  $hold = $results->fetchAll(PDO::FETCH_ASSOC);
	} catch (Exception $e) {
	  echo "Data could not be retrieved from the database.";
	  exit();
	}
	$counter = 1;
	$sizeofhold = count($hold);
	foreach ($hold as $value) {
		$charid 			= $value['id'];
		$firstname 		= $value['firstname'];
		$middlename 	= $value['middlename'];
		$lastname 		= $value['lastname'];
		$dob 					= $value['dob']+0;
		$portrait 		= $value['portrait'];
		$gender 			= $value['gender'];
		$bio 					= $value['bio'];
		$traits 			= $value['traits'];
		$fatherid 		= $value['fatherid'];
		$motherid 		= $value['motherid'];
		$spouseid 		= $value['spouseid'];
		$children 		= $value['children'];
		$fertility 		= $value['fertility'];
		$alive 				= $value['alive'];
		$deathyear 		= $value['deathyear']+0;
		$deathdesc 		= $value['deathdesc'];
		$gameid 			= $value['gameid'];
		$lineLink 		= $value['linelinknumber'];

		if($spouseid != ""){
			try{
			  $results = $db->prepare("SELECT * FROM people WHERE spouseid = ?");
			  $results->bindParam(1,$charid);
			  $results->execute();
			  $hold2 = $results->fetchAll(PDO::FETCH_ASSOC);
			} catch (Exception $e) {
			  echo "Data could not be retrieved from the database.";
			  exit();
			}

			$charid2 			= $hold2[0]['id'];
			$firstname2 	= $hold2[0]['firstname'];
			$middlename2 	= $hold2[0]['middlename'];
			$lastname2 		= $hold2[0]['lastname'];
			$dob2 				= $hold2[0]['dob']+0;
			$portrait2 		= $hold2[0]['portrait'];
			$gender2 			= $hold2[0]['gender'];
			$bio2					= $hold2[0]['bio'];
			$traits2 			= $hold2[0]['traits'];
			$fatherid2 		= $hold2[0]['fatherid'];
			$motherid2 		= $hold2[0]['motherid'];
			$spouseid2		= $hold2[0]['spouseid'];
			$children2 		= $hold2[0]['children'];
			$fertility2 	= $hold2[0]['fertility'];
			$alive2 			= $hold2[0]['alive'];
			$deathyear2 	= $hold2[0]['deathyear']+0;
			$deathdesc2 	= $hold2[0]['deathdesc'];
			$gameid2 			= $hold2[0]['gameid'];

			$age2 			= $gameyear - $dob2;
			$deathage2 	= $deathyear2 - $dob2;
		}

	// 	// $gameyear;
		$age 			= $gameyear - $dob; 
		$deathage = $deathyear - $dob;
		
	// 	// <div class="parentLinkBig lineLinkStart1"></div>
		$executionBirthOrder = 0; //muahahahahahahah
		$currentLinkNumber = 1;

		if($counter == 1){//first
			$lineLocation = "lineLinkStart";
			$executionBirthOrder = 1;
		}else{//last
			$lineLocation = "lineLinkEnd";
			$executionBirthOrder = 1;
		}

		if($gender == 1){//male
			if($portrait <= 9){
				$portrait = "00".$portrait;
			}elseif($portrait <= 99){
				$portrait = "0".$portrait;
			}
			if($alive == 1){//alive
				if($age >= 50){
					//old
					$srcportrait = '<div class="parentLinkBig';
					if($executionBirthOrder == 1){
						$srcportrait  .= " ".$lineLocation.$lineLink;
						$executionBirthOrder = 0;
					}
					$srcportrait .='"></div><img class="bigimg" src="/img/roman/old/'.$portrait.'.png">';//male
				}elseif($age >= 14){
					//young
					$srcportrait = '<div class="parentLinkBig';
					if($executionBirthOrder == 1){
						$srcportrait  .= " ".$lineLocation.$lineLink;
						$executionBirthOrder = 0;
					}
					$srcportrait .='"></div><img class="bigimg" src="/img/roman/young/'.$portrait.'.png">';//male
				}else{
					//male child
					$srcportrait = '<div class="parentLinkSmall';
					if($executionBirthOrder == 1){
						$srcportrait  .= " ".$lineLocation.$lineLink;
						$executionBirthOrder = 0;
					}
					$srcportrait .='"></div><img class="smallimg" src="/img/roman/family/son.png">';//male
				}
			}else{//dead
				if($age >= 14 && $deathage >= 14){
					//dead portrait male
					$srcportrait = '<div class="parentLinkBig';
					if($executionBirthOrder == 1){
						$srcportrait  .= " ".$lineLocation.$lineLink;
						$executionBirthOrder = 0;
					}
					$srcportrait .='"></div><img class="bigimg" src="/img/roman/dead/'.$portrait.'.png">';//male
				}else{
					//male child dead
					$srcportrait = '<div class="parentLinkSmall';
					if($executionBirthOrder == 1){
						$srcportrait  .= " ".$lineLocation.$lineLink;
						$executionBirthOrder = 0;
					}
					$srcportrait .='"></div><img class="smallimg" src="/img/roman/family/dead/son.png">';//male
				}
			}
			if($alive2 == 1){//alive
				if($age2 >= 14){
					$srcportrait2 = '<img class="smallimg" src="/img/roman/family/wife.png">';//female
				}else{
					$srcportrait2 = '<img class="smallimg" src="/img/roman/family/daughter.png">';//female
				}
			}else{//dead
				if($age2 >= 14 && $deathage2 >= 14){
					$srcportrait2 = '<img class="smallimg" src="/img/roman/family/dead/wife.png">';//female
				}else{
					$srcportrait2 = '<img class="smallimg" src="/img/roman/family/dead/daughter.png">';//female
				}
			}

		}else{
			if($portrait2 <= 9){
				$portrait2 = "00".$portrait2;
			}elseif($portrait2 <= 99){
				$portrait2 = "0".$portrait2;
			}
			if($alive2 == 1){//alive
				if($age2 >= 50){
					//old
					$srcportrait2 = '<img class="bigimg" src="/img/roman/old/'.$portrait2.'.png">';//male
				}elseif($age2 >= 14){
					//young
					$srcportrait2 = '<img class="bigimg" src="/img/roman/young/'.$portrait2.'.png">';//male
				}else{
					//male child
					$srcportrait2 = '<img class="smallimg" src="/img/roman/family/son.png">';//male
				}
			}else{//dead
				if($age2 >= 14 && $deathage2 >= 14){
					//dead portrait male
					$srcportrait2 = '<img class="bigimg" src="/img/roman/dead/'.$portrait2.'.png">';//male
				}else{
					//male child dead
					$srcportrait2 = '<img class="smallimg" src="/img/roman/family/dead/son.png">';//male
				}
			}
			if($alive == 1){//alive
				if($age >= 14){
					$srcportrait = '<div class="parentLinkSmall';
					if($executionBirthOrder == 1){
						$srcportrait  .= " ".$lineLocation.$lineLink;
						$executionBirthOrder = 0;
					}
					$srcportrait .='"></div><img class="smallimg" src="/img/roman/family/wife.png">';//female
				}else{
					$srcportrait = '<div class="parentLinkSmall';
					if($executionBirthOrder == 1){
						$srcportrait  .= " ".$lineLocation.$lineLink;
						$executionBirthOrder = 0;
					}
					$srcportrait .='"></div><img class="smallimg" src="/img/roman/family/daughter.png">';//female
				}
			}else{//dead
				if($age >= 14 && $deathage >= 14){
					$srcportrait = '<div class="parentLinkSmall';
					if($executionBirthOrder == 1){
						$srcportrait  .= " ".$lineLocation.$lineLink;
						$executionBirthOrder = 0;
					}
					$srcportrait .='"></div><img class="smallimg" src="/img/roman/family/dead/wife.png">';//female
				}else{
					$srcportrait = '<div class="parentLinkSmall';
					if($executionBirthOrder == 1){
						$srcportrait  .= " ".$lineLocation.$lineLink;
						$executionBirthOrder = 0;
					}
					$srcportrait .='"></div><img class="smallimg" src="/img/roman/family/dead/daughter.png">';//female
				}
			}
		}

		if($gender == 1){//family member = male
			$data.=	
			'<li>
				<div class="personOrCouple">'.
							// <div style="position:absolute;z-index:100;">'.$currentLinkNumber.'</div>
					'<div class="links';
					if($alive == 1){ $data .= " aliveDisaster";}
					$data .= '">'.$srcportrait;
						if($spouseid != ""){ $data.= '<div class="coupleLink"></div>'; }
						if($children >= 1){ 
							// $temp = $currentLinkNumber;
							// $temp = $temp+1;
							$temp = 0;
							$data.= '<div class="coupleFamilyLink lineLinkFamily'.$temp.'"></div>';
						}

						$data.=	
						'<div class="charinfo" style="display:none;">
							<input type="text" class="personid" value="'.$charid.'">
							<input type="text" class="firstname" value="'.$firstname.'">
							<input type="text" class="middlename" value="'.$middlename.'">
							<input type="text" class="lastname" value="'.$lastname.'">
							<input type="text" class="dob" value="'.$dob.'">
							<input type="text" class="portrait" value="'.$portrait.'">
							<input type="text" class="gender" value="1">
							<input type="text" class="children" value="'.$children.'">';
							if($spouseid == "" && $age >= 14 && $alive == 1){
								$data.= '<input type="text" class="bachelor" value="'.$charid.'">';
							} 
							$data.=
							'<input type="text" class="alive" value="'.$alive.'">
							<input type="text" class="bio" value="'.$bio.'">
							<input type="text" class="deathyear" value="'.$deathyear.'">
							<input type="text" class="deathdesc" value="'.$deathdesc.'">
							<input type="text" class="fertility" value="'.$fertility.'">
						</div>
					</div>';

					if($spouseid != ""){
					$data.=
					'<div class="links';
					if($alive2 == 1){ $data .= " aliveDisaster";}
					$data .= '">'.$srcportrait2.'
						<div class="charinfo" style="display:none;">
							<input type="text" class="personid" value="'.$charid2.'">
							<input type="text" class="firstname" value="'.$firstname2.'">
							<input type="text" class="middlename" value="'.$middlename2.'">
							<input type="text" class="lastname" value="'.$lastname2.'">
							<input type="text" class="dob" value="'.$dob2.'">
							<input type="text" class="gender" value="2">
							<input type="text" class="alive" value="'.$alive2.'">
							<input type="text" class="bio" value="'.$bio2.'">
							<input type="text" class="children" value="'.$children2.'">
							<input type="text" class="deathyear" value="'.$deathyear2.'">
							<input type="text" class="deathdesc" value="'.$deathdesc2.'">
							<input type="text" class="fertility" value="'.$fertility2.'">
						</div>
					</div>';
					}
				$data.=
				'</div>
			';
		}else{//family member = female
			$data.=	
			'<li>
				<div class="personOrCouple">';
				// $data.= '<div style="position:absolute;z-index:100;">'.$currentLinkNumber.'</div>';
					if($spouseid != ""){
						$data.=
						'<div class="links';
						if($alive2 == 1){ $data .= " aliveDisaster";}
						$data .='">
							'.$srcportrait2.'
							<div class="coupleLink"></div>';
							if($children2 >= 1){ 
								$temp = $currentLinkNumber;
								$temp = $temp+1;
								$data.= '<div class="coupleFamilyLink lineLinkFamily'.$temp.'"></div>';
							}
						$data.=
							'<div class="charinfo" style="display:none;">
								<input type="text" class="personid" value="'.$charid2.'">
								<input type="text" class="firstname" value="'.$firstname2.'">
								<input type="text" class="middlename" value="'.$middlename2.'">
								<input type="text" class="lastname" value="'.$lastname2.'">
								<input type="text" class="dob" value="'.$dob2.'">
								<input type="text" class="portrait" value="'.$portrait2.'">
								<input type="text" class="gender" value="1">
								<input type="text" class="children" value="'.$children2.'">
								<input type="text" class="alive" value="'.$alive2.'">
								<input type="text" class="bio" value="'.$bio2.'">
								<input type="text" class="deathyear" value="'.$deathyear2.'">
								<input type="text" class="deathdesc" value="'.$deathdesc2.'">
								<input type="text" class="fertility" value="'.$fertility2.'">
							</div>
						</div>';
					}
					$data.=
					'<div class="links';
					if($alive == 1){ $data .= " aliveDisaster";}
					$data.= '">'.$srcportrait.'

						<div class="charinfo" style="display:none;">
							<input type="text" class="personid" value="'.$charid.'">
							<input type="text" class="firstname" value="'.$firstname.'">
							<input type="text" class="middlename" value="'.$middlename.'">
							<input type="text" class="lastname" value="'.$lastname.'">
							<input type="text" class="dob" value="'.$dob.'">
							<input type="text" class="gender" value="2">';

							if($spouseid == "" && $age >=14 && $alive == 1){
								$data.= '<input type="text" class="bachelorette" value="'.$charid.'">';
							} 

							$data.=
							'<input type="text" class="alive" value="'.$alive.'">
							<input type="text" class="bio" value="'.$bio.'">
							<input type="text" class="children" value="'.$children.'">
							<input type="text" class="deathyear" value="'.$deathyear.'">
							<input type="text" class="deathdesc" value="'.$deathdesc.'">
							<input type="text" class="fertility" value="'.$fertility.'">
						</div>
					</div>
				</div>
			';
		}



		if($children >= 1 OR $children2 >= 1){
			if($gender == 1){
				// $currentLinkNumber++;
				$data .= "<ul>";
				$data .= loadFamily($charid,$charid2,$db,$gameyear);//father//mother
				$data .= "</ul>";
			}else{
				// $currentLinkNumber++;
				$data .= "<ul>";
				$data .= loadFamily($charid2,$charid,$db,$gameyear);//father//mother
				$data .= "</ul>";
			}
		}
		$data.= "</li> ";

		$counter++;
	}//foreach
	// $currentLinkNumber++;
	// $currentLinkNumber
	// $arrayData = array($data,$lineLink);
	return $data;
}
?>