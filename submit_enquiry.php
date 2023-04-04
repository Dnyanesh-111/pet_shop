<?php
// Get the form data
$name = $_POST['name'];
$email = $_POST['email'];
$number = $_POST['phone'];
$message = $_POST['message'];

// Create a new MySQLi object and connect to the database
$mysqli = new mysqli("localhost", "root", "", "pet_shop_db");

// Check for any errors with the connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

// Prepare the SQL statement
$sql = "INSERT INTO enquiries (cname, cemail, cnumber, message) VALUES (?, ?, ?, ?)";
$stmt = $mysqli->prepare($sql);

// Bind the form data to the prepared statement
$stmt->bind_param("ssss", $name, $email, $number, $message);

// Execute the statement and check for errors
if (!$stmt->execute()) {
    echo "Error: " . $stmt->error;
} else {
    // If the record is inserted successfully, call the JavaScript function to redirect the user
    echo '<script>redirectToThankYouPage();</script>';
}

// Close the statement and connection
$stmt->close();
$mysqli->close();
?>