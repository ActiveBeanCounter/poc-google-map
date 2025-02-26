<?php
session_start();

if (!isset($_SESSION['address_data'])) {
    die("No address data found.");
}

$data = $_SESSION['address_data'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Address</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .container {
            width: 50%;
            margin: 20px auto;
            border: 1px solid #ccc;
            padding: 20px;
            background: #f9f9f9;
        }
        button {
            padding: 10px 15px;
            margin-top: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Confirm Address</h2>
        <p><strong>Address:</strong> <?= htmlspecialchars($data['address']) ?></p>
        <p><strong>City:</strong> <?= htmlspecialchars($data['city']) ?></p>
        <p><strong>State:</strong> <?= htmlspecialchars($data['state']) ?></p>
        <p><strong>Country:</strong> <?= htmlspecialchars($data['country']) ?></p>
        <p><strong>Postal Code:</strong> <?= htmlspecialchars($data['postal_code']) ?></p>

        <form action="save_address.php" method="POST">
            <input type="hidden" name="confirm" value="1">
            <button type="submit">Confirm & Add</button>
        </form>
        <br>
        <a href="index.php"><button>Cancel</button></a>
    </div>
</body>
</html>
