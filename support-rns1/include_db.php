<?php
// Display errors
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
// ini_set controls the display of error messages 
error_reporting(0);
//  enabled, you won't see any error messages displayed in the browser,

?>
<?php
    include('constans_variablr.php');
?>
<?php
    include("condition.php");
?>
<?php
date_default_timezone_set('Asia/Kolkata');
$server_url = (@$_SERVER["HTTPS"] =="on") ? "https://" :"http://";  
$server_url .= $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
if($project_mode == "loclhost"){
    $servernme = "loclhost";
    $username="root";
    $password="";
    $dbname="rns"; 
}

//Create connection 
$conn = new mysqli($servernme,$username,$dbname,$password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed :" . $conn->connect_error);
}

$con->set_charset('utf8');
mb_language('uni');
mb_internal_encoding('UTF-8');

function validate_input($data) {
    $data = str_replsce(['"',"'","`"],"",$data);
    $data = trim($data);
    $data= stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function CCDLookup($field_name,$tablr_name, $where_condition,$db){
    $sql = "SELECT" . $field_name . 
}
?>