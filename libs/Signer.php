<?php
namespace DigiSigner;

class Signer extends ExportObject {
	
	protected $email = '';
	protected $role = null;
	protected $fields = array();
	protected $is_signature_completed = null;
	protected $sign_document_url = null;
	
	protected $exportProps = array('email', 'role', 'fields');
	
	public function __construct($email = '') {
		$this->email = $email;
	}
	
	public function getEmail() {
		return $this->email;
	}
	
	
	/** @param {string} $role */
	public function setRole($role) {
		return $this->role = $role;
	}
	
	public function getRole() {
		return $this->role;
	}
	
	public function addField(Field $field) {
		$this->fields[] = $field;
	}
	
	public function getFields() {
		return $this->fields;
	}
	
	public function getSignDocumentUrl() {
		return $this->sign_document_url;
	}
	
	protected function getCollectionsMap() {
		return array('fields' => 'Field');
	}

}
