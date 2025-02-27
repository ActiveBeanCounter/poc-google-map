<?php
$url = 'https://api.olamaps.io/places/v1/autocomplete?input=kempe=' . $_GET['query'];

$headers = array(
    'Content-Type: application/json'
);
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$response = curl_exec($ch);
curl_close($ch);
echo $response;
?>