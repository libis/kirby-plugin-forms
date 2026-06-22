<?php

use Kirby\Cms\Block;

class Form extends Block
{
    public function isCaptchaValid($secretKey, $data){
        $captcha = isset($data['g-recaptcha-response']) ? $data['g-recaptcha-response'] : false;

        if (!$captcha) {
            return false;
        }

        $postdata = http_build_query(
            array(
                "secret" => $secretKey,
                "response" => $captcha,
                "remoteip" => $_SERVER["REMOTE_ADDR"]
            )
        );
        $opts = array(
            'http' =>
            array(
                "method"  => "POST",
                "header"  => "Content-Type: application/x-www-form-urlencoded",
                "content" => $postdata
            )
        );
        $context  = stream_context_create($opts);
        $googleApiResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify", false, $context);

        if ($googleApiResponse === false) {
            return false;
        }

        $googleApiResponseObject = json_decode($googleApiResponse);

        return $googleApiResponseObject->success;
    }

    public function checkData($data, $files, $language) {
        $checkedData = [];
        $errors = [];
        $checkedFiles = [];

        foreach($data as $key => $value) {
            if (str_starts_with($key, '__type_')) continue;
            if ($key == "origin") continue;
            if ($key == "g-recaptcha-response") continue;
            if ($key == "language") continue;
            if ($key == "block-id") continue;
            if ($key == "csrf") continue;

            $typeKey = '__type_' . $key;
            $type = $data[$typeKey] ?? 'text';

            $safeValue = $this->makeDataSafe($value);

            if($type == "text" || $type == "textarea") {
                if (!empty($safeValue) && !preg_match('/^[\p{L}\p{N}€@+=#^*\/\\\\\-\.,!?()\[\]{}:;\'" \r\n\t]+$/u', $safeValue)) {
                    $translation = t('libis.forms.text.input.error', null, $language);
                    $errors[$key] = Str::template($translation, [
                        'key' => $key,
                        'value' => $safeValue
                    ]);
                    $checkedData[$key] = $safeValue;
                }
                else {
                    $checkedData[$key] = $safeValue;
                }
            }
            elseif($type == "email") {
                if (!empty($safeValue) && !filter_var($safeValue, FILTER_VALIDATE_EMAIL)) {
                    $translation = t('libis.forms.email.input.error', null, $language);
                    $errors[$key] = Str::template($translation, [
                        'key' => $key,
                        'value' => $safeValue
                    ]);
                    $checkedData[$key] = $safeValue;
                }
                else {
                    $checkedData[$key] = $safeValue;
                }
            }
            elseif($type == "tel") {
                if (!empty($safeValue) && !preg_match('/^\+?[0-9\s\-]{7,15}$/',  $safeValue)) {
                    $translation = t('libis.forms.tel.input.error', null, $language);
                    $errors[$key] = Str::template($translation, [
                        'key' => $key,
                        'value' => $safeValue
                    ]);
                    $checkedData[$key] = $safeValue;
                }
                else {
                    $checkedData[$key] = $safeValue;
                }
            }
            elseif($type == "url") {
                if (!empty($safeValue) && !filter_var($safeValue, FILTER_VALIDATE_URL)) {
                    $translation = t('libis.forms.url.input.error', null, $language);
                    $errors[$key] = Str::template($translation, [
                        'key' => $key,
                        'value' => $safeValue
                    ]);
                    $checkedData[$key] = $safeValue;
                }
                else {
                    $checkedData[$key] = $safeValue;
                }
            }
            elseif($type == "number") {
                if(empty($safeValue)) {
                    $checkedData[$key] = $safeValue;
                }
                else {
                    if(filter_var($safeValue, FILTER_VALIDATE_INT, array("options" => array("min_range"=>0)))) {
                        $checkedData[$key] = $safeValue;
                    }
                    elseif(filter_var($safeValue, FILTER_VALIDATE_FLOAT, array("options" => array("min_range"=>0.0)))) {
                        $checkedData[$key] = $safeValue;
                    }
                    else {
                        $translation = t('libis.forms.number.input.error', null, $language);
                        $errors[$key] = Str::template($translation, [
                            'key' => $key,
                            'value' => $safeValue
                        ]);
                        $checkedData[$key] = $safeValue;
                    }
                }
            }
            elseif($type == "checkbox") {
                $checkedData[$key] = $value;
            }
            elseif($type == "select") {
                $checkedData[$key] = $value;
            }
        }

        $allfilterInputs = array_keys(array_filter($data, fn($v, $k) => str_starts_with($k, '__type_') && $v === 'files', ARRAY_FILTER_USE_BOTH));

        foreach($allfilterInputs as $key) {
            $key = str_replace('__type_', '', $key);
            $filesArray = [];
        
            if (empty($files[$key]['name'][0]) && $files[$key]['error'][0] === 4) {
                continue;
            }

            foreach ($files[$key]['name'] as $i => $name) {
                $filesArray[] = [                
                    'name' => $name,
                    'type' => $files[$key]['type'][$i],
                    'tmp_name' => $files[$key]['tmp_name'][$i],
                    'error' => $files[$key]['error'][$i],
                    'size' => $files[$key]['size'][$i],
                ];
            }

            $filesCollect = [];

            foreach($filesArray as $i => $file) {
                if ($file['error'] !== 0) {
                    $translation = t('libis.forms.files.error', null, $language);
                    $errors[$key][$i] = Str::template($translation, [
                        'name' => $file['name']
                    ]);
                }
                elseif($file['size'] > 2000000) {
                    $translation = t('libis.forms.files.size', null, $language);
                    $errors[$key][$i] = Str::template($translation, [
                        'name' => $file['name']
                    ]);
                }
                elseif(!in_array($file['type'], ['image/png', 'image/jpg', 'image/jpeg'])) {
                    $translation = t('libis.forms.files.type', null, $language);
                    $errors[$key][$i] = Str::template($translation, [
                        'name' => $file['name']
                    ]);
                }
                
                $filesCollect[] = [  
                    'name' => $file['name'],
                    'type' => $file['type'],
                    'content' => base64_encode(file_get_contents($file['tmp_name']))
                ];
            }
            $checkedFiles[$key] = $filesCollect;
        }
        

        return [
            'data' => $checkedData,
            'errors' => $errors,
            'files' => $checkedFiles
        ];
    }

    private function makeDataSafe($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function sendMails($data, $files, $requestUrl, $language) {
        $errors = [];
        $formpage = $this->formpage()->toPages()->first(); 

        $from = $formpage->sendMail()->value();
        $toPatrnerMail = $formpage->receiveMail()->value();

        
        $attachments = $this->prepareKirbyAttachments($files);

        try {
            kirby()->email([
                'from'    => $from,
                'to'      => $toPatrnerMail,
                'template' => 'mail-beheerder',
                'subject' => 'test',
                'data' => [
                    'data' => $data,
                ],
                'attachments' => $attachments
            ]);
        } catch (Exception $error) {
            $errors[] = $translation = t('libis.forms.went.wrong.mail.admin', null, $language);
        }

        try {
            kirby()->email([
                'from'    => $from,
                'to'      => $data['email'],
                'template' => 'mail-beheerder',
                'subject' => 'test',
                'data' => [
                    'data' => $data,
                ],
                'attachments' => $attachments
            ]);
        } catch (Exception $error) {
            $errors[] = $translation = t('libis.forms.went.wrong.mail.user', null, $language);
        }

        return $errors;
    }

    
    private function prepareKirbyAttachments(array $files): array {
        $attachments = [];

        foreach ($files as $inputName => $fileGroup) {
            if (!isset($fileGroup['name']) || !is_array($fileGroup['name'])) continue;

            $normalizedFiles = $this->normalizeFilesArray($fileGroup);

            foreach ($normalizedFiles as $file) {
                if($file['name'] == "") continue;
                $name     = $file['tmp_name'];
                $tmpName  = pathinfo($name);
                // sanitize the original filename
                $filename = $tmpName['dirname']. '/'. F::safeName($file['name']);

                if (rename($file['tmp_name'], $filename)) {
                    $name = $filename;
                }
                // add the files to the attachments array
                $attachments[] = $name;
            }
        }

        return $attachments;
    }

    private function normalizeFilesArray(array $fileData): array {
        $normalized = [];

        foreach ($fileData['name'] as $index => $name) {
            $normalized[] = [
                'name' => $name,
                'type' => $fileData['type'][$index],
                'tmp_name' => $fileData['tmp_name'][$index],
                'error' => $fileData['error'][$index],
                'size' => $fileData['size'][$index],
            ];
        }

        return $normalized;
    }
}