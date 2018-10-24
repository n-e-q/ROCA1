<?php
	$subject=$_POST['subject'];
	$number=$_POST['number'];
	$professor=$_POST['professor'];

	$cName=$subject.' '.$number.' ('.$professor.')';

	$conn=new mysqli("localhost", "dot_user", "Vb5YDh4m00!hjtNY7*^", "DOTs");

	$iSQL=sprintf("INSERT INTO system_courses (cID, pID, cName, mPattern, sTime, eTime) VALUES ('NULL', 'NULL', $cName, 'NULL', 'NULL', 'NULL')");
		$this->conn->query($iSQL);

	echo "Course Created Successfully!";

	$conn->close();
?>