<?php
$images = glob('../jpg/*');

foreach($images as $v) {
  echo $v."<br>";
  echo '<img src="' , $v , '" alt="" loading="lazy" width="400px" height="400px">';
  echo "<br>";
}?>