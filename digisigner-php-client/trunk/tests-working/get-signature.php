<?php

//require main DigiSigner API class
require_once('../DigiSignerClient.php');

//import needed classed from DigiSigner namespace
use DigiSigner\DigiSignerClient;
use DigiSigner\DigiSignerException;

try {
	
	$client = new DigiSignerClient('wuurhrmmekllw');
	
	$signatureRequest = $client->getSignatureRequest('4e20618d-ae89-4f23-89d1-f42df6ef01ac');
	
	print_r($signatureRequest);
			
} catch(DigiSignerException $e) {
	echo "Some exception happened...\n";
	print("Status code: " .$e->getHttpCode()."\n");
	print("Message: ".$e->getMessage()."\n");
	print("Errors:\n");
	print_r($e->getErrors());
} 
	