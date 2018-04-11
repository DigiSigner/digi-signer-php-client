<?php
namespace DigiSigner;

class ExistingField extends ExportObject {

    protected $api_id = '';
    protected $group_id = '';
    protected $content = null;
    protected $label = null;
    protected $required = null;
    protected $read_only = null;

    protected $exportProps = array('api_id', 'group_id', 'content', 'label', 'required', 'read_only');

    public function __construct($api_id = '') {
        $this->api_id = $api_id;
    }

    public function getApiId() {
        return $this->api_id;
    }

    public function getGroupId() {
        return $this->group_id;
    }

    public function setGroupId($group_id) {
        $this->group_id = $group_id;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getLabel() {
        return $this->label;
    }

    public function setLabel($label) {
        $this->label = $label;
    }

    public function isRequired() {
        return $this->required;
    }

    public function setRequired($required) {
        $this->required = $required;
    }

    public function isReadOnly() {
        return $this->read_only;
    }

    public function setReadOnly($read_only) {
        $this->read_only = $read_only;
    }

    protected function getCollectionsMap() {
        return array('fields' => 'Field');
    }
}
