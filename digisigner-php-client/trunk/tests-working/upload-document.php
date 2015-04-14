<?php

require_once('../DigiSignerClient.php');

//import needed classed from DigiSigner namespace
use DigiSigner\DigiSignerClient;
use DigiSigner\DigiSignerException;


try {
	$client = new DigiSignerClient('e86e6341-a88d-4f21-8805-41ec522e0613');
	$document = $client->uploadDocument('data/pdf-sample.pdf');
	
	printf("Document ID: %s\n", $document->getId());
	
} catch(DigiSignerException $e) {
	echo "Some exception happened...\n";
	print("Status code: " .$e->getHttpCode()."\n");
	print($e->getMessage()."\n");
	print("Errors: " .print_r($e->getErrors())."\n");
} 
