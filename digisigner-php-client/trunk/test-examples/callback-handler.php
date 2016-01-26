<?php

//require main DigiSigner API class
require_once('../DigiSignerClient.php');

//import needed classed from DigiSigner namespace
use DigiSigner\SignatureRequest;


// note, $_POST array in PHP cannot be populated with application/json data,
// as it only accepts HTTP url-encoded payload
// thus, you must read from the raw input 
$raw_json = file_get_contents('php://input');

const CONFIRMATION_TEXT = "DIGISIGNER_EVENT_ACCEPTED";

if(!empty($raw_json)) {
	$json = json_decode($raw_json);
	
	//init empty $signatureRequest
	$signatureRequest = new SignatureRequest;

	//populate it from the $json data	
	$signatureRequest->fromObject($json->signature_request);
	
	//get what you need:
	$signatureRequest->getDocuments();

	// Send only confirmation message with status OK (200), if got callback result.
	echo CONFIRMATION_TEXT;
} else {
	//log that nothing interesting came in input
}