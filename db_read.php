<?php
header('Content-Type: text/html; charset=UTF-8');
$host = "localhost"; 
$user = "root"; 
$pass = ""; 
$dbname = "memo"; 
$dbtable = "kind"; 

try{
	
	$dsn = "mysql:dbname=memo;host=localhost;charset=utf8;";

    $pdo = new PDO(
        'mysql:host=localhost;dbname=memo;charset=utf8',
        'root',
        ''
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

    if(strcmp($_POST['actionread'],"srch")==0){

        $sql = "SELECT * FROM memo.kind WHERE Contents LIKE '%" . $srch_word . "%'";

    }else if(strcmp($_POST['actionread'],"kindselect")==0){

        $sql = "SELECT * FROM memo.kind WHERE kind LIKE '%" . $kind . "%'";

    }else if(strcmp($_POST['actionread'],"readall")==0){

        $sql = "SELECT * FROM memo.kind";
    }else{
 
    }
    $stmh = $pdo->prepare($sql);
    $stmh->execute();
}catch(PDOException $Exception){
    die('接続エラー：' .$Exception->getMessage());
}
    while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
?>

<?php
	file_put_contents("../db_log.txt", $row['id']."\n",FILE_APPEND);
	file_put_contents("../db_log.txt", $row['kind']."\n",FILE_APPEND);
	file_put_contents("../db_log.txt", $row['contents']."\n",FILE_APPEND);
    
    echo strip_tags($row['kind']);      echo "\n";
    echo "*************************************\n";
    echo strip_tags($row['contents']);   echo "\n";   
    echo "*************************************\n";
    }
?>
