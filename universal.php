<?php
class dataConnection extends collabConnection
{
	protected $conn;

	protected function data_connection()
	{
		$this->conn=new mysqli("localhost", "dot_user", "Vb5YDh4m00!hjtNY7*^", "DOTs");
		if ($this->conn->connect_errno) {
			echo "Failed to connect to database...";
			exit;
		}
	}

	protected function safe_data_entry($_val, $_type) 
	{
		switch ($_type) {
			case "text":
				$_val=(!empty($_val)) ? "'".$this->format_data_text($_val)."'" : "NULL";
				break;
			case "html_text":
				$_val=(!empty($_val)) ? "'".$this->format_html_text($_val)."'" : "NULL";
				break;
			case "int":
				$_val=((!empty($_val)) && (is_numeric($_val))) ? intval($_val) : "0";
				break;
			case "double":
				$_val=(!empty($_val)) ? "'".doubleval($_val)."'" : "0";
				break;
			case "date":
				$_val = ($_val != "") ? "'" . $_val . "'" : "NULL";
				break;
		}

		return $_val;
	}

	protected function format_data_text($_val)
	{
		$_val=str_replace("\'", "&#39;", $_val);
		$_val=str_replace('\"', "&quot;", $_val);
		$_val=str_replace("'", "&#39;", $_val);
		$_val=str_replace('"', "&quot;", $_val);
	
		$search=array('@<script[^>]*?>.*?</script>@si','@<style[^>]*?>.*?</style>@siU','@<[\/\!]*?[^<>]*?>@si','@<![\s\S]*?--[ \t\n\r]*>@');
		$_val=preg_replace($search, '', $_val);
		$_val=str_replace('<', '&lt', $_val);
		$_val=str_replace('>', '&gt', $_val);
	
		$_val=$this->format_html_text($_val);
	
		return $_val;
	}
	
	protected function format_html_text($_val)
	{
		$_val=str_replace("'", "&#39;", $_val);
		$_val=str_replace('‘', "&lsquo;", $_val);
		$_val=str_replace('’', "&rsquo;", $_val);
		$_val=str_replace('—', "&ndash;", $_val);
		$_val=str_replace('“', "&ldquo;", $_val);
		$_val=str_replace('”', "&rdquo;", $_val);
	
		return $_val;
	}

	protected function build_request_variable($request, $isNumeric=0)
	{
		$return=(isset($_GET[$request])) ? $_GET[$request] : '';

		if (empty($return)) $return=(isset($_POST[$request])) ? $_POST[$request] : '';
		if (!empty($isNumeric)) $return=(is_numeric($return)) ? $return : 0;
	
		return $return;
	}

	protected function display_error($message)
	{
		$this->display_header();
		$this->push .='	<div style="max-width: 800px; padding: 6px 5px 3px 5px; font-size: 9pt; font-family: Arial, Verdana, Helvetica;">'."\n";
		$this->push .='		<div style="min-height: 15px; padding: 3px 5px 3px 5px; background-color: #CCFFFF; border-left: solid 1px #333333; border-top: solid 1px #333333; border-right: solid 1px #333333;">'."\n";
		$this->push .='			<div style="font-weight: bold;">Error Message</div>'."\n";
		$this->push .='		</div>'."\n";
		$this->push .='		<div style="border: solid 1px #333333; padding: 6px 5px 3px 5px; font-size: 9pt; font-family: Arial, Verdana, Helvetica; margin-bottom: 15px;">'."\n";
		$this->push .=			$message."\n";
		$this->push .='		</div>'."\n";
		$this->push .='	</div>'."\n";
		$this->display_footer();
		exit;
	}

	public function close_connection()
	{
		$this->conn->close();
	}
}

class collabConnection
{
	protected function bind_session()
	{
		$context=new BLTI("L1f30nGrndzIsc00l", false, false);
		if ($context->valid) {
			$_SESSION['bind']=array(
				'eid' => $_POST['context_id'],
				'uid' => $_POST['ext_sakai_eid'],
				'fn' => $_POST['lis_person_name_given'],
				'ln' => $_POST['lis_person_name_family'],
				'uc' => $_POST['user_id'],
				'role' => $_POST['ext_sakai_role']
			);
		} else if (!isset($_SESSION['bind'])) {
			$this->display_error('The Collab Tool you are trying to connect to is no longer available. Please try and refresh the page, or contact us at <a href="mailto:seas-dats@virginia.edu" style="color: #0033CC; text-decoration: none;">seas-dats@virginia.edu</a> if you are still receiving this error so we may assist you.');
		}
	}
}
?>