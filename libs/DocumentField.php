<?php
namespace DigiSigner;

class DocumentField extends ExportObject {

    const TYPE_SIGNATURE = 'SIGNATURE';
    const TYPE_TEXT = 'TEXT';
    const TYPE_INITIALS = 'INITIALS';
    const TYPE_DATE = 'DATE';
    const TYPE_CHECKBOX = 'CHECKBOX';
    const TYPE_RADIO = 'RADIO';
    const TYPE_ATTACHMENT = 'ATTACHMENT';

    const STATUS_EMPTY = 'EMPTY';
    const STATUS_FILLED = 'FILLED';

    const ALIGNMENT_CENTER = 'CENTER';
    const ALIGNMENT_RIGHT = 'RIGHT';

    protected $api_id = null;
    protected $role = '';
    protected $type = ''; // see available types in TYPE_* constants
    protected $page = null; // starts with 0
    protected $rectangle = array();
    protected $status = ''; // see available statuses in STATUS_* constants
    protected $content = null;
    protected $submitted_content = null;
    protected $label = null;
    protected $required = false;
    protected $name = '';
    protected $group_id = '';
    protected $index = null;
    protected $read_only = false;
    protected $pdf_field = false;
    protected $font_size = null;
    protected $max_length = null;
    protected $alignment = ''; // see available alignments in ALIGNMENT_* constants

    protected $exportProps = array('api_id', 'role', 'type', 'page', 'rectangle', 'status', 'content',
        'submitted_content', 'label', 'required', 'name', 'group_id', 'index', 'read_only', 'pdf_field', 'font_size',
        'max_length', 'alignment');


    public function getApiId() {
        return $this->api_id;
    }


    public function getRole() {
        return $this->role;
    }


    public function getType() {
        return $this->type;
    }


    public function getPage() {
        return $this->page;
    }


    public function getRectangle() {
        return $this->rectangle;
    }


    public function getStatus() {
        return $this->status;
    }


    public function getContent() {
        return $this->content;
    }


    public function getSubmittedContent() {
        return $this->submitted_content;
    }


    public function getLabel() {
        return $this->label;
    }


    public function isRequired() {
        return $this->required;
    }


    public function getName() {
        return $this->name;
    }


    public function getGroupId() {
        return $this->group_id;
    }


    public function getIndex() {
        return $this->index;
    }


    public function isReadOnly() {
        return $this->read_only;
    }


    public function isPdfField() {
        return $this->pdf_field;
    }


    public function getFontSize() {
        return $this->font_size;
    }

    public function getMaxLength() {
        return $this->max_length;
    }

    public function getAlignment() {
        return $this->alignment;
    }

    protected function getCollectionsMap() {
        return array();//doesn't hold any collections in it's props
    }
}
