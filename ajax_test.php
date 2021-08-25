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
				
                    },
                    error: function()
                    {
                        alert('送信失敗');
                    }
                });

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
</script>
<form action="" method="post" enctype="multipart/form-data">
    <p>file：<input type="file" name="userfile" size="40" /></p>
    <p><input type="text" size=5 id="jpgid_value" name="jpgid_value" placeholder="画像id"></p>
    <p><input type="submit" value="upload" /></p>
   </form>
   <a href="jpg_display.php">画像表示</a><br/>

   <?php
   if($_SERVER["REQUEST_METHOD"] === "POST"){
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
   