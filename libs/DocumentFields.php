<?php
namespace DigiSigner;

class DocumentFields extends ExportObject {

    protected $document_fields = array();

    protected $exportProps = array(
       // doesn't hold any properties only collection map
    );

    public function getDocumentFields() {
        return $this->document_fields;
    }

    protected function getCollectionsMap() {
        return array('document_fields' => 'DocumentField');
    }
}
