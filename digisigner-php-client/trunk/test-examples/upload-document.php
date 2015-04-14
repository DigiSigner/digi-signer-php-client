<?php

require_once('../DigiSignerClient.php');

//import needed classed from DigiSigner namespace
use DigiSigner\DigiSignerClient;
use DigiSigner\DigiSignerException;


try {
	//you can find your API key find in the settings of your DigiSigner account
	$client = new DigiSignerClient('YOUR_DIGISIGNER_API_KEY');
	
	$document = $client->uploadDocument('data/pdf-sample.pdf');
	
	printf("Document ID: %s\n", $document->getId());
	
} catch(DigiSignerException $e) {
	echo "Some exception happened...\n";
	print("Status code: " .$e->getHttpCode()."\n");
	print($e->getMessage()."\n");
	print("Errors: " .print_r($e->getErrors())."\n");
} 
