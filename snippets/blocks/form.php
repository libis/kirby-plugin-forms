<?php
  $formpage = $block->formpage()->toPages()->first(); 
  $data = kirby()->session()->get('formdata') ?? [];
  kirby()->session()->remove('formdata');
  $errors = kirby()->session()->get('error') ?? [];
  kirby()->session()->remove('error');
  $succes = kirby()->session()->get('succes') ?? [];
  kirby()->session()->remove('succes');
  $page = kirby()->site()->page();
  $files = kirby()->session()->get('files') ?? [];
  kirby()->session()->remove('files');
  $language = $kirby->languageCode();
?>

<?php if($succes != null): ?>
  <div class="form-succes bg-green-100 px-20 py-15 border-l-3 border-green-600 border-solid">
    <?= $succes ?>
  </div>
<?php else: ?>
  <?php if($errors != null): ?>
    <div class="form-errors bg-red-100 px-20 py-15 border-l-3 border-red-600 border-solid mb-25">
      <p class="text-xl font-semibold mb-5"><?= t('libis.forms.problem', null, $language)?><p>
      <ul class="flex flex-col gap-5 list-disc">
        <?php foreach($errors as $key => $error): ?>
          <?php if($key != "data" && $key != "mail"): ?>
            <li class="ml-18"><?= $error ?></li>
          <?php elseif($key == 'mail'): ?>
            <?php foreach($errors['mail'] as $key => $error): ?>
              <li class="ml-18"><?= $error ?></li>
            <?php endforeach ?>
          <?php endif; ?>
        <?php endforeach ?>
      </ul>
    </div>
  <?php endif; ?>
  <form class="form" method="post" id="<?= $block->id() ?>" action="/form-send" data-block="<?= $block->id() ?>" enctype="multipart/form-data" data-language="<?= $language ?>"> 
    <input type="hidden" name="csrf" value="<?= csrf() ?>">
    <input type="hidden" name="origin" value="<?= esc($page->url()) ?>">
    <input type="hidden" name="language" value="<?= $kirby->languageCode() ?>">
    <div class="form-wrapper flex flex-col items-start gap-35">
      <div class="fields flex flex-row flex-wrap gap-x-20 gap-y-25 w-full">
        <?php if(!$formpage->checkEmailField()): ?>
          <div class="w-full flex flex-col gap-5 restricted-field">
            <h5><label for="email">Email</label></h5>  
            <input 
              class="w-full rounded-sm border-black border-solid border-2 px-5 py-5 <?= (!empty($errors) && !empty($errors['data']) && array_key_exists('email', $errors['data'])) ? 'border-red-800' : ''; ?>" 
              type="email" 
              id="email"
              name="email"
              placeholder="Email"
              value = "<?= $data != NULL ? esc($data['email']) : ''; ?>"
              required
              data-type="email"
            />
            <?php if(!empty($errors) && !empty($errors['data']) && array_key_exists('email', $errors['data'])): ?>
              <p class="text-base text-red-800"><?= $errors['data']['email']; ?></p>
            <?php endif; ?>
          </div>
        <?php endif; ?>
        <?php foreach ($formpage->getFormFields() as $block): ?>
          <?php
            $percentage = tailwindPerecentage($block->size()->value());
            $block->size()->value() != '1/1' ? $spacing = '10px' : $spacing = '0px';
          ?>
          <?php if($block->type() == 'checkbox'): ?>
            <div class="block-type-<?= $block->type() ?> checkbox <?= $data != NULL && isset($data[$block->uniqueidentifier()->value()]) ? 'checked' : ''?> w-full flex gap-10">
              <?php snippet('blocks/' . $block->type(), [
                'block' => $block,
                'data' => $data,
                'errors' => $errors
              ]) ?>
          <?php elseif($block->type() == 'file'): ?>
            <div class="block-type-<?= $block->type() ?> form-file-block w-full flex flex-col gap-25 mt-15 mb-15">
              <?php snippet('blocks/' . $block->type(), [
                'block' => $block,
                'files' => $files,
                'errors' => $errors,
                'language' => $language
              ]) ?>
          <?php else: ?>
            <div class="block-type-<?= $block->type() ?> dynamic-width flex flex-col gap-5 <?= $block->required()->toBool() === true ? 'restricted-field' : '' ?>" style="--block-width: <?= $percentage ?>; --block-offset: <?= $spacing ?>;">
              <h5><label for="<?= $block->uniqueidentifier()?>"><?= ucfirst($block->fieldlabel())?></label></h5>   
              <?php snippet('blocks/' . $block->type(), [
                'block' => $block,
                'data' => $data,
                'errors' => $errors
              ]) ?>
          <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <div class="w-full flex flex-col gap-10 checkbox checbox-gdpr <?= $data != NULL && isset($data[$block->uniqueidentifier()->value()]) ? 'checked' : ''?>">
          <input 
            type="checkbox" 
            data-type="checkbox"
            class="checkbox-input--checkbox"
            id="GDPR"
            name="GDPR"
            value="GDPR"
            required
            <?= $data != NULL && isset($data['GDPR']) ? 'checked' : ''?>
          >
          <h5>
            <label class="checkbox-label" for="GDPR">
              <?= t('libis.forms.GDPR', null, $language)?>
              <span class="checkbox-asterisk">*</span>
            </label>
          </h5>  
        </div>
        <div class="w-full g-recaptcha [&_.rc-anchor-checkbox]:cursor-pointer" data-sitekey="<?= $formpage->recaptchaSiteKey() ?>"></div>
      </div>
      <button class="send-button send-button-<?=$formpage->sendButtonType() ?> px-15 py-5 rounded-sm" type="submit"><?= $formpage->sendButtonText() ?></button>
    </div>
  </form>
<?php endif; ?>