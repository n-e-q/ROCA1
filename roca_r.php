<?php
class dashboard extends dataConnection
{
	private $tDate;
	private $cTime;
	private $pTime;
	protected $action='';
	protected $fData='';
	public $listData=array();
	public $push='';
	
	public function __construct()
	{
		$this->bind_session();
		$this->tDate=mktime(0, 0, 0, date('n'), date('j'), date('Y'));
		$this->cTime=mktime(date('G'), date('i'), 0, 1, 1, 2000);
		$this->pTime=mktime(date('G'), date('i'), date('s'), 1, 1, 2000); 
		$this->data_connection();
		if (empty($_SESSION['bind']['sid'])) $this->get_active_user();
		$this->get_user_privileges();
/*		
		echo '<pre>';
		print_r($_SESSION['bind']);
		echo '</pre>';
*/
	}

	private function get_active_user()
	{
		$sSQL="SELECT ID, roleID FROM system_users WHERE uID='".$_SESSION['bind']['uid']."' LIMIT 1";
		$build_query=$this->conn->query($sSQL);
		while($row=mysqli_fetch_array($build_query)) {
			$_SESSION['bind']['sid']=$row['ID'];
			$_SESSION['bind']['rid']=$row['roleID'];
		}
		if (!isset($_SESSION['bind']['rid'])) $_SESSION['bind']['rid']=$_SESSION['bind']['role'];
	}

	private function get_user_privileges()
	{
		$this->action=$this->build_request_variable('action');
		$this->fData=$this->build_request_variable('data');
		$_SESSION['bind']['rid']=3;
		switch ($_SESSION['bind']['rid']) {
			case "1":	// Observer
//				$this->run_collection();
				break;
			case "2":	// Consultant
				
				break;
			case "3":	// Admin
				$this->get_admin_panel();
				break;
			case "Instructor":
// Instructors will need to be able to request observations and see results posted by Consultant
// need to add the course to database using Collab Info, and track instructor requested vs manually added courses


				break;
			default:
				$this->display_error('You do not have sufficient privileges to access this Collab Tool.');
				break;
		}
	}

	private function get_admin_panel()
	{
		switch ($this->action) {
// COURSE CASES
			case "display_course_list":
				$this->display_course_list();
				break;
			case "display_course_form":
				$this->display_course_form();
				break;
			case "set_course_info":
				$this->set_course_info();
				break;
			case "display_user_list":
				$this->display_user_list();
				break;
			case "display_user_form":
				$this->display_user_form();
				break;
			case "set_user_info":
				$this->set_user_info();
				break;
			case "display_room_list":
				$this->display_room_list();
				break;
			case "display_room_form":
				$this->display_room_form();
				break;
			case "set_room_info":
				$this->set_room_info();
				break;
			case "display_assignment_list":
				$this->display_assignment_list();
				break;
			case "display_assignment_form":
				$this->display_assignment_form();
				break;
			case "set_assignment_info":
				$this->set_assignment_info();
				break;
			default:
				$this->display_admin_panel();
				break;		
		}
	}

	private function display_admin_panel()
	{
		echo '<b>Courses</b><br>';
		echo '<a href="index.php?action=display_course_list">Course List</a><br>';
		echo '<a href="index.php?action=display_course_form">Course Creation</a><p>';
		echo '<b>Users</b><br>';
		echo '<a href="index.php?action=display_user_list">User List</a><br>';
		echo '<a href="index.php?action=display_user_form">User Creation</a><p>';
		echo '<b>Rooms</b><br>';
		echo '<a href="index.php?action=display_room_list">Room List</a><br>';
		echo '<a href="index.php?action=display_room_form">Room Creation</a><p>';
		echo '<b>Observations</b><br>';
		echo '<a href="index.php?action=display_assignment_list">Observation Assignments</a><br>';
		echo '<a href="index.php?action=display_assignment_form">New Assignment</a><p>';
	}

	private function display_course_list()
	{
		$this->display_header();
		$this->get_course_list();
// loop through the array and display the individual courses and select a course to modify

		echo '<pre>';
		print_r($this->listData);
		echo '</pre>';


		unset($this->listData);
		$this->display_footer();
	}
	
	private function get_course_list()
	{
		$sSQL="SELECT * FROM system_courses ORDER BY cName";
		$build_query=$this->conn->query($sSQL);
		while($row=mysqli_fetch_array($build_query)) {
			$this->listData[$row['ID']]=array('cname' => $row['cName']);
// what other data should be displayed?
		}
	}

	private function display_course_form()
	{
		$this->display_header();
		$this->push .='		<div class="header">Course Creation</div>'."\n";
		$this->push .='		<form action="index.php" method="post">'."\n";
		$this->push .='			<input name="action" type="hidden" value="set_course_info">'."\n";
		$this->push .='			<div class = "form-group">'."\n";
		$this->push .='				<label for="subject"><b>Course: <b></label>'."\n";
		$this->push .='				<input type="text" id="subject" name="subject" placeholder=" " required>'."\n";
		$this->push .='			</div>'."\n";
		$this->push .='			<div class = "form-group">'."\n";
		$this->push .='				<label for = "professor"><b>Instructor: </b></label>'."\n";
		$this->push .='				<input type = "text" id = "professor" name="professor" placeholder=" " required>'."\n";
		$this->push .='			</div>'."\n";
		$this->push .='			<div class = "form-group">'."\n";
		$this->push .='				<label for = "professor"><b>Instructor Email: </b></label>'."\n";
		$this->push .='				<input type = "email" id = "professor" name="email" placeholder=" " required>'."\n";
		$this->push .='			</div>'."\n";
		$this->push .='			<div class = "form-group">'."\n";
		$this->push .='				<label for = "time"><b> Class Hours (optional): </b></label>'."\n";
		$this->push .='				<input type = "text" id = "hours" name="hours" placeholder=" ">'."\n";
		$this->push .='			</div>'."\n";
		$this->push .='			<div class = "form-group">'."\n";
		$this->push .='				<label for = "time"><b> Room Number (optional): </b></label>'."\n";
		$this->push .='				<input type = "text" id = "room" name="room" placeholder=" ">'."\n";
		$this->push .='			</div>'."\n";
		$this->push .='			<div class = "form-group">'."\n";
		$this->push .='				<label for = "classDay"><b> Select all days this class meets: </b></label>'."\n";
		$this->push .='				<label class="container" title="mon">'."\n";
		$this->push .='					<input type="checkbox" name="data[]" value="Monday">Monday'."\n";
		$this->push .='					<span class="checkmark"></span>'."\n";
		$this->push .='				</label>'."\n";
		$this->push .='				<label class="container" title="tues">'."\n";
		$this->push .='					<input type="checkbox" name="data[]" value="Tuesday">Tuesday'."\n";
		$this->push .='					<span class="checkmark"></span>'."\n";
		$this->push .='				</label>'."\n";
		$this->push .='				<label class="container" title="wed">'."\n";
		$this->push .='					<input type="checkbox" name="data[]" value="Wednesday">Wednesday'."\n";
		$this->push .='					<span class="checkmark"></span>'."\n";
		$this->push .='				</label>'."\n";
		$this->push .='				<label class="container" title="thurs">'."\n";
		$this->push .='					<input type="checkbox" name="data[]" value="Thursday">Thursday'."\n";
		$this->push .='					<span class="checkmark"></span>'."\n";
		$this->push .='				</label>'."\n";
		$this->push .='				<label class="container" title="fri">'."\n";
		$this->push .='					<input type="checkbox" name="data[]" value="Friday">Friday'."\n";
		$this->push .='					<span class="checkmark"></span>'."\n";
		$this->push .='				</label>'."\n";
		$this->push .='			</div>'."\n";
		$this->push .='			<p><button class="button">submit</button></p>'."\n";
		$this->push .='		</form>'."\n";
		$this->display_footer();
	}

	private function set_course_info()
	{
		$this->display_header();
// Both INSERT and UPDATE statements will go here, must determine what one will be used
		echo $this->build_request_variable('subject').'<br>';
		echo $this->build_request_variable('professor').'<br>';
		echo $this->build_request_variable('email').'<br>';
		echo $this->build_request_variable('hours'.'<br>');
		echo $this->build_request_variable('room').'<br>';
		echo '<pre>';
		print_r($this->build_request_variable('data'));
		echo '</pre>';
		$this->display_footer();
	}

	private function display_user_list()
	{
		$this->display_header();
		$this->get_user_list();


		echo '<pre>';
		print_r($this->listData);
		echo '</pre>';


		unset($this->listData);
		$this->display_footer();
	}

	private function get_user_list()
	{
		$sSQL="SELECT * FROM system_users ORDER BY lName";
		$build_query=$this->conn->query($sSQL);
		while($row=mysqli_fetch_array($build_query)) {
			$this->listData[$row['ID']]=array('name' => $row['fName'].' '.$row['lName'], 'uID' => $row['uID'], 'roleID' => $row['roleID']);
// what other data should be displayed?
		}
	}

	private function display_user_form()
	{
		$this->display_header();
		$this->push .='		<div class="header">User Creation</div>'."\n";
		$this->push .='		<form action="index.php" method="post">'."\n";
		$this->push .='			<input name="action" type="hidden" value="set_user_info">'."\n";
		$this->push .='			<div class = "form-group">'."\n";
		$this->push .='				<label for = "uID"><b>University ID: </b></label>'."\n";
		$this->push .='				<input type = "text" id = "uID" name="uID" placeholder=" " required>'."\n";
		$this->push .='			</div>'."\n";
		$this->push .='			<div class = "form-group">'."\n";
		$this->push .='				<label for = "fName"><b>First Name: </b></label>'."\n";
		$this->push .='				<input type = "text" id = "fName" name="fName" placeholder=" " required>'."\n";
		$this->push .='			</div>'."\n";
		$this->push .='			<div class = "form-group">'."\n";
		$this->push .='				<label for="subject"><b>Last Name: <b></label>'."\n";
		$this->push .='				<input type="text" id="lName" name="lName" placeholder=" " required>'."\n";
		$this->push .='			</div>'."\n";
		$this->push .='			<div class = "selectdiv">'."\n";
		$this->push .='				<label for = "userType"><b> User Role: </b></label>'."\n";
		$this->push .='				<div class="dropdown">'."\n";
		$this->push .='					<button class="userType">Observer </button>'."\n";
		$this->push .='					<div class="dropdown-content">'."\n";
		$this->push .='						<a>Observer</a>'."\n";
		$this->push .='						<a>Consultant</a>'."\n";
		$this->push .='						<a>Admin</a>'."\n";
		$this->push .='					</div>'."\n";
		$this->push .='				</div>'."\n";
		$this->push .='			</div>'."\n";
		$this->push .='			<p><button class="button">submit</button></p>'."\n";
		$this->push .='		</form>'."\n";
		$this->display_footer();
	}

	private function set_user_info()
	{
		$this->display_header();
// Both INSERT and UPDATE statements will go here, must determine what one will be used
		echo $this->build_request_variable('uID').'<br>';
		echo $this->build_request_variable('fName').'<br>';
		echo $this->build_request_variable('lName').'<br>';
		echo '<pre>';
		print_r($this->build_request_variable('data'));
		echo '</pre>';
		$this->display_footer();
	}

	private function display_room_list()
	{
		$this->display_header();
		$this->get_room_list();
// loop through the array and display the individual courses and select a course to modify

		echo '<pre>';
		print_r($this->listData);
		echo '</pre>';


		unset($this->listData);
		$this->display_footer();
	}
	
	private function get_room_list()
	{
		$sSQL="SELECT * FROM roca_rooms ORDER BY dName";
		$build_query=$this->conn->query($sSQL);
		while($row=mysqli_fetch_array($build_query)) {
			$this->listData[$row['ID']]=array('name' => $row['dName']);
// what other data should be displayed?
		}
	}

	private function display_room_form()
	{
		$this->display_header();
		$this->push .='		<div class="header">Room Creation</div>'."\n";
		$this->push .='		<form action="index.php" method="post">'."\n";
		$this->push .='			<input name="action" type="hidden" value="set_room_info">'."\n";

		$this->push .='			<p><button class="button">submit</button></p>'."\n";
		$this->push .='		</form>'."\n";
		$this->display_footer();
	}

	private function set_room_info()
	{
		$this->display_header();
// Both INSERT and UPDATE statements will go here, must determine what one will be used
		echo $this->build_request_variable('subject').'<br>';

		echo '<pre>';
		print_r($this->build_request_variable('data'));
		echo '</pre>';
		$this->display_footer();
	}

	private function display_assignment_list()
	{
		$this->display_header();
		$this->get_assignment_list();
// loop through the array and display the individual courses and select a course to modify

		echo '<pre>';
		print_r($this->listData);
		echo '</pre>';


		unset($this->listData);
		$this->display_footer();
	}
	
	private function get_assignment_list()
	{
		$sSQL="SELECT RA.ID, SU.fName, SU.lName, SC.cName";
		$sSQL .=" FROM (roca_assignments RA INNER JOIN system_users SU ON SU.ID=RA.uID)";
		$sSQL .=" INNER JOIN system_courses SC ON SC.ID=RA.cID";
		$sSQL .=" ORDER BY SC.cName";
		$build_query=$this->conn->query($sSQL);
		while($row=mysqli_fetch_array($build_query)) {
			$this->listData[$row['ID']]=array('cname' => $row['cName'], 'uname' => $row['fName'].' '.$row['lName']);
// what other data should be displayed?
		}
	}

	private function display_assignment_form()
	{
		$this->display_header();
		$this->push .='		<div class="header">New Assignment</div>'."\n";
		$this->push .='		<form action="index.php" method="post">'."\n";
		$this->push .='			<input name="action" type="hidden" value="set_assignment_info">'."\n";

		$this->push .='			<p><button class="button">submit</button></p>'."\n";
		$this->push .='		</form>'."\n";
		$this->display_footer();
	}

	private function set_assignment_info()
	{
		$this->display_header();
// Both INSERT and UPDATE statements will go here, must determine what one will be used
		echo $this->build_request_variable('subject').'<br>';

		echo '<pre>';
		print_r($this->build_request_variable('data'));
		echo '</pre>';
		$this->display_footer();
	}

	public function display_header()
	{
		$this->push='<html>'."\n";
		$this->push .='	<head>'."\n";
		$this->push .='		<title>DOTs: Course Creation</title>'."\n";
		$this->push .='		<link rel="stylesheet" href="styles/mainstyles.css">'."\n";
		$this->push .='	</head>'."\n";
		$this->push .='	<body>'."\n";
	}

	public function display_footer()
	{
		$this->push .='	<p><a href="index.php">Main Page</a>'."\n";
		$this->push .='	</body>'."\n";
		$this->push .='</html>'."\n";
		echo $this->push;
	}
}
?>