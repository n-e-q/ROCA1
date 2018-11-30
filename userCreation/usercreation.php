<?php
	$fName=$_POST['fname']
	$lName=$_POST['lname']
	$uID=$_POST['ID']
	$user_type=$_POST['usertype']
	$roleID=user_type($user_type)

	$conn=new mysqli("localhost", "dot_user", "Vb5YDh4m00!hjtNY7*^", "DOTs");


	$iSQL=sprintf("INSERT INTO system_users (uID, roleID, fName, lName) VALUES ($uID, $roleID, $fName, $lName)");
		$this->conn->query($iSQL);
	echo "Course Created Successfully!";


    protected function user_type($_type)
    {
        switch ($_type) {
            case "student":
                $_val=(!empty($_val)) ? "'".$this->format_data_text(1)."'" : "NULL";
                break;
            case "other":
                $_val=(!empty($_val)) ? "'".$this->format_html_text(2)."'" : "NULL";
                break;
            case "faculty":
                $_val=(!empty($_val)) ? "'".$this->format_html_text(3)."'" : "NULL";
                break;
        }

        return $_val;
    }
	$this->$conn->close();
?>