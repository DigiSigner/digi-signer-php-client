<?php
namespace DigiSigner;

class SignatureRequest extends ExportObject {
	
	protected $signature_request_id = null;
	protected $documents = array();
	protected $is_completed = null;
	
	public function setId($id) {
		$this->signature_request_id = $id;
	}
	
	public function getId() {
		return $this->signature_request_id;	
	}
	
	public function addDocument(Document $document) {
		$this->documents[] = $document;
	}
	
	public function getDocuments() {
		return $this->documents;
	}
	
	protected function getCollectionsMap() {
		return array('documents' => 'Document');
	}
}
