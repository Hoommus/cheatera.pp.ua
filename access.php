<?php

  $_SESSION['api_rd'] = "https://api.intra.42.fr/oauth/authorize?client_id=cd246e491edfbd25e7ed90b4cd8194468e71fe174c50d89734ba80f9090b72ed&redirect_uri=https%3A%2F%2Fcheatera.pp.ua%2Faccess.php&response_type=code";

if ($_GET['error'] && $_GET['error'] == 'access_denied')
{
  header("Location: " . $_SESSION['api_rd']);
}
else if (isset($_GET['code']))
{
  session_start();

$authorizeUrl = 'https://api.intra.42.fr/oauth/authorize';
$accessTokenUrl = 'https://api.intra.42.fr/oauth/token';
$clientId = '';
$clientSecret = '';
$userAgent = '';

$redirectUrl = "https://cheatera.pp.ua/access.php";

include("OAuth2/Client.php");
include("OAuth2/GrantType/IGrantType.php");
include("OAuth2/GrantType/AuthorizationCode.php");

$client = new OAuth2\Client($clientId, $clientSecret, OAuth2\Client::AUTH_TYPE_AUTHORIZATION_BASIC);
$client->setCurlOption(CURLOPT_USERAGENT,$userAgent);

$params = array("code" => $_GET["code"], "redirect_uri" => $redirectUrl);
$response = $client->getAccessToken($accessTokenUrl, "authorization_code", $params);

$accessTokenResult = $response["result"];
$client->setAccessToken($accessTokenResult["access_token"]);
$client->setAccessTokenType(OAuth2\Client::ACCESS_TOKEN_BEARER);

$response = $client->fetch("https://api.intra.42.fr/v2/me");
  $res = $response['code'];
file_put_contents("../../logs/".$res, print_r($client, true));
if ($res != 200) {
  header("Location: https://cheatera.pp.ua");
  exit ;
}
  @include 'duty/db.php';
  $_SESSION['cheat'] = session_id();
  $_SESSION['xlogin'] = $response['result']['login'];
  setcookie("xlogin", $response['result']['login'], time() + 3600, '/');
  $result4 = $conn->query("INSERT INTO log (xlogin, auth_date, ip, agent) VALUES (\"" . $response['result']['login'] . "\", NOW(), \"" . $_SERVER['REMOTE_ADDR'] . "\", \"" . $_SERVER['HTTP_USER_AGENT'] . "\") ;");
  file_put_contents("../../logs/" . $_SERVER['REMOTE_ADDR'] . "-". date("H:i:s") . "-".  date("d F Y") . "-".  time() , serialize($response));
  header("Location: http://cheatera.pp.ua/");
}
else {
  header("Location: " . $_SESSION['api_rd']);
}
?>
