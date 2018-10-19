<!-- Room Creation Upload -->

<!-- Fix move_uploaded_file on line 44
- find a way to upload the file on the roomcreated2.php
- get the create room submission button to link to a database
 -->
<html>
 <head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <!-- <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet"> -->
    <link rel="stylesheet" href="style.css">
    <title><?php echo $_POST["Room"]; ?></title>
  </head>
<body>
<h2><?php echo $_POST["Room"]; ?></h2>
<br>
<p>Seating Capacity: <?php echo $_POST["Size"]; ?></p>

<h3>Coordinates</h3>
<?php
if (isset($_POST["submit"])) {
  $file = $_FILES['file'];
  // print_r($file);
  echo "Hello";
  $fileName = $_FILES['file']['name'];
  $fileTempName = $_FILES['file']['tmp_name'];
  $fileSize = $_FILES['file']['size'];
  $fileError = $_FILES['file']['error'];
  $fileType = $_FILES['file']['type'];
  $target_dir = $target_dir = __DIR__ .  '/upload/';
  $target_file = $target_dir . basename($fileName);

  $fileExt = explode('.',$fileName);  //take apart the file name: smapleroom.jpg
  $fileActualExt = strtolower(end($fileExt)); //end(): GET LAST PIECE OF DATA FROM ARRAY

  $allowed = array('jpg','jpeg','png','pdf');  //allowed file types

  if (in_array($fileActualExt,$allowed)) {
    if ($fileError === 0) {
      if($fileSize < 1000000){ //less than 500 kb
          // $fileNameNew = uniqid('',true).".".$fileActualExt;
          // $fileDestination = '../upload'.$fileNameNew;
          // move_uploaded_file($fileTempName, $fileDestination); //parameter: temp location parameter 2: new location
          // // header("Location: index.php?uploadsuccess")
          // echo $fileNameNew;
          // print_r(move_uploaded_file($fileName, $fileDestination));
          if (move_uploaded_file($fileTempName, $target_file)) { //error on move_uploaded_file
              echo "The file ". basename($fileName). " has been uploaded.";
          } else {
              echo "Sorry, there was an error uploading your file.";
          }
      }//end fileSize
      else{
            echo "You file is too big";
      }
    }//end fileError
    else{
      echo "There was an error uploading your file!";
    }
  //
}//end in_array
  else{
    echo "You cannot upload files of this type!";
  }
}

?>
<h5>Label the bottom left and top right vertex coordinate of each box down below.</h5>
<form id="coords">
<div class="grid-container">
  <div class="grid-item">
    <p>Box 1</p>
    <input type = "text"
           id = "myText"
           value = "Start: (  ,  ) ;  End: (  ,  )" />
  </div>
  <div class="grid-item">
    <p>Box 2</p>
    <input type = "text"
           id = "myText"
           value = "Start: (  ,  ) ;  End: (  ,  )" />
  </div>
  <div class="grid-item">
    <p>Box 3</p>
    <input type = "text"
           id = "myText"
           value = "Start: (  ,  ) ;  End: (  ,  )" />
  </div>
  <div class="grid-item">
    <p>Box 4</p>
    <input type = "text"
           id = "myText"
           value = "Start: (  ,  ) ;  End: (  ,  )" />
  </div>
  <div class="grid-item">
    <p>Box 5</p>
    <input type = "text"
           id = "myText"
           value = "Start: (  ,  ) ;  End: (  ,  )" />
  </div>
  <div class="grid-item">
    <p>Box 6</p>
    <input type = "text"
           id = "myText"
           value = "Start: (  ,  ) ;  End: (  ,  )" />
  </div>
</div>
<input type="submit" name="submit" value="Create Room">
</form>

</body>
</html>
