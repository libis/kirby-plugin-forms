<?php
function tailwindPerecentage($fraction) {
	$map = [
		'1/2' => '50%',
		'1/1' => '100%',
	];
	
	$percent = array_key_exists($fraction, $map) ? $map[$fraction] : '100%';

	return $percent;
}

$kirby = kirby();

load([
  'FormPage' => __DIR__ . '/models/pages/FormPage.php',
	'Form' => __DIR__ . '/models/blocks/Form.php'
]);

Kirby::plugin('libis/forms', [
	'pageModels' => [
  	'form' => FormPage::class,
  ],
	'blockModels' => [
    'form' => Form::class
  ],
	'routes' => [
		[
			'pattern' => 'form-send',
			'method' => 'POST',
			'action' => function () {
				$siteKey = option('libis.forms.recaptchaSiteKey');
				$secretKey = option('libis.forms.recaptchaSecretKey');
				$errors = [];
				$data = [];
				$files = [];

				$token = $_POST['csrf'];
				if (csrf($token) === true) {
					$languageCode = $_POST['language'];
					$siteUrl = site()->url($languageCode);
					$requestUrl = $_POST['origin'];
					$pageUrl = str_replace($siteUrl, '', $requestUrl);
										
					$languageCodes = [];
					foreach (kirby()->languages()->values() as $language) {
						$languageCodes[] = $language->code();
					}
					$pattern = '#^/(' . implode('|', $languageCodes) . ')(/|$)#';
					$pageUrl = preg_replace($pattern, '/', $pageUrl);

					if ($pageUrl == "") {
						$pageUrl = site()->homePage();
					}
					else {
						$pageUrl = ltrim($pageUrl, '/');
					}

					$requestPage = kirby()->page($pageUrl);

					$blockId = $_POST['block-id'];
					$formBlock = [];
					$page_fields = $requestPage->blueprint()->fields();
	
					foreach ($page_fields as $fieldName => $value) {
						$field = $requestPage->$fieldName();

						try {
							foreach ($field->toLayouts() as $layout) {
								foreach ($layout->columns() as $column) {
									foreach ($column->blocks() as $block) {
										if ($block->id() === $blockId) {
											$formBlock = $block;
											break 3;
										}
									}
								}
							}
						} catch (Throwable $e) {
							try {
								foreach ($field->toBlocks() as $block) {
									if ($block->id() === $blockId) {
										$formBlock = $block;
										break 2;
									}
								}
							} catch (Throwable $e) {
								continue;
							}
						}
					}

					if($formBlock != null) {
						if (!$formBlock->isCaptchaValid($secretKey, $_POST)) {
							$errors[] = t('libis.forms.unvalid.recaptcha', 'Gelieve de recaptcha in te vullen', $languageCode);
						}

						$checkedData = $formBlock->checkData($_POST, $_FILES, $languageCode);

						if (!empty($checkedData['errors'])) {
							$errors['data'] = $checkedData['errors'];
							$data = $checkedData['data'];
							$files = $checkedData['files'];
						}
						elseif (!empty($checkedData['data'])) {
							$data = $checkedData['data'];
							$files = $_FILES;
						}
						else {
							$errors[] = t('libis.forms.something.went.wrong', 'Er liep iets mis bij het verzenden. Probeer het later opnieuw. Blijft dit probleem zich voordoen neem dan contact op met de beheerder van de website.', $languageCode);
						}
					}
					else {
						$errors[] = t('libis.forms.something.went.wrong', 'Er liep iets mis bij het verzenden. Probeer het later opnieuw. Blijft dit probleem zich voordoen neem dan contact op met de beheerder van de website.', $languageCode);
					}

					if(empty($errors)) {
						$sendMail = "";
						$data['Page'] = $siteUrl . '/' . $pageUrl;
						$fromDataPage = $formBlock->formpage()->toPage();
						if($fromDataPage) {
							foreach($fromDataPage->formfields()->toBlocks() as $block) {
								if($block->type() == 'select') {
									if($block->optionType() == 'email') {
										foreach($block->optionsEmail()->toBlocks() as $emailSelect) {
											if($emailSelect->value() == $_POST[$block->uniqueidentifier()->toString()]) {
												$sendMail = $emailSelect->email()->toString();
											}
										}
									}
								}
							}
						}

						$mails = $formBlock->sendMails($data, $files, $requestUrl, $languageCode, $sendMail);

						if(empty($mails)) {
							$succesMessage = t('libis.forms.succes.send.message', 'Je gegevens zijn met succes verzonden.');
							kirby()->session()->set('succes', $succesMessage);
						}
						else {
							$errors['mail'] = $mails;
						}
					}
				} 
				else {
					return go('/');
				}

				kirby()->session()->set('formdata', $data);
				kirby()->session()->set('files', $files);
				kirby()->session()->set('error', $errors);
				
				return go($_POST['origin'] . '#' . $blockId);

			}
		],
		[
			'pattern' => 'forms(:all)?',
			'action'  => function () {
				return go('/');
			}
    ]
	],
	'hooks' => [
		'system.loadPlugins:after' => function () {
			if (!site()->index(true)->find('forms')) {
				kirby()->impersonate('kirby');
				Page::create([
					'slug' => 'forms',
					'template' => 'forms',
					'draft' => false,
					'content' => [
						'title' => 'Forms'
					]
				]);
				kirby()->impersonate('nobody');
			}
		},
	],
	'blueprints' => [
		'pages/form' => __DIR__ . '/blueprints/pages/form.yml',
		'pages/forms' => __DIR__ . '/blueprints/pages/forms.yml',
		'blocks/form' => __DIR__ . '/blueprints/blocks/form.yml',
		'blocks/input' => __DIR__ . '/blueprints/blocks/formfields/01_input.yml',
		'blocks/textarea' => __DIR__ . '/blueprints/blocks/formfields/02_textarea.yml',
		'blocks/checkbox' => __DIR__ . '/blueprints/blocks/formfields/03_checkbox.yml',
		'blocks/select' => __DIR__ . '/blueprints/blocks/formfields/04_select.yml',
		'blocks/file' => __DIR__ . '/blueprints/blocks/formfields/05_file.yml',
		'blocks/selectOption' => __DIR__ . '/blueprints/blocks/formfields/subformfields/selectOption.yml',
		'blocks/selectOptionEmail' => __DIR__ . '/blueprints/blocks/formfields/subformfields/selectOptionEmail.yml',
	],
	'snippets' => [
		'blocks/form' => __DIR__ . '/snippets/blocks/form.php',
		'blocks/input' => __DIR__ . '/snippets/blocks/formfields/01_input.php',
		'blocks/textarea' => __DIR__ . '/snippets/blocks/formfields/02_textarea.php',
		'blocks/checkbox' => __DIR__ . '/snippets/blocks/formfields/03_checkbox.php',
		'blocks/select' => __DIR__ . '/snippets/blocks/formfields/04_select.php',
		'blocks/file' => __DIR__ . '/snippets/blocks/formfields/05_file.php',
	],
	'templates' => [
		'emails/mail-beheerder-nl.html' => __DIR__ . '/templates/emails/mail-beheerder-nl.html.php',
		'emails/mail-gebruiker-nl.html' => __DIR__ . '/templates/emails/mail-gebruiker-nl.html.php',
		'emails/mail-beheerder-en.html' => __DIR__ . '/templates/emails/mail-beheerder-en.html.php',
		'emails/mail-gebruiker-en.html' => __DIR__ . '/templates/emails/mail-gebruiker-en.html.php',
		'emails/mail-beheerder-fr.html' => __DIR__ . '/templates/emails/mail-beheerder-fr.html.php',
		'emails/mail-gebruiker-fr.html' => __DIR__ . '/templates/emails/mail-gebruiker-fr.html.php',
	],
	'translations' => (function () {
		$translations = [];
		$dir = __DIR__ . '/assets/translations';

		foreach (glob($dir . '/*.json') as $file) {
		$lang = basename($file, '.json');
		$json = file_get_contents($file);
		$translations[$lang] = json_decode($json, true);
		}

		return $translations;
	})(),
]);
