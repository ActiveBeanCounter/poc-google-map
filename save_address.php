<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "google_map";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

$place_id = $_POST['place_id'];
$address = $_POST['address'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$city = $_POST['city'];
$state = $_POST['state'];
$country = $_POST['country'];
$postal_code = $_POST['postal_code'];

$sql = "INSERT INTO addresses (place_id, address, latitude, longitude, city, state, country, postal_code)
 VALUES ('$place_id', '$address', '$latitude', '$longitude', '$city', '$state', '$country', '$postal_code')";

if ($conn->query($sql) === TRUE) {
    echo "Address saved successfully!";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>