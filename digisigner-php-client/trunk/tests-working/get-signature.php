<?php

//require main DigiSigner API class
require_once('../DigiSignerClient.php');

//import needed classed from DigiSigner namespace
use DigiSigner\DigiSignerClient;
use DigiSigner\DigiSignerException;

try {
	
	$client = new DigiSignerClient('e86e6341-a88d-4f21-8805-41ec522e0613');
	
	$signatureRequest = $client->getSignatureRequest('ce63b02b-0cb2-47c5-b0cd-a92c7ebea616');
	
	print_r($signatureRequest);
			
} catch(DigiSignerException $e) {
	echo "Some exception happened...\n";
	print("Status code: " .$e->getHttpCode()."\n");
	print("Message: ".$e->getMessage()."\n");
	print("Errors:\n");
	print_r($e->getErrors());
} 
	