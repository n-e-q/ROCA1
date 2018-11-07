<!-- Room Creation Upload -->

<!-- Fix move_uploaded_file on line 44
- find a way to upload the file on the roomcreated2.php
- get the create room submission button to link to a database
 -->

<!-- To link with the mockup:
- give the the inputed image that is resized to what is diplayed on roomcreated2
- give the roomSectionID and the values for each room section (the coordinates)
 -->

 <!-- TO DO:
 - set the image to a constant Size
 - the coordinate for the top right, left, and bottom Right
 - get the preview button to display the dimension of the inputted values
 -->


<html>
<head>
  <meta charset="utf-8">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <!-- <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet"> -->
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="stylesheet.css">

  <!-- <link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
  <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
  <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script> -->
  <title>Room Creation for <?php echo $_POST["Room"]; ?></title>
</head>
<body>
  <!-- <script>
  function myFunction{
    $('#go').click(function(){
      $('#shape').css('width',$('#w').val());
      $('#shape').css('height',$('#h').val());
      $('#shape').css('border','2px solid black');
    });
});
  </script> -->
  <!-- <style>
    .wrapper{
      position: relative;
      top: 0;
      left: 0;
    }
    .image1 {
  position: relative;
  top: 0;
  left: 0;
    }
    .image2 {
      position: absolute;
      top: 30px;
      left: 70px;
    }
  </style> -->
<h1><?php echo $_POST["Room"]; ?></h1>
<br>
<h4 style="padding-bottom: 2%;">Seating Capacity: <?php echo $_POST["Size"]; ?></h4>

<?php
if (isset($_POST["submit"])) {
  $file = $_FILES['file'];
  // print_r($file);
  $fileName = $_FILES['file']['name'];
  $fileTempName = $_FILES['file']['tmp_name'];
  $fileSize = $_FILES['file']['size'];
  $fileError = $_FILES['file']['error'];
  $fileType = $_FILES['file']['type'];
  $target_dir = $target_dir = __DIR__ .  '/upload/';
  $target_file = $target_dir . basename("pic.jpg");

  $fileExt = explode('.',$fileName);  //take apart the file name: smapleroom.jpg
  $fileActualExt = strtolower(end($fileExt)); //end(): GET LAST PIECE OF DATA FROM ARRAY

  $allowed = array('jpg','jpeg','png','pdf');  //allowed file types

  if (in_array($fileActualExt,$allowed)) {
    if ($fileError === 0) {
      if($fileSize < 9600000){ //less than 12.5 mb
          // $fileNameNew = uniqid('',true).".".$fileActualExt;
          // $fileDestination = '../upload'.$fileNameNew;
          // move_uploaded_file($fileTempName, $fileDestination); //parameter: temp location parameter 2: new location
          // // header("Location: index.php?uploadsuccess")
          // echo $fileNameNew;
          // print_r(move_uploaded_file($fileName, $fileDestination));
          if (move_uploaded_file($fileTempName, $target_file)) { //error on move_uploaded_file
              echo "Your file: ". basename($fileName). " has been uploaded.";

          } else {
              echo '<span style="color:#ff0000;">Sorry, there was an error uploading your file.</span>';
              exit();
          }
      }//end fileSize
      else{
            echo '<span style="color:#ff0000;">Your file is too big. <br /> Please upload an .jpg, .png, or .pdf file that is less than 12mb.</span>';
            exit();
      }
    }//end fileError
    else{
      echo '<span style="color:#ff0000;">There was an error uploading your file!</span>';
      exit();
    }
  //
}//end in_array
  else{
    echo '<span style="color:#ff0000;">You cannot upload files of this type! <br /> Please upload an .jpg, .png, or .pdf file.</span>';
    exit();
  }
}
?>
<h3>Coordinates</h3>

<!-- Diplay grid over uploaded img [Problem: the imgs are not chnaging] -->
<div class="wrapper" style="position: relative; padding-bottom:2%">
  <img src="GRID.png" alt="grid" style="max-width:100%; max-height:100%; position: absolute;">
  <!-- <div class="upload-pic">

  </div> -->
  <img src="upload/pic.jpg" alt="your image" style="max-width:70%; max-height: 60%;">
</div>

<h5>Label the Top left, Top right, and Bottom Right coordinates of the each box to create the designated dimensions.</h5>
<form action="roomCreationSuccess.php" method="post">

<div class="grid-container">
  <div class="grid-item">
    <p>Box 1</p>
    <input type = "text"
           id = "myText"
           name = "coord[]"
<?php
	if ($_GET["coord"]==1) {
		echo 'value= "'.$_GET["0"].'"';
	} else {
		echo 'placeholder= "Wid"';
	}
?>
           />
    <input type = "text"
           id = "myText"
           name = "coord[]"
<?php
	if ($_GET["coord"]==1) {
		echo 'value= "'.$_GET["1"].'"';
	} else {
		echo 'placeholder = "Top Right: (  ,  )"';
	}
?>
            />
    <input type = "text"
           id = "myText"
           name = "coord[]"
<?php
	if ($_GET["coord"]==1) {
		echo 'value= "'.$_GET["1"].'"';
	} else {
		echo 'placeholder = "Bottom Right: (  ,  )"';
	}
?>
           />
    <input type="submit" name="Box1" value="Preview">

  </div>
  <div class="grid-item">
    <p>Box 2</p>
    <input type = "text"
           id = "myText"
           name = "coord[]"
           placeholder = "Top Left: (  ,  )"/>
    <input type = "text"
           id = "myText"
           name = "coord[]"
           placeholder = "Top Right: (  ,  )" />
    <input type = "text"
           id = "myText"
           name = "coord[]"
           placeholder = "Bottom Right: (  ,  )" />
    <input type="submit" name="Box2" value="Preview">
  </div>
  <div class="grid-item">
    <p>Box 3</p>
    <input type = "text"
           id = "myText"
           name = "coord[]"
           placeholder = "Top Left: (  ,  )"/>
    <input type = "text"
           id = "myText"
           name = "coord[]"
           placeholder = "Top Right: (  ,  )" />
    <input type = "text"
           id = "myText"
           name = "coord[]"
           placeholder = "Bottom Right: (  ,  )" />
    <input type="submit" name="Box3" value="Preview">
  </div>
  <div class="grid-item">
    <p>Box 4</p>
    <input type = "text"
           id = "myText"
           name = "coord[]"
           placeholder = "Top Left: (  ,  )"/>
    <input type = "text"
           id = "myText"
           name = "coord[]"
           placeholder = "Top Right: (  ,  )" />
    <input type = "text"
           id = "myText"
           name = "coord[]"
           placeholder = "Bottom Right: (  ,  )" />
    <input type="submit" name="Box4" value="Preview">

  </div>
  <div class="grid-item">
    <p>Box 5</p>
    <input type = "text"
           id = "myText"
           name = "coord[]"
           placeholder = "Top Left: (  ,  )"/>
    <input type = "text"
           id = "myText"
           name = "coord[]"
           placeholder = "Top Right: (  ,  )" />
    <input type = "text"
           id = "myText"
           name = "coord[]"
           placeholder = "Bottom Right: (  ,  )" />
  <input type="submit" name="Box5" value="Preview">
  </div>
  <div class="grid-item">
    <p>Box 6</p>
    <input type = "text"
           id = "myText"
           name = "coord[]"
           placeholder = "Top Left: (  ,  )"/>
    <input type = "text"
           id = "myText"
           name = "coord[]"
           placeholder = "Top Right: (  ,  )" />
    <input type = "text"
           id = "myText"
           name = "coord[]"
           placeholder = "Bottom Right: (  ,  )" />
    <input type="submit" name="Box6" value="Preview">
  </div>
</div>
<input type="submit" name="submit" value="Create Room">

</form>

</body>
</html>

