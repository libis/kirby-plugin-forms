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
  <div class="form-succes">
    <?= $succes ?>
  </div>
<?php else: ?>
  <?php if($errors != null): ?>
    <div class="form-errors">
      <p class="form-error-title"><?= t('libis.forms.problem', null, $language)?><p>
      <ul class="error-list">
        <?php foreach($errors as $key => $error): ?>
          <?php if($key != "data" && $key != "mail"): ?>
            <li><?= $error ?></li>
          <?php elseif($key == 'mail'): ?>
            <?php foreach($errors['mail'] as $key => $error): ?>
              <li><?= $error ?></li>
            <?php endforeach ?>
          <?php endif; ?>
        <?php endforeach ?>
      </ul>
    </div>
  <?php endif; ?>
  <form class="form form-block" method="post" id="<?= $block->id() ?>" action="/form-send" data-block="<?= $block->id() ?>" enctype="multipart/form-data" data-language="<?= $language ?>"> 
    <input type="hidden" name="csrf" value="<?= csrf() ?>">
    <input type="hidden" name="origin" value="<?= esc($page->url()) ?>">
    <input type="hidden" name="language" value="<?= $kirby->languageCode() ?>">
    <div class="form-wrapper">
      <div class="fields">
        <?php if(!$formpage->checkEmailField()): ?>
          <div class="email-field-restricted restricted-field">
            <h5><label for="email">Email</label></h5>  
            <input 
              class="<?= (!empty($errors) && !empty($errors['data']) && array_key_exists('email', $errors['data'])) ? 'error' : ''; ?>" 
              type="email" 
              id="email"
              name="email"
              placeholder="Email"
              value = "<?= $data != NULL ? esc($data['email']) : ''; ?>"
              required
              data-type="email"
            />
            <?php if(!empty($errors) && !empty($errors['data']) && array_key_exists('email', $errors['data'])): ?>
              <p class="email-field-restricted-text"><?= $errors['data']['email']; ?></p>
            <?php endif; ?>
          </div>
        <?php endif; ?>
        <?php foreach ($formpage->getFormFields() as $block): ?>
          <?php
            $percentage = tailwindPerecentage($block->size()->value());
            $block->size()->value() != '1/1' ? $spacing = '10px' : $spacing = '0px';
          ?> 
          <?php if($block->type() == 'checkbox'): ?>
            <div class="block-type-<?= $block->type() ?> checkbox <?= $data != NULL && isset($data[$block->uniqueidentifier()->value()]) ? 'checked' : ''?>">
              <?php snippet('blocks/' . $block->type(), [
                'block' => $block,
                'data' => $data,
                'errors' => $errors
              ]) ?>
          <?php elseif($block->type() == 'file'): ?>
            <div class="block-type-<?= $block->type() ?> form-file-block">
              <?php snippet('blocks/' . $block->type(), [
                'block' => $block,
                'files' => $files,
                'errors' => $errors,
                'language' => $language
              ]) ?>
          <?php else: ?>
            <div class="block-type-<?= $block->type() ?> dynamic-width form-block <?= $block->required()->toBool() === true ? 'restricted-field' : '' ?>" style="--block-width: <?= $percentage ?>; --block-offset: <?= $spacing ?>;">
              <h5><label for="<?= $block->uniqueidentifier()?>"><?= ucfirst($block->fieldlabel())?></label></h5>   
              <?php snippet('blocks/' . $block->type(), [
                'block' => $block,
                'data' => $data,
                'errors' => $errors
              ]) ?>
          <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <div class="checkbox checbox-gdpr <?= $data != NULL && isset($data[$block->uniqueidentifier()->value()]) ? 'checked' : ''?>">
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
        <div class="g-recaptcha" data-sitekey="<?= $formpage->recaptchaSiteKey() ?>"></div>
      </div>
      <button class="send-button send-button-<?=$formpage->sendButtonType() ?>" type="submit"><?= $formpage->sendButtonText() ?></button>
    </div>
  </form>
<?php endif; ?>