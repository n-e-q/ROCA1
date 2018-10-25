<?php
session_start();
require_once('universal.php');
new rocaR_Dashboard();


class rocaR_Dashboard extends dataConnection
{
	private $tDate;
	private $cTime;
	private $pTime;
	protected $action='';
	protected $fData='';
	public $listData=array();
	
	public function __construct()
	{
		$this->bind_session();
		$this->tDate=mktime(0, 0, 0, date('n'), date('j'), date('Y'));
		$this->cTime=mktime(date('G'), date('i'), 0, 1, 1, 2000);
		$this->pTime=mktime(date('G'), date('i'), date('s'), 1, 1, 2000); 
		$this->data_connection();
		if (empty($_SESSION['bind']['sid'])) $this->get_active_user();
		$this->get_user_privileges();
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
// OTHER ADMIN CASES GO HERE



			default:
//				$this->display_admin_panel();
				break;		
		}
	}
	
	private function display_course_list()
	{
		$this->get_course_list();
// loop through the array and display the individual courses and select a course to modify

		unset($this->listData);
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
// Course from will go here

	}

	private function set_course_info()
	{
// Both INSERT and UPDATE statements will go here, must determine what one will be used

	}
}
?>