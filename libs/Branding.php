<?php

namespace DigiSigner;

/**
 * The document entity, represents document in all documents requests.
 */
 
class Branding extends ExportObject {

    protected $email_from_field = null;
    protected $reply_to_email = null;

    protected $exportProps = array('email_from_field', 'reply_to_email');

    public function setEmailFromField($email_from_field) {
        $this->email_from_field = $email_from_field;
    }

    public function getEmailFromField() {
        return $this->email_from_field;
    }

    public function getReplyToEmail() {
        return $this->reply_to_email;
    }

    public function setReplyToEmail($reply_to_email) {
        $this->reply_to_email = $reply_to_email;
    }

    protected function getCollectionsMap() {
        return array(); //doesn't hold any collections in it's props
    }
}