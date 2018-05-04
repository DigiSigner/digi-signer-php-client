<?php
namespace DigiSigner;

class BaseRequest {

    private $api_key;
	private $locale;

    public function __construct($api_key, $locale) {
        $this->api_key = $api_key;
		$this->locale = $locale;
    }
	
	public function getCurler($url) {
		$curl = new Curler;
		$curl->addAuthentication($this->api_key);
		if (!empty($this->locale)) {
			$curl->addHeader('Accept-Language: ' . $this->locale);
		}
		$curl->setUrl($url);
		return $curl;
	}
	
	public function getFileResponse($url, $dest_file_path) {

		$curl = $this->getCurler($url);
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
	public function uploadDocument($url, Document $document) {
				
		$curl = $this->getCurler($url);
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
	
	public function sendSignatureRequest($url, $uploadDocumentUrl, SignatureRequest $request) {
		
		$docs = array();
		foreach($request->getDocuments() as $document) {
			if(!$document->getId()) {
				$docs[] = $this->uploadDocument($uploadDocumentUrl, $document)->export();
			} else {
				$docs[] = $document->export();
			}
		}
		
		$requestData = $request->export();
		$requestData->documents = $docs;		
		$postData = json_encode($requestData);
				
		$curl = $this->getCurler($url);
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
	
	public function getSignatureRequest($url) {
		$curl = $this->getCurler($url);

		$response = new DigiSignerResponse($curl->sendRequest());
		
		$request = new SignatureRequest;
		return $request->fromObject($response->getBody());
	}

	public function getDocumentFields($url) {
		$curl = $this->getCurler($url);
		$response = new DigiSignerResponse($curl->sendRequest());

		$request = new DocumentFields;
		return $request->fromObject($response->getBody());
	}

	public function deleteDocument($url) {
		$curl = $this->getCurler($url);
		$curl->setRequestMethod('DELETE');
		$curl->sendRequest();
	}

    public function getApiKey() {
        return $this->api_key;
    }
}
