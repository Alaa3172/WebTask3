<?php
// Connect to MySQL
$servername = "localhost";
$username = "root"; // Default username
$password = ""; // Default password, if any
$dbname = "robot_control"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // If connection fails, output an error message and terminate script
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission when the HTTP method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $direction = $_POST["direction"]; // Retrieve direction value from POST data

    // Insert into database
    $sql = "INSERT INTO directions (direction) VALUES ('$direction')";

    // Execute SQL query and check if successful
    if ($conn->query($sql) === TRUE) {
        // If insertion is successful, output success message
        echo "Direction recorded successfully.";
    } else {
        // If there is an error with the SQL query, output error message
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection to MySQL
$conn->close();
?>
