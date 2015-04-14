<?php

//include DigiSigner library bootstrap file
require_once('../DigiSignerClient.php');

//import needed classed from DigiSigner namespace
use DigiSigner\DigiSignerClient;
use DigiSigner\DigiSignerException;


try {
	$client = new DigiSignerClient('e86e6341-a88d-4f21-8805-41ec522e0613');
	$client->getDocument('946fb803-012f-4a7a-bac0-1fb25e3e9e68', 'data/output-doc.pdf');
	
} catch(DigiSignerException $e) {
	echo "Some exception happened...\n";
	print("Status code: " .$e->getHttpCode()."\n");
	print("Message: ".$e->getMessage()."\n");
	print("Errors:\n");
	print_r($e->getErrors());
}