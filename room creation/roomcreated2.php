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
  <link rel="stylesheet" href="style2.css">
  <script type="text/javascript" src="gridbox.js"></script>
  <!-- <link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
  <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
  <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script> -->
  <title>Room Creation for <?php echo $_POST["Room"]; ?></title>
</head>

<body onload="createBoxes()">

<h1><strong><?php echo $_POST['Room']; ?></strong></h1>
<h4 style="padding-bottom: 2%;">Seating Capacity: <?php echo $_POST['Size']; ?></h4>

<iframe name="dump_data_frame" id="dump_data_frame"></iframe>

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
  $target_dir = $target_dir = __DIR__ .  '\\upload\\';
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
<!--   <div class="box">
</div> -->
	
	
	
	
	<div id="grid_div">
 		<!-- <img src="grid.png" alt="grid" id="grid_img">  -->
 		<!-- <div id="grid_boxes"></div> -->
	</div>
	
</div>

<p class="description"><strong>Label the Bottom left and Top right coordinates of the boxes to create the designated dimensions. The 6 box does not all have to be used.<br>
(The Box numbers displayed on the image can be used as a guidance but does not have to be followed strictly.)</strong></p>

<form action="roomCreationSuccess.php" method="post" target="dump_data_frame">
    <input type="hidden" name="action" value="part2">
    <input type="hidden" name="Room" value="<?php echo $_POST['Room'];?>">
    <input type="hidden" name="Size" value="<?php echo $_POST['Size'];?>">
    <input type="hidden" name="file" value="upload/pic.jpg">
    <div class="grid-container">
      <div class="grid-item">
        <p>Box 1</p>
        <input type = "text"
               id = "1B"
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
               id = "1T"
               name="data[]"
    
               placeholder = "Top Right: (  ,  )" />
        <button class = "button" id="Box1" onclick="prepareCoords(1)">Preview</button>
    <!-- (3,8,5,12) -->
      </div>
      <div class="grid-item">
        <p>Box 2</p>
        <input type = "text"
               id = "2B"
               placeholder = "Bottom Left: (  ,  )"/>
        <input type = "text"
               id = "2T"
               placeholder = "Top Right: (  ,  )" />
        <button class = "button" id="Box2" onclick="prepareCoords(2)">Preview</button>
      </div>
      <div class="grid-item">
        <p>Box 3</p>
        <input type = "text"
               id = "3B"
               placeholder = "Bottom Left: (  ,  )"/>
        <input type = "text"
               id = "3T"
               placeholder = "Top Right: (  ,  )" />
        <button class = "button" id="Box3" onclick="prepareCoords(3)">Preview</button>
      </div>
      <div class="grid-item">
        <p>Box 4</p>
        <input type = "text"
               id = "4B"
               placeholder = "Bottom Left: (  ,  )"/>
        <input type = "text"
               id = "4T"
               placeholder = "Top Right: (  ,  )" />
        <button class = "button" id="Box4" onclick="prepareCoords(4)">Preview</button>
    
      </div>
      <div class="grid-item">
        <p>Box 5</p>
        <input type = "text"
               id = "5B"
               placeholder = "Bottom Left: (  ,  )"/>
        <input type = "text"
               id = "5T"
               placeholder = "Top Right: (  ,  )" />
      <button class = "button" id="Box5" onclick="prepareCoords(5)">Preview</button>
      </div>
      <div class="grid-item">
        <p>Box 6</p>
        <input type = "text"
               id = "6B"
               placeholder = "Bottom Left: (  ,  )"/>
        <input type = "text"
               id = "6T"
               placeholder = "Top Right: (  ,  )" />
        <button class = "button" id="Box6" onclick="prepareCoords(6)">Preview</button>
      </div>
    </div>
    <input id="finalSubmit" type="submit" name="submit" value="Create Room">

</form>
</body>
</html>