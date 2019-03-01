<?php
  if (isset($_POST["submit"])) {
    echo "Your Room was Created!";
  }
  else {
    if (isset($_POST["Box1"])) { // first preview button
		$_array=$_POST["coord"];
		header("Location: roomcreated2.php?coord=1&0=".$_array[0]."&1=".$_array[1]."&2=".$_array[2]);
//      echo "Box1 is ".$_array[0].",".$_array[1].",".$_array[2];
    }
    else if (isset($_POST["Box2"])) {
      echo "Box2";
    }
    else if (isset($_POST["Box3"])) {
      echo "Box3";
    }
    else if (isset($_POST["Box4"])) {
      echo "Box4";
    }
    else if (isset($_POST["Box5"])) {
      echo "Box5";
    }
    else if (isset($_POST["Box6"])) {
      echo "Box6";
    }
 }
?>