<html>
<head>
  <meta charset="utf-8">
  <!-- <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet"> -->
  <!-- <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet"> -->
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="stylesheet.css">

  <!-- <link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
  <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
  <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script> -->
  <title>Room Creation Success!</title>
</head>
<body>
  <?php
  if (isset($_POST["submit"])) {
    echo "Your Room was Created!";
  }
  else {
    if (isset($_POST["Box1"])) { // first preview button
      echo "Box1";
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
</body>
