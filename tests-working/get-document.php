<?php

//include DigiSigner library bootstrap file
require_once('../DigiSignerClient.php');

//import needed classed from DigiSigner namespace
use DigiSigner\DigiSignerClient;
use DigiSigner\DigiSignerException;


try {
	$client = new DigiSignerClient('wuurhrmmekllw');
	$client->getDocument('ecec0a68-e589-41f2-aea6-4f1926fe8525', 'data/output-doc.pdf');
	
} catch(DigiSignerException $e) {
	echo "Some exception happened...\n";
	print("Status code: " .$e->getHttpCode()."\n");
	print("Message: ".$e->getMessage()."\n");
	print("Errors:\n");
	print_r($e->getErrors());
}