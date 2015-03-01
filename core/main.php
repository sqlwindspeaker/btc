<?php

require_once("../../apikey.php");



//$params = array("symbol" => "btc_cny");
//$ch = curl_init();
$headers = array("User-Agent: OKCoinPHP/v1");
//curl_setopt($ch, CURLOPT_URL, "https://www.okcoin.cn/api/v1/ticker.do?" . http_build_query($params));
//curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//curl_setopt($ch, CURLOPT_HEADER, false);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//
//$response = curl_exec($ch);
//// Check for errors
//if ($response === false) {
//    $error = curl_errno($ch);
//    $message = curl_error($ch);
//} else {
//    // Check status code
//    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//    echo $statusCode . "\n";
//    if (IntVal($statusCode) === 200) {
//        $data = json_decode($response);
//    }
//}
//
//$price = $data->ticker->last;
//
//$params = array(
//    "symbol" => "btc_cny",
//    "type" => "1hour",
//    "size" => "1"
//);
//
//curl_setopt($ch, CURLOPT_URL, "https://www.okcoin.cn/api/v1/kline.do?" . http_build_query($params));
//
//$response = curl_exec($ch);
//// Check for errors
//if ($response === false) {
//    $error = curl_errno($ch);
//    $message = curl_error($ch);
//    curl_close($ch);
//} else {
//    // Check status code
//    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//    curl_close($ch);
//    echo $statusCode . "\n";
//    if (IntVal($statusCode) === 200) {
//        $data = json_decode($response);
//    }
//}
//print_r($data);
//print_r($response);



$ch = curl_init();

$auth = new stdClass;
$auth->apiKey = $GLOBALS["apiKey"];
$auth->secretKey = $GLOBALS["secretKey"];


//$params = array("api_key" => $auth->apiKey);
$params = array('api_key' => $auth->apiKey, 'symbol' => 'btc_usd', 'contract_type' => 'this_week', 'price' => '256.04', 'amount' => '1.1', 'type' => '3', 'lever_rate' => '10', 'match_price' => '0');
ksort($params);

$sign = "";
while ($key = key($params)) {
    $sign .= $key . "=" . $params[$key] . "&";
    next($params);
}

echo $sign . "\n";
$sign .= "secret_key=" . $auth->secretKey;
$params["sign"] = strtoupper(md5($sign));

curl_setopt($ch, CURLOPT_URL, "https://www.okcoin.com/api/v1/future_trade.do");
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$response = curl_exec($ch);
// Check for errors
if ($response === false) {
    $error = curl_errno($ch);
    $message = curl_error($ch);
    curl_close($ch);
} else {
    // Check status code
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    echo $statusCode . "\n";
    if (IntVal($statusCode) === 200) {
        $data = json_decode($response);
    }
}
print_r($data);
print_r($response);
