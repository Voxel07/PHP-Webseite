<?php
$bot_id = "1110152728:AAGN7dEFg4pun2b6zvWBuMwtZUbcGT_XpJ0";
$json_raw = file_get_contents("php://input");
$json_out = json_decode($json_raw);


$ch = curl_init("https://api.telegram.org/bot" . $bot_id . "/setWebhook");
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);

$param = array(
 "url" => "wrw.ddns.net"
);

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param));

$result = curl_exec($ch);
curl_close($ch);

echo $result . "\n<hr />OK";

?>