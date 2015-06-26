<?php
namespace DigiSigner;

class BaseRequest {

    private $api_key;

    public function __construct($api_key) {
        $this->api_key = $api_key;		
    }
	
	public function getCurler() {
		$curl = new Curler;
		$curl->addAuthentication($this->api_key);
		return $curl;
	}
	
	public function getFileResponse($document_id, $dest_file_path) {

		$curl = $this->getCurler();
		$curl->setUrl(Config::instance()->documents_url.'/'.$document_id);
		$response = new DigiSignerResponse($curl->sendRequest());
		
		if($response->isSuccessful()) {
			if(!is_writable(dirname($dest_file_path)) || (file_exists($dest_file_path) && !is_writable($dest_file_path))) {
				throw new DigiSignerException("File $dest_file_path cannot be created. Permissions denied.");
			}
			
			file_put_contents($dest_file_path, $response->getContent());
        }
        
    }
	
	
	/**
	 * @param Document instance
	 * @return Document $document populated with ID, if upload has been successful
	 * @throws DigiSignerException if no uploaded document ID received
	 */
	public function uploadDocument(Document $document) {
				
		$curl = $this->getCurler();
		$curl->setUrl(Config::instance()->documents_url);
		$curl->setRequestMethod('POST');
		$curl->attachFile($document->getPath(), $document->getFilename());
		$response = new DigiSignerResponse($curl->sendRequest());
		$body = $response->getBody();
		
		$param_doc_id = Config::instance()->param_doc_id;
		
		if(!empty($body->$param_doc_id)) {
			$document->setId($body->$param_doc_id);
			return $document;	
		} else {
			throw new DigiSignerException('ID of the uploaded document not found in server response.');
		}
	
	}
	
	public function sendSignatureRequest(SignatureRequest $request) {
		
		$docs = array();
		foreach($request->getDocuments() as $document) {
			if(!$document->getId()) {
				$docs[] = $this->uploadDocument($document)->export();
			} else {
				$docs[] = $document->export();
			}
		}
		
		$requestData = $request->export();
		$requestData->documents = $docs;		
		$postData = json_encode($requestData);
				
		$curl = $this->getCurler();
		$curl->setUrl(Config::instance()->signature_requests_url);
		$curl->addHeader('Content-Type: application/json');
		$curl->setRequestMethod('POST');
		$curl->setPostData($postData);
		
		$response = new DigiSignerResponse($curl->sendRequest());
		$body = $response->getBody();
		
		if(!empty($body->signature_request_id)) {
			return $request->fromObject($body);
		} else {
			throw new DigiSignerException('ID of the signature request not found in server response.');
		}
	}
	
	public function getSignatureRequest($signature_request_id) {
		$curl = $this->getCurler();
		$curl->setUrl(Config::instance()->signature_requests_url.'/'.$signature_request_id);
		$response = new DigiSignerResponse($curl->sendRequest());
		
		$request = new SignatureRequest;
		return $request->fromObject($response->getBody());
	}
	
	
    
    public function getApiKey() {
        return $this->api_key;
    }
}
