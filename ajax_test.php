<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8" />
    <title>example</title>
    <link rel="stylesheet" href="sample.css" type="text/css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        $(document).ready(function()
        {
		
            $('#send').click(function()
            {
                var data = {
		            email : $('#email').val(),
		            kind : $('#kind').val(),
		            contents : $('#contents').val(),
		            answer : $('#answer').val(),
		            action : $('#action').val(),
		            delid_value : $('#delid_value').val(),
		            updateid_value : $('#updateid_value').val()
	            };
 
                $.ajax({
                    type: "post",
                    url: "db_test.php",
                    data: data,
                    success: function(data, dataType)
                    {
                        document.getElementById( "phplog" ).value = data ;

                        if( $('#action').val()=="add"){

                            alert("新規追加しました");
                        }
                            
                    },
                    error: function()
                    {
                        alert('送信失敗');
                    }
                });


                if( $('#action').val()=="add"){
                    alert("新規追加中です");


                    var data = {
		            kind : $('#kind').val(),
		            contents : $('#contents').val(),
		            answer : $('#answer').val(),
		            actionread : "idmax",
		            srch_word : $('#srch_word').val(),
		            srchid_value : $('#srchid_value').val()

                    };
 
                    $.ajax({
                        type: "post",
                        url: "db_read.php",
                        data: data,
                        success: function(data, dataType)
                        {
                            document.getElementById( "phplog" ).value = data ;
                            $('#result').html(data);
                        },
                        error: function()
                        {
                            alert('送信失敗');
                        }
                    });




                }



                return false;
            });

            $('#logread').click(function()
            {
                var data = {
		            kind : $('#kind').val(),
		            contents : $('#contents').val(),
		            answer : $('#answer').val(),
		            actionread : $('#actionread').val(),
		            srch_word : $('#srch_word').val(),
		            srchid_value : $('#srchid_value').val()

                };
 
                $.ajax({
                    type: "post",
                    url: "db_read.php",
                    data: data,
                    success: function(data, dataType)
                    {
                        document.getElementById( "phplog" ).value = data ;
                        $('#result').html(data);
                    },
                    error: function()
                    {
                        alert('送信失敗');
                    }
                });
                return false;
            });

        });
        var today=new Date(); 

        var year = today.getFullYear();
        var month = today.getMonth()+1;
        var week = today.getDay();
        var day = today.getDate();

        var week_ja= new Array("日","月","火","水","木","金","土");

        document.write(year+"年"+month+"月"+day+"日 "+week_ja[week]+"曜日");
    </script>
</head>
<body>
<form id="testForm" name="testForm" method="post" >
<ul>
<li><input type="text" size=40 id="email" name="email" placeholder="あなたのメールアドレス"></li>
<li><input type="text" size=78 id="kind" name="kind" placeholder="種別"></li>
<li><textarea name="contents" rows="10" cols="80" id="contents" placeholder="内容" ></textarea>
<textarea name="answer" rows="10" cols="80" id="answer" placeholder="回答" ></textarea></li>
<li><textarea name="phplog" rows="10" cols="80" id="phplog" placeholder="実行ログ" ></textarea></li>
<li><input type="text" size=20 id="srch_word" name="srch_word" placeholder="検索ワード">
<input type="text" size=5 id="srchid_value" name="srchid_value" placeholder="検索id">
<input type="text" size=5 id="delid_value" name="delid_value" placeholder="削除id">
<input type="text" size=5 id="updateid_value" name="updateid_value" placeholder="回答id"></li>
</ul>

<p class="more"><input id="send" type="submit" value="DB書き込み"onclick="clickwrite()"/>
<select name="action" id="action">
    <option value="add">追加登録（書き込み）</option>
    <option value="add_answer">回答登録（書き込み）</option>
    <option value="delid">id検索削除（書き込み）</option>
    <option value="delall">全削除（書き込み）</option>
    </select></p>
<p class="more"><input id="logread" type="submit" value="DB読み出し"onclick="clickread()"/>
<select name="actionread" id="actionread">
    <option value="readall">全読み出し（読み出し）</option>
    <option value="idmax">最後読み出し（読み出し）</option>
    <option value="srch">検索ワード選択（読み出し）</option>
    <option value="srchid">検索ID（読み出し）</option>
    <option value="kindselect">種別選択（読み出し）</option>
    </select></p>
       
<input type="reset" value="クリア">
</form>
<input type="date">
<div id="result"></div>

</body>
</html>

<script>
function clickread(){
    if(($('#actionread').val()=="srchid")){
        if(($('#srchid_value').val()=="")){
            alert("検索IDが未入力です");    
        }

    }

    if(($('#actionread').val()=="srch")){
        if(($('#srch_word').val()=="")){
            alert("検索ワードが未入力です");    
        }

    }
    if(($('#actionread').val()=="kindselect")){
        if(($('#kind').val()=="")){
            alert("種別が未入力です");    
        }

    }
}
function clickwrite(){

    if(($('#action').val()=="add")){
        if(($('#kind').val()=="")){
        alert("種別が未入力です");    
        }

        if(($('#contents').val()=="")){
        alert("内容が未入力です");    
        }

    }

}


function segwrite($id){
    var data = {
		            email : $('#email').val(),
		            kind : $('#kind').val(),
		            contents : $('#contents').val(),
		            answer : $('#answer').val(),
		            action : "delid",
		            delid_value : $id,
		            updateid_value : $('#updateid_value').val()
	            };
 
                $.ajax({
                    type: "post",
                    url: "db_test.php",
                    data: data,
                    success: function(data, dataType)
                    {
                        document.getElementById( "phplog" ).value = data ;
                        alert("id="+$id + "を削除しました。");
				
                    },
                    error: function()
                    {
                        alert('送信失敗');
                    }
                });

                alert("削除待ちです");

                var data = {
		            kind : $('#kind').val(),
		            contents : $('#contents').val(),
		            answer : $('#answer').val(),
		            actionread : "readall",
		            srch_word : $('#srch_word').val(),
		            srchid_value : $('#srchid_value').val()

                };
 
                $.ajax({
                    type: "post",
                    url: "db_read.php",
                    data: data,
                    success: function(data, dataType)
                    {
                        document.getElementById( "phplog" ).value = data ;
                        $('#result').html(data);
                    },
                    error: function()
                    {
                        alert('送信失敗');
                    }
                });
 


}



function answersegwrite($id,$answer){
    var data = {
		            email : $('#email').val(),
		            kind : $('#kind').val(),
		            contents : $('#contents').val(),
		            answer : $answer,
		            action : "add_answer",
		            delid_value : $id,
		            updateid_value : $id
	            };
 
                $.ajax({
                    type: "post",
                    url: "db_test.php",
                    data: data,
                    success: function(data, dataType)
                    {
                        document.getElementById( "phplog" ).value = data ;
                        alert("id="+$id + "の回答を登録しました。");
                    },
                    error: function()
                    {
                        alert('送信失敗');
                    }
                });

}




function clickanswerseg0(){
    console.log($('#answerseg0').val());
    $answer=$('#answerseg0').val();
    $id=$('#delseg0').val();
    answersegwrite($id,$answer) 
}

function clickanswerseg1(){
    console.log($('#answerseg1').val());
    $answer=$('#answerseg1').val();
    $id=$('#delseg1').val();
    answersegwrite($id,$answer) 
}

function clickanswerseg2(){
    console.log($('#answerseg2').val());
    $answer=$('#answerseg2').val();
    $id=$('#delseg2').val();
    answersegwrite($id,$answer) 
}
function clickanswerseg3(){
    console.log($('#answerseg3').val());
    $answer=$('#answerseg3').val();
    $id=$('#delseg3').val();
    answersegwrite($id,$answer) 
}
function clickanswerseg4(){
    console.log($('#answerseg4').val());
    $answer=$('#answerseg4').val();
    $id=$('#delseg4').val();
    answersegwrite($id,$answer) 
}
function clickanswerseg5(){
    console.log($('#answerseg5').val());
    $answer=$('#answerseg5').val();
    $id=$('#delseg5').val();
    answersegwrite($id,$answer) 
}
function clickanswerseg6(){
    console.log($('#answerseg6').val());
    $answer=$('#answerseg6').val();
    $id=$('#delseg6').val();
    answersegwrite($id,$answer) 
}
function clickanswerseg7(){
    console.log($('#answerseg7').val());
    $answer=$('#answerseg7').val();
    $id=$('#delseg7').val();
    answersegwrite($id,$answer) 
}
function clickanswerseg8(){
    console.log($('#answerseg8').val());
    $answer=$('#answerseg8').val();
    $id=$('#delseg8').val();
    answersegwrite($id,$answer) 
}
function clickanswerseg9(){
    console.log($('#answerseg9').val());
    $answer=$('#answerseg9').val();
    $id=$('#delseg9').val();
    answersegwrite($id,$answer) 
}
function clickanswerseg10(){
    console.log($('#answerseg10').val());
    $answer=$('#answerseg10').val();
    $id=$('#delseg10').val();
    answersegwrite($id,$answer) 
}



function clickanswerseg11(){
    console.log($('#answerseg11').val());
    $answer=$('#answerseg11').val();
    $id=$('#delseg11').val();
    answersegwrite($id,$answer) 
}

function clickanswerseg12(){
    console.log($('#answerseg12').val());
    $answer=$('#answerseg12').val();
    $id=$('#delseg12').val();
    answersegwrite($id,$answer) 
}
function clickanswerseg13(){
    console.log($('#answerseg13').val());
    $answer=$('#answerseg13').val();
    $id=$('#delseg13').val();
    answersegwrite($id,$answer) 
}
function clickanswerseg14(){
    console.log($('#answerseg14').val());
    $answer=$('#answerseg14').val();
    $id=$('#delseg14').val();
    answersegwrite($id,$answer) 
}
function clickanswerseg15(){
    console.log($('#answerseg15').val());
    $answer=$('#answerseg15').val();
    $id=$('#delseg15').val();
    answersegwrite($id,$answer) 
}
function clickanswerseg16(){
    console.log($('#answerseg16').val());
    $answer=$('#answerseg16').val();
    $id=$('#delseg16').val();
    answersegwrite($id,$answer) 
}
function clickanswerseg17(){
    console.log($('#answerseg17').val());
    $answer=$('#answerseg17').val();
    $id=$('#delseg17').val();
    answersegwrite($id,$answer) 
}
function clickanswerseg18(){
    console.log($('#answerseg18').val());
    $answer=$('#answerseg18').val();
    $id=$('#delseg18').val();
    answersegwrite($id,$answer) 
}
function clickanswerseg19(){
    console.log($('#answerseg19').val());
    $answer=$('#answerseg19').val();
    $id=$('#delseg19').val();
    answersegwrite($id,$answer) 
}
function clickanswerseg20(){
    console.log($('#answerseg20').val());
    $answer=$('#answerseg20').val();
    $id=$('#delseg20').val();
    answersegwrite($id,$answer) 
}






function clickseg0(){
    console.log($('#delseg0').val());
    $id=$('#delseg0').val();
    segwrite($id) 
}

function clickseg1(){
    console.log($('#delseg1').val()); 
    $id=$('#delseg1').val();
    segwrite($id) 
}

function clickseg2(){
    console.log($('#delseg2').val()); 
    $id=$('#delseg2').val();
    segwrite($id) 
}
function clickseg3(){
    console.log($('#delseg3').val()); 
    $id=$('#delseg3').val();
    segwrite($id) 
}
function clickseg4(){
    console.log($('#delseg4').val()); 
    $id=$('#delseg4').val();
    segwrite($id) 
}
function clickseg5(){
    console.log($('#delseg5').val()); 
    $id=$('#delseg5').val();
    segwrite($id) 
}
function clickseg6(){
    console.log($('#delseg6').val()); 
    $id=$('#delseg6').val();
    segwrite($id) 
}
function clickseg7(){
    console.log($('#delseg7').val()); 
    $id=$('#delseg7').val();
    segwrite($id) 
}
function clickseg8(){
    console.log($('#delseg8').val()); 
    $id=$('#delseg8').val();
    segwrite($id) 
}
function clickseg9(){
    console.log($('#delseg9').val()); 
    $id=$('#delseg9').val();
    segwrite($id) 
}
function clickseg10(){
    console.log($('#delseg10').val()); 
    $id=$('#delseg10').val();
    segwrite($id) 
}
function clickseg11(){
    console.log($('#delseg11').val()); 
    $id=$('#delseg11').val();
    segwrite($id) 
}
function clickseg12(){
    console.log($('#delseg12').val()); 
    $id=$('#delseg12').val();
    segwrite($id) 
}
function clickseg13(){
    console.log($('#delseg13').val()); 
    $id=$('#delseg13').val();
    segwrite($id) 
}
function clickseg14(){
    console.log($('#delseg14').val()); 
    $id=$('#delseg14').val();
    segwrite($id) 
}
function clickseg15(){
    console.log($('#delseg15').val()); 
    $id=$('#delseg15').val();
    segwrite($id) 
}
function clickseg16(){
    console.log($('#delseg16').val()); 
    $id=$('#delseg16').val();
    segwrite($id) 
}
function clickseg17(){
    console.log($('#delseg17').val()); 
    $id=$('#delseg17').val();
    segwrite($id) 
}
function clickseg18(){
    console.log($('#delseg18').val()); 
    $id=$('#delseg18').val();
    segwrite($id) 
}
function clickseg19(){
    console.log($('#delseg19').val()); 
    $id=$('#delseg19').val();
    segwrite($id) 
}
function clickseg20(){
    console.log($('#delseg20').val()); 
    $id=$('#delseg20').val();
    segwrite($id) 
}


</script>
<form action="" method="post" enctype="multipart/form-data">
    <p>file：<input type="file" name="userfile" size="40" /></p>
    <p><input type="text" size=5 id="jpgid_value" name="jpgid_value" placeholder="画像id"></p>
    <p><input type="submit" value="upload" /></p>
   </form>
   <a href="jpg_display.php">画像表示</a><br/>
   <a href="document.php">操作説明書</a><br/>

   <?php
   if($_SERVER["REQUEST_METHOD"] === "POST"){

    if(isset($_POST['eqjpgid'])){
        $id = $_POST['eqjpgid'];
        echo "<img src=\"../jpg/$id.jpg\" ><br>";

        exit;
    }


    if(isset($_POST['answerid'])){
        $id = $_POST['answerid'];
        $answer = $_POST['answer'];

        include('param.php');


        global $email_list;
        
        
        
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
        
        
                $sql = "UPDATE $dbtable SET answer='${_POST['answer']}' WHERE id ='${_POST['answerid']}' ";
                //UPDATE mytbl SET price=1000 WHERE id=10;
        
                $id =$_POST['answerid'];
        
        
        
        
        
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
        



















































        exit;
    }


    if(isset($_POST['delseg'])){
        $id = $_POST['delseg'];


        include('param.php');
        
        
        global $email_list;
        
        
        
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
        
        
            $sql = "DELETE FROM $dbtable WHERE id = '${_POST['delseg']}'" ;
        
        
        
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
        

















































        exit;
    }
















    if($_FILES["userfile"]["error"] == UPLOAD_ERR_OK){
     $tempfile = $_FILES["userfile"]["tmp_name"];
     $filename = $_FILES["userfile"]["name"];
     $jpgid= $_POST["jpgid_value"];  
     $filename = mb_convert_encoding($jpgid.".jpg", "cp932", "utf8");
     $result = move_uploaded_file($tempfile, "../jpg/".$filename);
     if($result == TRUE){
      $message ="upload success";
     }
     else{
      $message ="upload fail";
     }
    }
    elseif($_FILES["userfile"]["error"] == UPLOAD_ERR_NO_FILE) {
     $message ="upload fail";
    }
    else {
     $message ="upload fail";
    }
    echo $message;
   }
   ?>
   