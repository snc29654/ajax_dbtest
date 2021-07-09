<?php
header('Content-Type: text/html; charset=UTF-8');
$host = "localhost"; 
$user = "root"; 
$pass = ""; 
$dbname = "memo"; 
$dbtable = "kind"; 
//if(!$_POST['kind'] || !$_POST['contents']){exit("未入力あり");}

file_put_contents("../from_html.txt", $_POST['kind'] ."\n",FILE_APPEND);
file_put_contents("../from_html.txt", $_POST['contents']."\n",FILE_APPEND);

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
/*
try{

	$sql = "SET NAMES UTF8;";
    $stmh = $pdo->prepare($sql);
    $stmh->execute();

	$sql = "INSERT INTO `${dbtable}` SET kind = '${_POST['kind']}', contents = '${_POST['contents']}';";
    $stmh = $pdo->prepare($sql);
    $stmh->execute();


}catch(PDOException $Exception){
    die('接続エラー：' .$Exception->getMessage());
}

try{
    $pdo = new PDO(
        'mysql:host=localhost;dbname=memo;charset=utf8',
        'root',
        ''
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
}catch(PDOException $Exception){
    die('接続エラー：' .$Exception->getMessage());
}
*/
try{
    $sql = "SELECT * FROM memo.kind";
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
    
    echo strip_tags($row['id']);      echo " ";
    echo strip_tags($row['kind']);   echo " ";   
    }
?>
