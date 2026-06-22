<?php

class FormPage extends Page
{
    public function getFormFields() {
        return $this->formfields()->toBlocks();
    }

    public function checkEmailField() {
        $hasEmailField = $this->getFormFields()->filter(function ($block) {
            return $block->content()->get('uniqueidentifier')->value() === 'email';
        })->isNotEmpty();
        return $hasEmailField;
    }

    public function recaptchaSiteKey() {
        return option('libis.forms.recaptchaSiteKey');
    }
}
