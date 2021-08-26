<?php

include('param.php');
header('Content-Type: text/html; charset=UTF-8');

try{
	

    $pdo = new PDO(
        $dsn,
        $user,
        $pass
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$pdo->query("SET NAMES UTF8;");


}catch(PDOException $Exception){
    die('接続できません：' .$Exception->getMessage());
}

$srch_word = $_POST['srch_word'];

$kind = $_POST['kind'];

try{



    if(strcmp($_POST['actionread'],"srchid")==0){

        $sql = "SELECT * FROM $dbtable WHERE id = '${_POST['srchid_value']}'" ;

    }else if(strcmp($_POST['actionread'],"srch")==0){

        $sql = "SELECT * FROM $dbtable WHERE Contents LIKE '%" . $srch_word . "%'";

    }else if(strcmp($_POST['actionread'],"kindselect")==0){

        $sql = "SELECT * FROM $dbtable WHERE kind LIKE '%" . $kind . "%'";

    }else if(strcmp($_POST['actionread'],"readall")==0){

        $sql = "SELECT * FROM $dbtable";
    }else{
 
    }


    $stmh = $pdo->prepare($sql);
    $stmh->execute();
}catch(PDOException $Exception){
    die('接続エラー：' .$Exception->getMessage());
}
file_put_contents("../id_mail.txt", "\n");


    while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
?>
<?php
    global $email_list;


	file_put_contents("../db_log.txt", $row['id']."\n",FILE_APPEND);
	file_put_contents("../db_log.txt", $row['kind']."\n",FILE_APPEND);
	file_put_contents("../db_log.txt", $row['contents']."\n",FILE_APPEND);
	file_put_contents("../db_log.txt", $row['answer']."\n",FILE_APPEND);

    $id = $row['id'];
    $contents = $row['contents'];
    $answer=$row['answer'];        
    echo "<table border =\"3\">";    
    echo "<tbody><tr><td>";echo "id=";echo strip_tags($row['id']);      echo "\n";echo "<br>";
    echo strip_tags($row['kind']);      echo "\n";echo "<br>";
    echo "<textarea name=\"contents\" rows=\"10\" cols=\"80\" style=\"background-color:#bde9ba\" id=\"contents\" placeholder=\"内容\" >$contents</textarea>";
    echo "<textarea name=\"answer\" rows=\"10\" cols=\"80\" style=\"background-color:#bde9ba\" id=\"answer\" placeholder=\"回答\" >$answer</textarea>";
    echo "<img src=\"../jpg/$id.jpg\" width=\"150\" height=\"135\"/>";
    echo "</tbody></tr></td>";

    $email = $row['email'];    
    $email_list = array($id => $email);
	file_put_contents("../id_mail.txt", $id.":".$email."\n",FILE_APPEND);



    }
?>
