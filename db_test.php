<?php
header('Content-Type: text/html; charset=UTF-8');
include('param.php');


global $email_list;



//if(!$_POST['kind'] || !$_POST['contents']){exit("未入力あり");}

file_put_contents("../from_html.txt", $_POST['kind'] ."\n",FILE_APPEND);
file_put_contents("../from_html.txt", $_POST['contents']."\n",FILE_APPEND);
file_put_contents("../from_html.txt", $_POST['action']."\n",FILE_APPEND);
//file_put_contents("../from_html.txt", $_POST['delid_value']."\n",FILE_APPEND);
//$delid_value = $_POST['delid_value'];
try{
	

    $pdo = new PDO(
        $dsn,
        $user,
        $pass
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("create table if not exists $dbtable(
        id int not null auto_increment primary key,
        email varchar(255),
        kind varchar(40),
        contents text,
        answer text
      )");
  



    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$pdo->query("SET NAMES UTF8;");


}catch(PDOException $Exception){
    die('接続できません：' .$Exception->getMessage());
}

try{

	$sql = "SET NAMES UTF8;";
    $stmh = $pdo->prepare($sql);
    $stmh->execute();
    $date=date('Y年m月d日 H時i分s秒');


    if(strcmp($_POST['action'],"delall")==0){
        $sql = "DELETE FROM $dbtable";
    }
    if(strcmp($_POST['action'],"delid")==0){
        $sql = "DELETE FROM $dbtable WHERE id = '${_POST['delid_value']}'" ;
    }
    if(strcmp($_POST['action'],"add")==0){
        $sql = "INSERT INTO $dbtable SET kind = '${_POST['kind']}($date)', email = '${_POST['email']}', contents = '${_POST['contents']}';";

        if (!$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            echo $_POST['email'];    
            echo '入力された値が不正です。';
        }
         


        mb_language("Japanese");
        mb_internal_encoding("UTF-8");
        $to = $_POST['email'];
        echo $to;
        $contents = $_POST['contents'];
        if(mb_send_mail($to,"本内容を受け付けました",$contents)){
          echo "メールを送信しました";
        } else {
          echo "メールの送信に失敗しました";
        };
  


    }
    if(strcmp($_POST['action'],"add_answer")==0){
        $sql = "UPDATE $dbtable SET answer='${_POST['answer']}' WHERE id ='${_POST['updateid_value']}' ";
        //UPDATE mytbl SET price=1000 WHERE id=10;

        $id =$_POST['updateid_value'];

        mb_language("Japanese");
        mb_internal_encoding("UTF-8");
        $to = $email_list[$id];
        echo $to;
        $answer = $_POST['answer'];
        if(mb_send_mail($to,"回答を送信しました",$answer)){
          echo "メールを送信しました";
        } else {
          echo "メールの送信に失敗しました";
        };


    }



    $stmh = $pdo->prepare($sql);
    $stmh->execute();


}catch(PDOException $Exception){
    die('接続エラー：' .$Exception->getMessage());
}

try{
    $pdo = new PDO(
        $dsn,
        $user,
        $pass
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
}catch(PDOException $Exception){
    die('接続エラー：' .$Exception->getMessage());
}

try{
    $sql = "SELECT * FROM $dbtable";
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
    
    echo "id=";echo strip_tags($row['id']);      echo "\n";
    echo "*************************************\n";
    echo strip_tags($row['kind']);      echo "\n";
    echo "*************************************\n";
    echo strip_tags($row['contents']);   echo "\n";   
    echo "*************************************\n";
    }
?>
