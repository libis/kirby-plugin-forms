<textarea
  class="w-full rounded-sm border-black border-solid border-2 px-5 py-5 <?= (!empty($errors) && !empty($errors['data']) && array_key_exists($block->uniqueidentifier()->value(), $errors['data'])) ? 'border-red-800' : ''; ?>"
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
  <p class="text-base text-red-800"><?= $errors['data'][$block->uniqueidentifier()->value()]; ?></p>
<?php endif; ?>