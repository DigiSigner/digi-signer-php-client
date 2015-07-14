<?php
namespace DigiSigner;

class SignatureRequest extends ExportObject {
	
	
	protected $signature_request_id = null;
	protected $documents = array();
	protected $is_completed = null;
	protected $redirect_for_signing_to_url = null;
	protected $redirect_after_signing_to_url = null;
	protected $use_text_tags = null;
	protected $hide_text_tags = null;
	
	/**
	 * @var included to JSON call to API, if set to not null
	 */
	protected $send_emails = null;
	
	/**
	 * @var included to JSON call to API, if set to not null
	 */
	protected $embedded = null;
	
	/**
	 * @var Array of property names that will be used for $this->export() method,
	 * when creating JSON. Those, not mentioned in the array, or NULL props will be ignored 
	 */
	protected $exportProps = array(
		'send_emails', 'embedded', 'redirect_for_signing_to_url', 'redirect_after_signing_to_url', 'use_text_tags', 'hide_text_tags'
	);
	
	public function setId($id) {
		$this->signature_request_id = $id;
	}
	
	public function getId() {
		return $this->signature_request_id;	
	}
	
	
	public function setEmbedded($bool) {
		$this->embedded = (bool) $bool;
	}
	
	public function getEmbedded() {
		return $this->embedded;
	}
	
	public function setSendEmails($bool) {
		$this->send_emails = (bool) $bool;
	}
	
	public function setRedirectForSigningToUrl($url) {
		$this->redirect_for_signing_to_url = $url;
	}
	
	public function getRedirectForSigningToUrl($url) {
		return $this->redirect_for_signing_to_url;
	}
	
	public function setRedirectAfterSigningToUrl($url) {
		$this->redirect_after_signing_to_url = $url;
	}
	
	public function getRedirectAfterSigningToUrl($url) {
		return $this->redirect_after_signing_to_url;
	}
	
	public function setUseTextTags($bool) {
		$this->use_text_tags = $bool;
	}
	
	public function getUseTextTags($bool) {
		return $this->use_text_tags;
	}
		
	public function setHideTextTags($bool) {
		$this->hide_text_tags = $bool;
	}
	
	public function getHideTextTags($bool) {
		return $this->hide_text_tags;
	}
	
	public function getSendEmails() {
		return $this->send_emails;
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
