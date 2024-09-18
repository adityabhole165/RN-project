<?php
session_start();
// Database connection
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

$menuID = $conn->real_escape_string($data['MenuID']);
$menuName = $conn->real_escape_string($data['MenuName']);
$description = $conn->real_escape_string($data['Description']);
$rate = $conn->real_escape_string($data['Rate']);
$quantity = $conn->real_escape_string($data['Quantity']);
$amount = $conn->real_escape_string($data['Amount']);
$menuTypeId = $conn->real_escape_string($data['MenuTypeID']);

// First delete the existing record with the given MenuID
$sql_delete = "DELETE FROM menu_items WHERE MenuID = '$menuID' AND MobileNo='$mobile'";

if ($conn->query($sql_delete) === TRUE) {
    // After deleting, insert the new record
    $sql_insert = "INSERT INTO menu_items (MenuID, MenuName, Description, Rate, Quantity, Amount, MenuTypeID, MobileNo)
    VALUES ('$menuID', '$menuName', '$description', '$rate', '$quantity', '$amount', '$menuTypeId', '$mobile')";

    if ($conn->query($sql_insert) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Record updated successfully']);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

// Close connection
$conn->close();
?>
