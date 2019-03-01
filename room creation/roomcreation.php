<!-- Room Creation Form -->
<!-- TO DO:
  - resize the image to constant Size
  - dynamic coordinate system: when user types into the field, create a box over the dimension the user want
-->
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <!-- <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet"> -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="stylesheet.css">

    <title>Room Creation</title>
  </head>
  <body>
    <h1>Room Creation</h1>
    <h3>To create a room, fill in the corresponding information below.</h3>
    <form action="roomcreated2.php" method="POST" enctype="multipart/form-data"> <!--// action to some .php
       //action: defines the action to be performed when the form is submitted -->
        <p>
          <label>Room Name:</label><br >
          <input type = "text" name="Room" placeholder = "Room Name" />
        </p>
        <p>
          <label>Seating Capacity:</label><br >
          <input type = "text" name="Size" placeholder = "#Seating Capacity" />
        </p>
        <p>Upload the image of the classroom.</p>
        <p>
        <input type="file" name="file" accept="image/*" onchange="readURL(this)" >
        </p>

        <input type="submit" name="submit" value="Next >> ">
      </form>

  </body>
</html>