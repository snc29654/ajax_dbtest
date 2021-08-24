<?php
$images = glob('../jpg/*');

foreach($images as $v) {
  echo '<img src="' , $v , '" alt="" loading="lazy" width="400px" height="400px">';
}?>