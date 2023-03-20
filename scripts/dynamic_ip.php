<?php
// Dynamic Ip to domain updater Using Cloudflare DNS
// Script made by Jamey J. Jager
//FRITZBOX URL: http://192.168.x.x/?ip=<ipaddr> // the IP ADDRESS OF THE WEBSERVER and needs to be placed inside the fritz configuration
//
$ipv4=$_GET["ip"];
// $ipv4="173.16.248.21" // or set a static by uncommenting this variable;
$editZoneDnsToken=""; //Insert zour cloudflare dns TOKEN
$proxy=true;
ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);


function cf_curl($url, $post = false, $put = false) {

    $cf_key = $editZoneDnsToken;

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://api.cloudflare.com/client/v4/".$url);

    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);

    if($put) curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$cf_key, 'Content-Type: application/json'));

    if($post) curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);



    $response = json_decode(curl_exec($ch), true);

    curl_close($ch);

    return $response;

}
$dateA=date('n/j/Y H:i:s');

file_put_contents("log.txt","[$dateA]\n",FILE_APPEND);
function wlog($error, $msg) {

    file_put_contents("log.txt","$error$msg\n",FILE_APPEND);
}

$auth = cf_curl("zones");

//echo print_r($auth);

//LIST OF DOMAIN NAMES TO UPDATE
$domainList=["example.com","anotherdomain.com","mythird.lu","test.com"];



if(!$auth["success"]) { wlog("ERROR: ","Cloudflare authentication failed: ".$auth["errors"][0]["message"]); wlog("INFO: ","Script aborted"); die; } else wlog("INFO: ","Cloudflare authentication successful");


foreach($domainList as $domain) {
    $response = cf_curl("zones?name=".$domain."&status=active");

    $zone = $response["result"][0]["id"];

    $response = cf_curl("zones/".$zone."/dns_records?name=".$domain);

    $response = $response["result"];

    
    if(!$response){
        wlog("ERROR: ", "No record found for $domain\n");
    }
    else{
        wlog("INFO:","Trying to update $domain to $ipv4\n");
        foreach($response as $record) {
            if($ipv4 == $record["content"]) { wlog("WARNING: ","Skipped record, because ipv4 is already up-to-date.\n"); continue; }

            if($record["type"] == "A"){
                $response = cf_curl("zones/".$zone."/dns_records/".$record["id"], array("type" => "A", "name" => $domain, "content" => $ipv4, "ttl" => 120, "proxied" => $proxy ), true);
                wlog("SUCCESS:","Updated $domain to $ipv4\n");
            }
        }

    }
 
}
$dateA=date('n/j/Y H:i:s');
wlog("END: [",$dateA."]\n-----------------------------------------------------------\n\n");
exit(0);