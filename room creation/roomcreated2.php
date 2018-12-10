<!-- Jenny Yao, ROCA1 -->
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
  <!-- <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="fonts/stylesheet"> -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
  <!-- <link rel="stylesheet" href="style.css"> -->
  <link rel="stylesheet" href="fonts/stylesheet.css">

  <!-- <link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
  <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
  <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script> -->
  <title>Room Creation for <?php echo $_POST["Room"]; ?></title>
</head>
<body>
  <style>
  @import url('https://fonts.googleapis.com/css?family=Open+Sans');

  *{
    font-family: 'product sans';
    margin: 0;
    background-color: #f2f2f2;

  }
  body{
    padding: 2%;
    padding-left: 7%;
    padding-right: 7%;
  }
  h1{
    padding-bottom: 0;
  }
  h2{
    padding-top: 2%;
  }
  h3{
    padding-bottom: 3%;
    padding-top: 2%;
  }
  .description{
    font-size: 100%;
    background-color: transparent;
    color: black;
  }
  p{
    font-size: 50%;
    padding-bottom: 2%;
    background-color: #000000;
    color: #ffffff
  }

  input[type=text] {
      width: 100%;
      padding: 12px 20px;
      margin: 8px 0;
      display: inline-block;
      border: 2px solid #000000 ;
      border-radius: 20px;
      box-sizing: border-box;
      color:#9B9B9B;
      background-color: #ffffff;
  }

  input[type=submit] {
      width: 70%;
      padding: 14px 20px;
      margin: 8px 0;
      border: 2px solid #ffffff ;
      border-radius: 20px;
      box-sizing: border-box;
      border-radius: 20px;
      background-color: #000000;
      color: #ffffff;
      cursor: pointer;
  }
  input[type=submit]:hover {
    width: 70%;
    padding: 14px 20px;
    margin: 8px 0;
    color:#000000;
    background-color: #ffffff;
  }
  #finalSubmit{
    margin-left: 15%;
  }

  .grid-container {
    display: grid;
    grid-template-columns: auto auto auto;
    padding: 2%;
  }
  .grid-item {
    border: 2px solid #ccc;
    border-radius: 6%;
    background-color: black;
    padding: 20px;
    font-size: 30px;
    text-align: center;
  }
  .wrapper{
  position:relative;
  }
  .absolute_pic{
    position: absolute;
  }

  </style>

 <h1><strong><?php echo $_POST['Room']; ?></strong></h1>
<h4 style="padding-bottom: 2%;">Seating Capacity: <?php echo $_POST['Size']; ?></h4>

<!-- Checks image submission & uploads -->
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
          if (move_uploaded_file($fileTempName, $target_file)) { //error on move_uploaded_file
              echo "<i>Image upload success.</i>";

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
<h3><strong>Setting the Sections of the Classroom</strong></h3>

	
<!-- TO REVIEW -->	
	
<!-- Diplay grid over uploaded img  -->
<!--
Bottom Left:  (x1,y1)
  x1 = Used to sets Left margin
  y1
Top Right:    (x2,y2)
  x2
  y2 = Used to set Top margin
 -->

<!--
Dimensions of 1 box: BL(0,0); TR(1,1)
  height: 5.5%;
  width: 3.4%;
-->

 <!--
 To determine the width and height of the boxes:
 - width= (x2-x1) * 3.4%
 - height= (y2-y1) * 5.5%
-->

<!--
To determine the position of the boxes (margin-top,left):
- initial margins:
    - intial margin-left = 4.7%
    - initial margin-top = 1.2%
- margin-left= (x1 * 3.4%) + 4.7%
- margin-top= ((12-y2) * 5.5%) + 1.2%
-->

<div class="wrapper" style="height: 100vh;">
<!-- currently for BL(0,11)    TR(1,12) -->
<!-- currently: make sure the porportion of the width to height is always the same-->
  <div
  style="
  /* position: fixed; */
  /* OK */
  height:5.5%;
  /* OK */
  width: 3.4%;
  max-height: 100%;
  z-index:4;
  /* OK */
  margin-left: 4.7%;
  margin-top: 1.2%;
  /* margin: 16.3% 0 0 31.9%; */
  position: absolute;
  border: 2px solid #000000 ;
  border-radius: 2px;
  box-sizing: border-box;
  background-color: rgba(98,86, 80, 0.3)	/* 50% opaque blue */
;
  /* box-sizing: box-shadow: 10px 10px 28px 1px rgba(163,163,163,0.54); */

  "
  >
</div>
	
	
	
	
  <div style="height:100%; z-index:3;position: absolute;">
  <img src="grid.png" alt="grid" style="width: 100%; max-height:100%;   background-color: transparent;
">
</div>
<div style="height:100%;  z-index:2;position: absolute;">
  <img class ="image2" src="upload/pic.jpg" alt="your image" style="max-width:90%; height:100%; margin-left:5%;">
</div>
</div>

<p class="description"><strong>Label the Bottom left and Top right coordinates of the boxes to create the designated dimensions. The 6 box does not all have to be used.<br>
(The Box numbers displayed on the image can be used as a guidance but does not have to be followed strictly.)</strong></p>
<form action="roomCreationSuccess.php" method="post">
<input type="hidden" name="action" value="part2">
<input type="hidden" name="Room" value="<?php echo $_POST['Room'];?>">
<input type="hidden" name="Size" value="<?php echo $_POST['Size'];?>">
<input type="hidden" name="file" value="upload/pic.jpg">
<div class="grid-container">
  <div class="grid-item">
    <p>Box 1</p>
    <input type = "text"
           id = "myText"
           name="data[]"
           <?php
           if (isset($_POST['data'])) {
             echo 'value="'.$_POST["data"][0].'"';
          } else {

          echo '  placeholder= "Bottom Left: (  ,  )"';
          }

             ?>



    />
    <input type = "text"
           id = "myText"
           name="data[]"

           placeholder = "Top Right: (  ,  )" />
    <input type="submit" name="Box1" value="Preview">

  </div>
  <div class="grid-item">
    <p>Box 2</p>
    <input type = "text"
           id = "myText"
           placeholder = "Bottom Left: (  ,  )"/>
    <input type = "text"
           id = "myText"
           placeholder = "Top Right: (  ,  )" />
    <input type="submit" name="Box2" value="Preview">
  </div>
  <div class="grid-item">
    <p>Box 3</p>
    <input type = "text"
           id = "myText"
           placeholder = "Bottom Left: (  ,  )"/>
    <input type = "text"
           id = "myText"
           placeholder = "Top Right: (  ,  )" />
    <input type="submit" name="Box3" value="Preview">
  </div>
  <div class="grid-item">
    <p>Box 4</p>
    <input type = "text"
           id = "myText"
           placeholder = "Bottom Left: (  ,  )"/>
    <input type = "text"
           id = "myText"
           placeholder = "Top Right: (  ,  )" />
    <input type="submit" name="Box4" value="Preview">

  </div>
  <div class="grid-item">
    <p>Box 5</p>
    <input type = "text"
           id = "myText"
           placeholder = "Bottom Left: (  ,  )"/>
    <input type = "text"
           id = "myText"
           placeholder = "Top Right: (  ,  )" />
  <input type="submit" name="Box5" value="Preview">
  </div>
  <div class="grid-item">
    <p>Box 6</p>
    <input type = "text"
           id = "myText"
           placeholder = "Bottom Left: (  ,  )"/>
    <input type = "text"
           id = "myText"
           placeholder = "Top Right: (  ,  )" />
    <input type="submit" name="Box6" value="Preview">
  </div>
</div>
<input id="finalSubmit" type="submit" name="submit" value="Create Room">

</form>
</body>
</html>

