<?php
// PDO style

try {
  $db = new PDO("mysql:host=localhost;dbname=familydb;port=8889","root","root");
  $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  $db->exec("SET NAMES 'utf8'");
} catch (Exception $e){
  echo 'Could not connect to the database.105';
  exit();
}


function example(){
  $var = 1;
  $var2 = 1000;

$hold = "";
try{
  $results = $db->prepare("SELECT * FROM articles WHERE article_id = ? AND user_id = ?");
  $results->bindParam(1,$var);
  $results->bindParam(2,$var2);
  $results->execute();
  $hold = $results->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
  echo "Data could not be retrieved from the database.";
  exit();
}

  foreach($hold as $value){
    echo $value['article_id'];
    echo '<br>';
    echo $value['user_id'];
    echo '<br>';
    echo $value['title'];
    echo '<br>';
    echo $value['summary'];
    echo '<br>';
  }
}

?>
