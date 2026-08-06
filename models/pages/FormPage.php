<?php

class FormPage extends Page
{
    // get all the fields of a form
    public function getFormFields() {
        return $this->formfields()->toBlocks();
    }

    // check if in the fields there is a field with id of email otherwise sending the mails will fail
    public function checkEmailField() {
        $hasEmailField = $this->getFormFields()->filter(function ($block) {
            return $block->content()->get('uniqueidentifier')->value() === 'email';
        })->isNotEmpty();
        return $hasEmailField;
    }

    // get the site key of recaptcha
    public function recaptchaSiteKey() {
        return option('libis.forms.recaptchaSiteKey');
    }
}
