<?php
namespace DigiSigner;

class Field extends ExportObject {
	
	const TYPE_SIGNATURE = 'SIGNATURE';
	const TYPE_TEXT = 'TEXT';
	const TYPE_INITIALS = 'INITIALS';
	const TYPE_DATE = 'DATE';
	const TYPE_CHECKBOX = 'CHECKBOX';
	
	
	protected $page = null;
	protected $rectangle = array();
	protected $type = '';
	
	protected $exportProps = array('page', 'rectangle', 'type', 'api_id', 'content', 'label', 'required');

	public $api_id = null;
	public $content = null;
    public $label = null;
	public $required = true;

	public function __construct($page, $rectangle = array(), $type) {
		$this->page = $page;
		$this->rectangle = $rectangle;
		$this->type = $type;
	}

	public function setApiId($api_id) {
		$this->api_id = $api_id;
	}

	public function setContent($content) {
		$this->content = $content;
	}

	public function setLabel($label) {
		$this->label = $label;
	}

	public function setRequired($bool) {
		$this->required = $bool;
	}
	
	protected function getCollectionsMap() {
		return array();//doesn't hold any collections in it's props
	}
}
