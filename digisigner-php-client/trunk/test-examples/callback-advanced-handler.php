<?php

//require main DigiSigner API class
require_once('../DigiSignerClient.php');

//import needed classed from DigiSigner namespace
use DigiSigner\SignatureRequest;
use DigiSigner\DigiSignerException;


// note, $_POST array in PHP cannot be populated with application/json data,
// as it only accepts HTTP url-encoded payload
// thus, you must read from the raw input 
$raw_json = file_get_contents('php://input');

if(!empty($raw_json)) {

	try {
	
		$event = new DigiSignerEvent($raw_json);
		
		$signatureRequest = $event->getSignatrueRequest();
		
		foreach($signatureRequest->getDocuments() as $document) {
			foreach($document->getSigners() as $signer) {
				echo $signer->getEmail(), '; ';
				
			}
		}
		
	} catch(DigiSignerException $e) {
		echo "Some exception happened...\n";
		print("Status code: " .$e->getHttpCode()."\n");
		print("Message: ".$e->getMessage()."\n");
		print("Errors:\n");
		print_r($e->getErrors());
	}
	
	
} else {
	//log that nothing interesting came in input
}


/**
 * ===================================
 * Definitions
 * ===================================
 */
class DigiSignerEvent {
	
	private $raw_input = null;
	
	private $json = null;
	
	const STATUS_SUCCESS = "SIGNATURE_REQUEST_COMPLETED";
	
	public function __construct($raw_input) {
		$this->raw_input = $raw_input;
		
		if(!empty($this->raw_input)) {
			$this->json = json_decode($this->raw_input);
			
			if(empty($this->json->event_type) or $this->json->event_type != self::STATUS_SUCCESS) {
				throw new DigisignerException("Bad input. Sigature request is not completed.");
			}
			
		} else {
			throw new DigisignerException("Empty input");
		}
		 
	}
	
	public function getSignatrueRequest() {
		$request = new SignatureRequest;
		$request->fromObject($this->json->signature_request);
		return $request;		
	}
}
