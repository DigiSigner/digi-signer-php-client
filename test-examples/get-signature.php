<?php

//require main DigiSigner API class
require_once('../DigiSignerClient.php');

//import needed classed from DigiSigner namespace
use DigiSigner\DigiSignerClient;
use DigiSigner\DigiSignerException;



try {
	//you can find your API key find in the settings of your DigiSigner account
	$client = new DigiSignerClient('YOUR_DIGISIGNER_API_KEY');
	
	//see signature-request.php to learn how to obtain YOUR_SIGNATURE_REQUEST_ID
	$signatureRequest = $client->getSignatureRequest('YOUR_SIGNATURE_REQUEST_ID');
	
	print_r($signatureRequest);
			
} catch(DigiSignerException $e) {
	echo "Some exception happened...\n";
	print("Status code: " .$e->getHttpCode()."\n");
	print("Message: ".$e->getMessage()."\n");
	print("Errors:\n");
	print_r($e->getErrors());
} 
	