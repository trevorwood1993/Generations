<?php 
include($_SERVER["DOCUMENT_ROOT"] . "/inc/header.php");
include($_SERVER["DOCUMENT_ROOT"] . "/inc/database.php");
$user_id = 1;
?>

<?php
$hold = "";
try{
  $results = $db->prepare("SELECT * FROM gamesave WHERE user_id = ?");
  $results->bindParam(1,$user_id);
  $results->execute();
  $hold = $results->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
  echo "Data could not be retrieved from the database.";
  exit();
}

?>
<div class="mainIndexDiv">
	<h1>Play Generations</h1>
	<div class="homeDiv">
		<form method="post" action="/newgame.php">
			<h4>Pick a faction to play as</h4>
			<select name="factiontype"> 
				<option value="Romans">Romans</option>
			</select>
			<h4>Name this game</h4>
			<input name="savename" type="text">
			<input type="submit" value="Play">
		</form>
	</div>
	<div class="homeDiv">
		<form action="/play.php" method="get">
			<h4>Load a game</h4>
			<select name="id">
				<?php 
				foreach ($hold as $value) {
					$id 						= $value['id'];
					$leaderid 			= $value['leaderid'];
					$savename				= $value['savename'];
					$factiontype 		= $value['factiontype'];
					echo '<option value="'.$id.'">'.$savename.':'.$factiontype.'</option>';
				}
				?>
			</select>
			<input name="load" type="submit" value="Load">
			<!-- <input name="delete" type="submit" value="Delete"> -->
		</form>
	</div>
	<div style="clear:both;"></div>
</div>


<?php 
include($_SERVER["DOCUMENT_ROOT"] . "/inc/footer.php");
?>






