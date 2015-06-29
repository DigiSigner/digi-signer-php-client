<?php
/**
 * DigiSigner Client Library
 * v.0.2.4
 * Requires:
 * - PHP version >= 5.3.0
 * - php curl module;
 */
namespace DigiSigner;

//includes autoloader, which will take care about the rest of the classes
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'ClassLoader.php');


/**
 * Main class for DigiSigner client. Provides interface for necessary actions accessible
 * to the API user.
 */
 
class DigiSignerClient {
	
    private $api_key = '';
	
	/**
	 * @param String $api_key obtained from DigiSigner.com
	 */

    public function __construct($api_key) {
        $this->api_key = $api_key;
    }
	
	protected function getRequest() {
		
		return new BaseRequest($this->api_key);
	}
	

	/**
	 * Saves document to specified location
	 * @param String $document_id
	 * @param Local path to save the document
	 * @return void
	 */
	public function getDocument($document_id, $dest_file_path) {

		$this->getRequest()->getFileResponse($document_id, $dest_file_path);
	}
	
	/**
	 * Uploads given file to DigiSigner from specified location 
	 * @param String - local path to document file
	 * @return 
	 */
	
 	public function uploadDocument($path_to_document) {
 		
		$document = new Document($path_to_document);
		
		return $this->getRequest()->uploadDocument($document);
		
	}
	
	/**
	 * Accepts prepared SignatureRequest data and executes it
	 * @param SignatuireRequest object
	 * @return SignatuireRequest object populated with ID, if successful
	 * @throws If now success, a DigiSignerException will be thrown
	 */
	
	public function sendSignatureRequest(SignatureRequest $request) {
		
		return $this->getRequest()->sendSignatureRequest($request);
	}
	
	/**
	 * Fetches SignatureRequest data
	 * @param String $signature_request_id
	 * @return stdClass object with SignatureRequest details decoded
	 *  from JSON response from DigiSigner
	 */
	
	public function getSignatureRequest($signature_request_id) {
		return $this->getRequest()->getSignatureRequest($signature_request_id);
	}
	
	
}