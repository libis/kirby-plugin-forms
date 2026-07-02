<textarea
  class="textarea-field <?= (!empty($errors) && !empty($errors['data']) && array_key_exists($block->uniqueidentifier()->value(), $errors['data'])) ? 'error' : ''; ?>"
  id="<?= $block->uniqueidentifier()?>"
  name="<?= $block->uniqueidentifier()?>"
  rows="<?= $block->rows() ?>"
  placeholder="<?= $block->placeholder()?>"
  data-type="textarea"
<?php if($block->required()->toBool() === true):?>
    required
  <?php endif; ?>
><?= $data != NULL ? esc($data[(string)$block->uniqueidentifier()]) : ''; ?></textarea>
<?php if(!empty($errors) && !empty($errors['data']) && array_key_exists($block->uniqueidentifier()->value(), $errors['data'])): ?>
  <p class="textarea-field-text"><?= $errors['data'][$block->uniqueidentifier()->value()]; ?></p>
<?php endif; ?>