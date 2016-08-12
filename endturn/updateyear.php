<?php 
include($_SERVER["DOCUMENT_ROOT"] . "/inc/database.php");
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$nextsemester 	= trim(htmlspecialchars($_POST['pNextsemester']));
	$gameid 				= intval($_POST['pGameid']);
	try{
	  $results = $db->prepare("UPDATE gamesave SET gameyear = ? WHERE id = ?");
	  $results->bindParam(1,$nextsemester);
	  $results->bindParam(2,$gameid);
	  $results->execute();
	} catch (Exception $e) {
	  echo "Data could not be retrieved from the database.";
	  exit();
	}
}
?>