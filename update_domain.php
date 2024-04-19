<?php

/*
Dynamic DNS update script
https://github.com/antnks/dyndns_serveriai_lt
*/

// add to cron: curl 'http://server/update_domain.php?rec=domain&k=xx&i=xx'
// encrypt password: echo -n "xx" | openssl enc -aes-128-cbc -K xx -iv xx | xxd -p -c 1000000
$encryptedPass = "xx";
$allowed_domains = array("domain1", "domain2", "domain3", "domainX");
$nick = "xx";
$domain_id = "xx";

error_reporting(E_ERROR | E_PARSE);
header("Content-type: application/json");

if (!isset($_GET["rec"]))
	die("\"no domain\"");

$rec = $_GET["rec"];
$db = $rec . ".txt";

if (!in_array($rec, $allowed_domains))
	die("\"wrong domain\"");

$old_ip = "no_ip_yet_exists";
if (file_exists($db))
	$old_ip = file_get_contents($db);
$ip = $_SERVER["REMOTE_ADDR"];

if ($old_ip == $ip && !isset($_GET["force"]))
	die("");

if (!isset($_GET["k"]) || !isset($_GET["i"]))
	die("\"no keys\"");

$key = hex2bin($_GET["k"]);
$iv = hex2bin($_GET["i"]);
$password = openssl_decrypt(hex2bin($encryptedPass), "aes-128-cbc", $key, OPENSSL_RAW_DATA, $iv);
$api_url = "https://api.iv.lt/json.php?nick=$nick&password=$password&command=";

$response = file_get_contents($api_url."domain_info&id=$domain_id");
$domain = json_decode($response, true);

if(!is_array($domain["se_zone"]))
	die("\"no zone\"");

foreach ($domain["se_zone"] as &$entry)
{
	if($entry["name"] == $rec && $entry["type"] == "A")
	{
		$entry["value"] = $ip;
		break;
	}
}

$action_url = $api_url."domain_zone&id=$domain_id&zone=".urlencode(json_encode($domain["se_zone"]));
$ch = curl_init ($action_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$api_res = curl_exec($ch);
echo($api_res);

file_put_contents($db, $ip);

//mail("youremail", "serveriai_api_".$rec, $api_res);

?>

