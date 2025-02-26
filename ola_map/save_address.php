<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ola";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$country = $_POST['country'];
$postal_code = $_POST['postal_code'];

// Insert into database
$sql = "INSERT INTO addresses (full_address, city, state, country, postal_code)
        VALUES ('$address', '$city', '$state', '$country', '$postal_code')";

if ($conn->query($sql) === TRUE) {
    echo "Address saved successfully.";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
