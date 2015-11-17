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
	$client = new DigiSignerClient('YOUR_DIGISIGNER_API_KEY');
	
	$request = new SignatureRequest;
	
	$document = new Document('data/pdf-sample.pdf');
	$document->setMessage('Hello world!');
	$document->setSubject('Please, sign my sample document!');
	
	$signer1 = new Signer('signer@email.com');
	$field1 = new Field(0, array(10,20,40,50), Field::TYPE_DATE);
	$signer1->addField($field1);
	$field2 = new Field(15, array(100,23,45,55), Field::TYPE_SIGNATURE);
	$field2->setContent('Signature Content');
	$signer1->addField($field2);
	$signer1->setRole('SomeRole');
	
	$document->addSigner($signer1);
	
	$signer2 = new Signer('super2@email.com');
	$field1 = new Field(3, array(10,20,45,5), Field::TYPE_TEXT);
	$signer2->addField($field1);
	$field2 = new Field(1, array(100,23,45,55), Field::TYPE_INITIALS);
	$signer2->addField($field2);
	$signer2->setRole('SomeOtherRole');
	
	$document->addSigner($signer2);
	
	$request->addDocument($document);
	
	$request->setEmbedded(false);
	$request->setSendEmails(true);
	$request->setRedirectForSigningToUrl('http://myredirecturl.com/');
	$request->setUseTextTags(true);
	$request->setHideTextTags(true);
	
	$signatureRequest = $client->sendSignatureRequest($request);

	print_r($signatureRequest);
		
} catch(DigiSignerException $e) {
	echo "Some exception happened...\n";
	print("Status code: " .$e->getHttpCode()."\n");
	print("Message: ".$e->getMessage()."\n");
	print("Errors:\n");
	print_r($e->getErrors());
} 





