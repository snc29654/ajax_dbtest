<?php
header('Content-Type: text/html; charset=UTF-8');
$host = "localhost"; 
$user = "root"; 
$pass = ""; 
$dbname = "memo"; 
$dbtable = "kind_t"; 

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



    if(strcmp($_POST['actionread'],"srchid")==0){

        $sql = "SELECT * FROM memo.kind_t WHERE id = '${_POST['srchid_value']}'" ;

    }else if(strcmp($_POST['actionread'],"srch")==0){

        $sql = "SELECT * FROM memo.kind_t WHERE Contents LIKE '%" . $srch_word . "%'";

    }else if(strcmp($_POST['actionread'],"kindselect")==0){

        $sql = "SELECT * FROM memo.kind_t WHERE kind LIKE '%" . $kind . "%'";

    }else if(strcmp($_POST['actionread'],"readall")==0){

        $sql = "SELECT * FROM memo.kind_t";
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

    $id = $row['id'];
    $contents = $row['contents'];

    echo "<table border =\"3\">";    
    echo "<tbody><tr><td>";echo "id=";echo strip_tags($row['id']);      echo "\n";echo "<br>";
    echo strip_tags($row['kind']);      echo "\n";echo "<br>";
    echo "<textarea name=\"contents\" rows=\"15\" cols=\"80\" id=\"contents\" placeholder=\"内容\" >$contents</textarea>";
    echo "</tbody></tr></td>";

   
    }
?>
