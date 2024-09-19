<?php
// Assum you have a function to connect to your database

function connectToDatabase(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "rns";
    $conn = new mysqli($servername, $username , $password , $dbname);
    
    if($conn -> connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "connected ";
    return $conn;

}
// connectToDatabase();

// function to execute a query and return the result
function executeQuery($conn , $query) {
    $result = $conn->query($query);
    return $result;
}

// function to display data or a message
function displayDateOrMessage($query){
    // Connect to the database
    $conn = connectToDatabase();

    // Execute the query
    $result = executeQuery($conn,$query);

    // Check if data is found
    if ($result && result->num_rows > 0) {
        // Fetvh and display the data
        while ($row = $result->fetch_assoc() ) {
            echo "Data found: " . $row["column_name"] . "<br>";
        }
    }else {
        // Display a message indicating that data is not found
        echo "Data not found";
    }
}
?>