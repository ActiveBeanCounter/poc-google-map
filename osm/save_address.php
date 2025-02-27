<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['confirm'])) {
    $_SESSION['address_data'] = [
        'address' => $_POST['address'],
        'city' => $_POST['city'],
        'state' => $_POST['state'],
        'country' => $_POST['country'],
        'postal_code' => $_POST['postal_code'],
        'lat' => $_POST['lat'],
        'lon' => $_POST['lon']
    ];
    
    // Redirect to confirmation page
    header("Location: confirm.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ola";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If coming from confirmation page, insert into database
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
    if (!isset($_SESSION['address_data'])) {
        die("No address data found.");
    }

    $data = $_SESSION['address_data'];

    $sql = "INSERT INTO addresses (full_address, city, state, country, postal_code)
            VALUES ('{$data['address']}', '{$data['city']}', '{$data['state']}', '{$data['country']}', '{$data['postal_code']}')";

    if ($conn->query($sql) === TRUE) {
        unset($_SESSION['address_data']); // Clear session after saving
        header("Location: index.php"); 
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
