<?php

$cURLConnection = curl_init();

curl_setopt($cURLConnection, CURLOPT_URL, 'https://api.binance.com/api/v3/ticker/24hr');
curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

$jsonRes = curl_exec($cURLConnection);
curl_close($cURLConnection);

// print_r($jsonArrayResponse = json_decode($jsonRes));
// echo "<hr><br>";
print_r($jsonRes);