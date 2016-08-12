<?php
if(isset($_GET['delete'])){
	echo 'delete';
	exit();
}

?>



<?php 
$loadtime = microtime(true); // Gets microseconds
include($_SERVER["DOCUMENT_ROOT"] . "/inc/header.php");
include($_SERVER["DOCUMENT_ROOT"] . "/inc/database.php");

$user_id = 1;
$gameid = intval($_GET['id']);


include($_SERVER["DOCUMENT_ROOT"] . "/loadfamily.php");

echo '<input class="gameid" type="hidden" value="'.$gameid.'">';
?>
<div class="grayScreen">
	<div class="grayScreenSub"></div>
	<div class="grayScreenLoading"><img src="/img/loading.gif"></div>
</div>

<?php

try{
  $results = $db->prepare("SELECT * FROM gamesave WHERE id = ? AND user_id = ?");
  $results->bindParam(1,$gameid);
  $results->bindParam(2,$user_id);
  $results->execute();
  $hold = $results->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
  echo "Data could not be retrieved from the database.";
  exit();
}
if($hold[0]['leaderid'] == ""){
	echo 'leaderid is empty';
	exit();
}
$leaderid = $hold[0]['leaderid'];
$gameyear = $hold[0]['gameyear']+0;



try{
  $results = $db->prepare("SELECT * FROM people WHERE id = ?");
  $results->bindParam(1,$leaderid);
  $results->execute();
  $hold = $results->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
  echo "Data could not be retrieved from the database.";
  exit();
}
$leaderfirstname 			= $hold[0]['firstname'];
$leadermiddlename 		= $hold[0]['middlename'];
$leaderlastname 			= $hold[0]['lastname'];
$leaderdob						= $hold[0]['dob']+0;
$leaderportrait 			= $hold[0]['portrait'];
$leadertraits					= $hold[0]['traits'];
$leaderspouse					= $hold[0]['spouseid'];
$leaderchildren 			= $hold[0]['children'];
$leaderfertility 			= $hold[0]['fertility'];
$leaderalive					= $hold[0]['alive'];
$leaderbio						= $hold[0]['bio'];
$leaderdeathyear			= $hold[0]['deathyear']+0;
$leaderdeathdesc			= $hold[0]['deathdesc'];



if($leaderspouse != ""){
	try{
	  $results = $db->prepare("SELECT * FROM people WHERE id = ?");
	  $results->bindParam(1,$leaderspouse);
	  $results->execute();
	  $hold = $results->fetchAll(PDO::FETCH_ASSOC);
	} catch (Exception $e) {
	  echo "Data could not be retrieved from the database.";
	  exit();
	}
	$spousefirstname 		= $hold[0]['firstname'];
	$spousemiddlename 	= $hold[0]['middlename'];
	$spouselastname 		= $hold[0]['lastname'];
	$spousedob 					= $hold[0]['dob']+0;
	$spousealive 				= $hold[0]['alive'];
	$spousebio 					= $hold[0]['bio'];
	$spousechildren 		= $hold[0]['children'];
	$spousedeathyear 		= $hold[0]['deathyear']+0;
	$spousedeathdesc 		= $hold[0]['deathdesc'];
	$spousefertility		= $hold[0]['fertility'];

	if($spousealive == 1){
		//alive
		$spouseportrait = "/img/roman/family/wife.png";
	}else{
		//dead
		$spouseportrait = "/img/roman/family/dead/wife.png";
	}
}

	
if($leaderportrait <= 9){
	$leaderportrait = "00".$leaderportrait;
}elseif($leaderportrait <= 99){
	$leaderportrait = "0".$leaderportrait;
}
$checkleaderage = $gameyear - $leaderdob; 
if($leaderalive == 0){
	//dead
	$age = "dead";
}elseif($checkleaderage < 50){
	//young
	$age = "young";
}else{
	//old
	$age = "old";
}
$leaderportraitsrc = '/img/roman/'.$age.'/'.$leaderportrait.'.png';


if($leaderchildren >= 1){
	$data = loadFamily($leaderid,$leaderspouse,$db,$gameyear,$currentLinkNumber);//father//mother
}


try{
  $results = $db->prepare("SELECT MAX(linkid) FROM linknumbers WHERE game_id = ?");
  $results->bindParam(1,$gameid);
  $results->execute();
  $hold = $results->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
  echo "Data could not be retrieved from the database.";
  exit();
}
$lineLink = $hold[0]['MAX(linkid)']+0;

echo '<input class="currentLinkNumber" type="hidden" value="'.$lineLink.'">';



?>
<div class="controlPanel">
	<div class="CPOption autoChildMarriage highlightoff">
		<input class="autoChildMarriageRange" type="range" min="0" max="10" value="5">
		<p>BirthRate</p><!--  Formerly "Child + Marriage" -->
		<div><input class="autoChildMarriageNumber" type="number" value="5" min="0" max="10"></div>
	</div>
	<div class="CPOption autoNaturalDisaster highlightoff">
		<input class="autoNaturalDisasterRange" type="range" min="0" max="10" value="0">
		<p>Natural Disasters</p>
		<div><input class="autoNaturalDisasterNumber" type="number" value="0" min="0" max="10"></div>
	</div>

	<button class="endTurnButton highlightoff" type="button">End Turn</button>
	<p style="float:right; margin:11px 5px 0 0;">Year: <span class="year"><?php echo $gameyear;?></span></p>	
	<div style="clear:both;"></div>
</div>
<div class="personInfoMainToggle highlightoff">Person Information</div>
<div class="factionAnnoucementsToggle highlightoff">Faction Annoucements</div>
<div class="nameShower">
	<div class="charName">
		<p class="charNameSub">test name test</p>
	</div>
	<div class="charDob">
		<p class="charDobSub">Born: </p><span>180</span>
	</div>
	<div class="charAge">
		<p class="charAgeSub">Age: </p><span>20</span>
	</div>
</div>
<div class="factionAnnoucements highlightoff" style="display:none;">
	<h4 class="marriagesHeader">Marriages</h4>
	<ul class="marriages">
		<li value="1">Main Leader</li>
		<li value="3364">Aulus Quintinus Volsinius</li>
		<li value="3131">Octavius Sextius Maxentius</li>
	</ul>
	<h4 class="birthsHeader">Births</h4>
	<ul class="births">
		<li value="3060">Decimus Silvanus</li>
	</ul>
	<h4 class="deathsHeader">Deaths</h4>
	<ul class="deaths">
		<li value="3094">Lentulus Volsinius</li>
	</ul>
	<p class="noFactionUpdates">No Faction Updates</p>
</div>
<div class="personInfoMain" style="display:none;">
	<button class="modifyPersonButton" type="button">Modify</button>
	<h4 class="tableFullname">Cornelius Silvanus Maxentius</h4>
	<img src="/img/roman/young/000.png">
	<table>
		
		<tr class="tableBorn">
			<th>Born:</th>
			<td>180</td>
		</tr>
		<tr class="tableAge">
			<th>Age:</th>
			<td>25</td>
		</tr>
		<tr class="tableDied">
			<th>Died:</th>
			<td>250</td>
		</tr>
		<tr class="tableChildren">
			<th>Children:</th>
			<td>5</td>
		</tr>
		<tr class="tableFertility">
			<th>Fertility:</th>
			<td>4</td>
		</tr>
		<tr class="tablePersonid">
			<th>Personid:</th>
			<td>1</td>
		</tr>
	</table>
	<div style="clear:both"></div>
	<div class="persionBios">
		<div class="persionBiosDeath" style="display:none;">
			<h4>Death Cause</h4>	
			<p></p>
		</div>
		<div class="persionBiosBio">
			<h4>Bio</h4>
			<p></p>
		</div>
	</div>
	<div class="modifyPersonDiv" style="display:none;">
		<form class="modifyPersonForm" action="/modifyPerson.php" method="post">
			<table>
				<tr style="display:none;">
					<th>Firstname: </th>
					<td><input class="modifyPersonid" name="personid" type="text"></td>
				</tr>
				<tr>
					<th>Firstname: </th>
					<td><input class="modifyFirstname" name="firstname" type="text"></td>
				</tr>
				<tr>
					<th>Middlename: </th>
					<td><input class="modifyMiddlename" name="middlename" type="text"></td>
				</tr>
				<tr>
					<th>Lastname: </th>
					<td><input class="modifyLastname" name="lastname" type="text"></td>
				</tr>
				<tr>
					<th>Dob: </th>
					<td><input class="modifyDob" name="dob" type="text"></td>
				</tr>
				<tr>
					<th>Portrait: </th>
					<td><input class="modifyPortrait" name="portrait" type="text"></td>
				</tr>
				<tr>
					<th>Gender: </th>
					<td><input class="modifyGender" name="gender" type="text"></td>
				</tr>
				<tr>
					<th>Fertility: </th>
					<td><input class="modifyFertility" name="fertility" type="text"></td>
				</tr>
				<tr>
					<th>Alive: </th>
					<td><input class="modifyAlive" name="alive" type="text"></td>
				</tr>		
				<tr>
					<th>Bio: </th>
					<td><textarea class="modifyBio" name="bio"></textarea></td>
				</tr>
				<tr>
					<th>Deathyear: </th>
					<td><input class="modifyDeathyear" name="deathyear" type="text"></td>
				</tr>		
				<tr>
					<th>Deathdesc: </th>
					<td><textarea class="modifyDeathdesc" name="deathdesc"></textarea></td>
				</tr>	
				<tr>
					<th></th>
					<td><input type="submit"></td>
				</tr>		
				<tr>
					<th></th>
					<td><button type="button" onclick="marryPerson()">Marry this person</button></td>
				</tr>	
				<tr>
					<th>
						<select class="newbabygender">
							<option value="1">Male</option>
							<option value="2">Female</option>
						</select>
					</th>
					<td><button type="button" onclick="havechild()">Have new child</button></td>
				</tr>	
				<tr>
					<th></th>
					<td><button type="button" onclick="deleteperson()">Delete this person</button></td>
				</tr>	
				
			</table>
		</form>
	</div>
</div>
<script type="text/javascript">
function deleteperson(){
		var personid1 = $('.modifyPersonid').val();
		if(confirm("Delete this person?: "+personid1)){
			// alert("yes");

			$.ajax({
	      method: "POST",
	      url: "../../deletePerson.php",
	      data: {personid: personid1,},
	      success: function(data){
	        //success
	        // alert("success");
	        $('.personInfoMain').slideUp();
	      }
	    });
		}
	}
	function havechild(){
		// alert("yep, havent written the code for this yet");

		var tablePersonid = $('.tablePersonid td').text(),
				personOrCoupleClass = $('.personid[value="'+tablePersonid+'"]');
				personOrCouple = personOrCoupleClass.parent().parent().parent();
				fatherid 	= personOrCouple.find(".links:nth-child(1) .personid").val(),
				motherid 	= personOrCouple.find(".links:nth-child(2) .personid").val();
				lastname 	= personOrCouple.find(".links:nth-child(1) .lastname").val(),
				gender 		= $('.newbabygender').val(),
				currentLinkNumber = $('.currentLinkNumber').val();

		alert(currentLinkNumber+"Keep an eye on this, might corrupt linelink?");
		makebaby(fatherid,motherid,lastname,gender,currentLinkNumber);
	}
	function marryPerson(){
		var tablePersonid = $('.tablePersonid td').text();
		marriagecheck(tablePersonid);
	}
</script>


<script type="text/javascript">
	$('.factionAnnoucementsToggle').on("click",function(){
		$('.factionAnnoucements').slideToggle(250);
	});
	$('.personInfoMainToggle').on("click",function(){
		$('.personInfoMain').slideToggle(250);
	});
	$('.modifyPersonButton').on("click",function(){
		$('.modifyPersonDiv').slideToggle(250);
	});
	$(".modifyPersonForm").submit(function( event ) {
		// alert( "Handler for .submit() called." );
		event.preventDefault();
		var personid1			= $('.modifyPersonid').val(),
				firstname1 		= $('.modifyFirstname').val(),
				middlename1 	= $('.modifyMiddlename').val(),
				lastname1 		= $('.modifyLastname').val(),
				dob1 					= $('.modifyDob').val(),
				portrait1 		= $('.modifyPortrait').val(),
				gender1				= $('.modifyGender').val(),
				fertility1		= $('.modifyFertility').val(),
				alive1				= $('.modifyAlive').val(),
				bio1					= $('.modifyBio').val(),
				deathyear1 		= $('.modifyDeathyear').val(),
				deathdesc1 		= $('.modifyDeathdesc').val();

		var personidclass = $('.personid').filter(function(){ return this.value==personid1 }),
				charinfo 			= personidclass.parent();

		charinfo.find('.firstname').val(firstname1);
		charinfo.find('.middlename').val(middlename1);
		charinfo.find('.lastname').val(lastname1);
		charinfo.find('.dob').val(dob1);
		charinfo.find('.portrait').val(portrait1);
		charinfo.find('.gender').val(gender1);
		charinfo.find('.fertility').val(fertility1);
		charinfo.find('.alive').val(alive1);
		charinfo.find('.bio').val(bio1);
		charinfo.find('.deathyear').val(deathyear1);
		charinfo.find('.deathdesc').val(deathdesc1);


		$.ajax({
      method: "POST",
      url: "../../modifyPerson.php",
      data: {personid: personid1, firstname:firstname1, middlename:middlename1, lastname:lastname1,
      	dob: dob1, portrait:portrait1, gender:gender1, fertility:fertility1,
      	alive:alive1, bio:bio1, deathyear: deathyear1, deathdesc:deathdesc1
      },
      success: function(data){
        //success
        // alert("success");
        $('.personInfoMain').slideUp();
      }
    });
	});
</script>

<div class="mainTree highlightoff">
	<ul class="starter"><!-- starter -->
		<li>
			<div class="personOrCouple">
				<div class="links">
					<?php 
					echo '<img class="bigimg" src="'.$leaderportraitsrc.'">'; 
					if($leaderspouse != ""){  echo '<div class="coupleLink"></div>'; }
					if($leaderchildren >= 1){ echo '<div class="coupleFamilyLink lineLinkFamily1"></div>';}
					?>
					<div class="charinfo" style="display:none;">
						<input type="text" class="personid" <?php echo 'value="'.$leaderid.'"';?>>
						<input type="text" class="firstname" <?php echo 'value="'.$leaderfirstname.'"';?>>
						<input type="text" class="middlename" <?php echo 'value="'.$leadermiddlename.'"';?>>
						<input type="text" class="lastname" <?php echo 'value="'.$leaderlastname.'"';?>>
						<input type="text" class="dob" <?php echo 'value="'.$leaderdob.'"';?>>
						<input type="text" class="portrait" <?php echo 'value="'.$leaderportrait.'"';?>>
						<input type="text" class="gender" value="1">
						<input type="text" class="children" <?php echo 'value="'.$leaderchildren.'"';?>>
						<?php if($leaderspouse == ""){
							echo '<input type="text" class="bachelor" value="'.$leaderid.'">';
						} ?>
						<input type="text" class="alive" <?php echo 'value="'.$leaderalive.'"';?>>
						<input type="text" class="bio" <?php echo 'value="'.$leaderbio.'"';?>>
						<input type="text" class="deathyear" <?php echo 'value="'.$leaderdeathyear.'"';?>>
						<input type="text" class="deathdesc" <?php echo 'value="'.$leaderdeathdesc.'"';?>>
						<input type="text" class="fertility" <?php echo 'value="'.$leaderfertility.'"';?>>

					</div>
				</div>
				<?php
				if($leaderspouse != ""){
				echo '<div class="links">
					<img class="smallimg" src="'.$spouseportrait.'">
					<div class="charinfo" style="display:none;">
						<input type="text" class="personid" value="'.$leaderspouse.'">
						<input type="text" class="firstname" value="'.$spousefirstname.'">
						<input type="text" class="middlename" value="'.$spousemiddlename.'">
						<input type="text" class="lastname" value="'.$spouselastname.'">
						<input type="text" class="dob" value="'.$spousedob.'">
						<input type="text" class="gender" value="2">
						<input type="text" class="children" value="'.$spousechildren.'">
						<input type="text" class="alive" value="'.$spousealive.'">
						<input type="text" class="bio" value="'.$spousebio.'">
						<input type="text" class="deathyear" value="'.$spousedeathyear.'">
						<input type="text" class="deathdesc" value="'.$spousedeathdesc.'">
						<input type="text" class="fertility" value="'.$spousefertility.'">
					</div>
				</div>';
				}
				?>
				<div style="clear:both;"></div>
			</div>
			<?php
			if($leaderchildren >= 1){
				echo '<ul>'.$data.'</ul>';
				// echo $data;
			}
		?>
		</li>
	</ul><!-- starter -->
</div><!-- mainTree -->



<script type="text/javascript">


	var element = $('.mainTree');

	$(function(){
	  var curDown = false,
	      curYPos = 0,
	      curXPos = 0;
	  $(element).mousemove(function(m){
	    if(curDown === true){
	     $(element).scrollTop($(element).scrollTop() + (curYPos - m.pageY)); 
	     $(element).scrollLeft($(element).scrollLeft() + (curXPos - m.pageX));
	    }
	  });
	  
	  $(element).mousedown(function(m){
	    curDown = true;
	    curYPos = m.pageY;
	    curXPos = m.pageX;
	    $('html,body').css('cursor','move');
	  });
	  
	  $(element).mouseup(function(){
	    curDown = false;
	    $('html,body').css('cursor','default');
	  });
	})


</script>



<?php 
include($_SERVER["DOCUMENT_ROOT"] . "/inc/footer.php");
// var_dump($data);
// echo '<div style="position:absolute;right:0%;bottom:0%;">Load Time: '.(microtime(true) - $loadtime).'s</div>';
?>












