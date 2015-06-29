<?php

//require main DigiSigner API class
require_once('../DigiSignerClient.php');

//import needed classed from DigiSigner namespace
use DigiSigner\DigiSignerClient;
use DigiSigner\SignatureRequest; 
use DigiSigner\DigiSignerException;
use DigiSigner\Document;
use DigiSigner\Signer;
use DigiSigner\Field;


try {
	//you can find your API key find in the settings of your DigiSigner account
	$client = new DigiSignerClient('wuurhrmmekllw');
	
	$request = new SignatureRequest;
	
	$document = new Document('data/tags.pdf');
	$document->setMessage('Hello world!');
	$document->setSubject('Please, sign my sample document!');
	
	$signer1 = new Signer('dmitry.lakhin@gmail.com');
	$field1 = new Field(0, array(100,100,300,200), Field::TYPE_SIGNATURE);
	$signer1->addField($field1);
	//$signer1->setRole('a');
		
	$document->addSigner($signer1);
		
	$request->addDocument($document);
	
	//if these methods are not called, nothing but documents is included to JSON request
	$request->setEmbedded(false);
	$request->setSendEmails(true);
	//$request->setRedirectForSigningToUrl('http://myredirecturl.com/');
	//$request->setUseTextTags(true);
	//$request->setHideTextTags(true);
	
	$signatureRequest = $client->sendSignatureRequest($request);

	print_r($signatureRequest);
		
} catch(DigiSignerException $e) {
	echo "Some exception happened...\n";
	print("Status code: " .$e->getHttpCode()."\n");
	print("Message: ".$e->getMessage()."\n");
	print("Errors:\n");
	print_r($e->getErrors());
} 





