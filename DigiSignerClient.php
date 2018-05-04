<?php
/**
 * DigiSigner Client Library
 * v.1.0.5
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

	private $serverUrl; // if not set, default value is taken from the Config class.

	private $locale; // the 'Accept-Language' header on HTTP request.
	
	/**
	 * @param String $api_key obtained from DigiSigner.com
	 */
    public function __construct($api_key) {
        $this->api_key = $api_key;
    }

	/**
	 * @param string $serverUrl - url to the backend server.
	 */
	public function setServerUrl($serverUrl) {
		$this->serverUrl = $serverUrl;
	}

	private function getServerUrl() {
		return empty($this->serverUrl) ? Config::instance()->server_default_url : $this->serverUrl;
	}

	/**
	 * @param string $locale - this parameter will be used to set the 'Accept-Language' header on HTTP request.
	 */
	public function setLocale($locale) {
		$this->locale = $locale;
	}

	protected function getRequest() {
		return new BaseRequest($this->api_key, $this->locale);
	}
	

	/**
	 * Saves document to specified location
	 * @param String $document_id
	 * @param $dest_file_path - local path to save the document
	 * @return void
	 */
	public function getDocument($document_id, $dest_file_path) {
		$url = $this->getServerUrl().Config::instance()->documents_url.'/'.$document_id;

		$this->getRequest()->getFileResponse($url, $dest_file_path);
	}
	
	/**
	 * Uploads given file to DigiSigner from specified location 
	 * @param String - local path to document file
	 * @return document with updated ID field.
	 */
 	public function uploadDocument($path_to_document) {
 		
		$document = new Document($path_to_document);
		$url = $this->getServerUrl().Config::instance()->documents_url;

		return $this->getRequest()->uploadDocument($url, $document);
	}
	
	/**
	 * Accepts prepared SignatureRequest data and executes it
	 * @param SignatuireRequest object
	 * @return SignatuireRequest object populated with ID, if successful
	 * @throws If now success, a DigiSignerException will be thrown
	 */
	
	public function sendSignatureRequest(SignatureRequest $request) {
		$url = $this->getServerUrl().Config::instance()->signature_requests_url;
		$uploadDocumentUrl = $this->getServerUrl().Config::instance()->documents_url;

		return $this->getRequest()->sendSignatureRequest($url, $uploadDocumentUrl, $request);
	}
	
	/**
	 * Fetches SignatureRequest data
	 * @param String $signature_request_id
	 * @return stdClass object with SignatureRequest details decoded
	 *  from JSON response from DigiSigner
	 */
	
	public function getSignatureRequest($signature_request_id) {
		$url = $this->getServerUrl().Config::instance()->signature_requests_url.'/'.$signature_request_id;
		return $this->getRequest()->getSignatureRequest($url);
	}

	/**
	 * Returns document fields for a document.
	 * @param String $document_id .
	 * @return stdClass object with document fields details decoded
	 *  from JSON response from DigiSigner
	 */
	public function getDocumentFields($document_id) {
		$url = $this->getServerUrl().Config::instance()->documents_url.'/'.$document_id.Config::instance()->fields_path;
		return $this->getRequest()->getDocumentFields($url);
	}

	/**
	 * Deletes document by given document id.
	 * @param String $document_id.
	 */
	public function deleteDocument($document_id) {
		$url = $this->getServerUrl().Config::instance()->documents_url.'/'.$document_id;
		$this->getRequest()->deleteDocument($url);
	}

	/**
	 * Downloads a file for given document and attachment field by IDs.
	 * @param String $document_id ID of document with attachment field
	 * @param String $field_api_id API ID of field with attachment
	 * @param String $dest_file_path destination path for attachments
	 * @return void
	 */
	public function getDocumentAttachment($document_id, $field_api_id, $dest_file_path) {
		$url = $this->getServerUrl().Config::instance()->documents_url.'/'.$document_id.Config::instance()->fields_path.'/'.$field_api_id.Config::instance()->attachment_path;
		$this->getRequest()->getFileResponse($url, $dest_file_path);
	}
}