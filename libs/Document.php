<?php

namespace DigiSigner;

/**
 * The document entity, represents document in all documents requests.
 */
 
class Document extends ExportObject {

    protected $document_id = '';

	protected $title = '';

    protected $subject = '';
    
    protected $message = '';
    
    protected $signers = array();//collection of Signers instances
	
	protected $exportProps = array('document_id', 'title', 'subject', 'message', 'signers');
	
	private $path = '';
	private $filename = '';
	
	
    public function __construct($path_to_document = '') {
		
		if(!empty($path_to_document)) {
		
			//builds canonical absolute path to a file
			$this->path = realpath($path_to_document);
			
			if(!file_exists($this->path)) {
				throw new DigiSignerException("File $path_to_document does not exists");
			}
			
			$this->filename = basename($this->path);
		}
    }
	
    public static function withId($id) {
      $instance = new self();
      $instance->document_id = $id;
      return $instance;
    }
 
	public function setId($id) {
		$this->document_id = $id;
	}
	
	public function getId() {
		return $this->document_id;
	}
	
	public function getPath() {
		return $this->path;
	}
	
	public function getFilename() {
		return $this->filename;
	}

	public function setTitle($title) {
		$this->title = $title;
	}

	public function setSubject($subject) {
		$this->subject = $subject;
	}
	
	public function setMessage($message) {
		$this->message = $message;
	}
	
	public function addSigner($signer) {
		$this->signers[] = $signer;
	}
	
	public function getSigners(){
		return $this->signers;
	}
	
	protected function getCollectionsMap() {
		return array('signers' => 'Signer');
	}
	
	
}