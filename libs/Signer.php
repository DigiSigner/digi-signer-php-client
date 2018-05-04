<?php
namespace DigiSigner;

class Signer extends ExportObject {
	
	protected $email = '';
	protected $role = null;
	protected $order = null;
	protected $send_email = null;   // can be true or false
	protected $send_sms = null;     // can be true or false
	protected $phone_number = null;
	protected $fields = array();
	protected $existing_fields = array();
	protected $is_signature_completed = null;
	protected $sign_document_url = null;

	protected $exportProps = array('email', 'role', 'order', 'send_email', 'send_sms', 'phone_number', 'fields', 'existing_fields');

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

    public function setOrder($order) {
        return $this->order = $order;
    }

    public function getOrder() {
        return $this->order;
    }

    public function getSendEmail() {
        return $this->send_email;
    }

    public function setSendEmail($send_email) {
        $this->send_email = $send_email;
    }

    public function getSendSms() {
        return $this->send_sms;
    }

    public function setSendSms($send_sms) {
        $this->send_sms = $send_sms;
    }

    public function getPhoneNumber() {
        return $this->phone_number;
    }

    public function setPhoneNumber($phone_number) {
        $this->phone_number = $phone_number;
    }

	public function addField(Field $field) {
		$this->fields[] = $field;
	}

	public function getFields() {
		return $this->fields;
	}

	public function addExistingField(ExistingField $existing_field) {
		$this->existing_fields[] = $existing_field;
	}

	public function getExistingFields() {
		return $this->existing_fields;
	}

	public function getSignDocumentUrl() {
		return $this->sign_document_url;
	}

	protected function getCollectionsMap() {
		return array('fields' => 'Field');
	}

  public function isSignatureCompleted() {
    return $this->is_signature_completed;
  }


}
