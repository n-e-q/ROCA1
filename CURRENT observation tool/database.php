<?php
class dataConnection
{
    public $conn;
    
    public function data_connection()
    {
        $this->conn=new mysqli("localhost", "dot_user", "Vb5YDh4m00!hjtNY7*^", "DOTs");
        if ($this->conn->connect_errno) {
            echo "Dalton sucks...";
            exit;
        }
    }
    
    
    // used just to pass safe data to database
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
    // used just to pass clean data to database
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
    // used just to pass clean data to database
    /*protected function format_html_text($_val)
    {
        $_val=str_replace("'", "&#39;", $_val);
        $_val=str_replace(''', "&lsquo;", $_val);
                                $_val=str_replace(''', "&rsquo;", $_val);
        $_val=str_replace('-', "&ndash;", $_val);
        $_val=str_replace('"', "&ldquo;", $_val);
        $_val=str_replace('"', "&rdquo;", $_val);
        
        return $_val;
    }*/
    
    public function close_connection()
    {
        $this->conn->close();
    }
}

function getfromcodebank($cID) {
    $dc = new dataConnection;
    $dc->data_connection();
    $query = "SELECT * FROM code_bank WHERE cID=" . $cID;
    
    $result = mysqli_query($dc->conn, $query) or die(mysqli_error($dc->conn));
    
    while($row = mysqli_fetch_array($result)){
        /*echo "<option value='".$row['dName']."'</option>";*/
        if($cID < 5){
            echo "<a onclick='dataToFeed(event, this)'>" . $row['dName'] . "</a>";
        }
        else {
            echo "<label class='container' title=" . $row['dName'] . ">
								<input type='checkbox'>" . $row['code'] .
								"<span class='checkmark'></span></label>";
        }
        /*echo json_encode($row['dName']);*/
    }
    
    $dc->close_connection();
}
 ?>