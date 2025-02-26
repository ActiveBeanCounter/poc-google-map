<?php
$conn = new mysqli("localhost", "root", "", "osm");

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$country = $_POST['country'];
$postal_code = $_POST['postal_code'];
$lat = $_POST['lat'];
$lon = $_POST['lon'];

$sql = "INSERT INTO addresses (address, city, state, country, postal_code, latitude, longitude) 
        VALUES ('$address', '$city', '$state', '$country', '$postal_code', '$lat', '$lon')";

if ($conn->query($sql) === TRUE) {
    echo "Address saved successfully!";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>