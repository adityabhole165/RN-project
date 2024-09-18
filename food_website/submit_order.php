<?php
 session_start();


$servername = "localhost"; // Update with your server name
$username = "root"; // Update with your database username
$password = ""; // Update with your database password
$dbname = "restaurant_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$mobile = $_SESSION['mobile'];

// Get the POST data
$data = json_decode(file_get_contents('php://input'), true);

$menuId =$conn->real_escape_string($data['MenuId']);
$menuName = $conn->real_escape_string($data['MenuName']);
$description = $conn->real_escape_string($data['Description']);
$rate = $conn->real_escape_string($data['Rate']);
$quantity = $conn->real_escape_string($data['Quantity']);
$amount = $conn->real_escape_string($data['Amount']);
$menuTypeID = $conn->real_escape_string($data['MenuTypeID']);

// Prepare and execute the SQL statement
$sql = "INSERT INTO menu_items (MenuID,MenuName, Description, Rate, Quantity, Amount, MenuTypeID, MobileNo)
        VALUES ('$menuId','$menuName', '$description', '$rate', '$quantity', '$amount', '$menuTypeID','$mobile')";

        // echo $sql;
        if ($conn->query($sql) === TRUE) {
            $menuID = $conn->insert_id;
            echo json_encode(['success' => true, 'menuID' => $menuID]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }


// Close connection
$conn->close();
?>
