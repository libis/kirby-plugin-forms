<input
  class="input-field <?= (!empty($errors) && !empty($errors['data']) && array_key_exists($block->uniqueidentifier()->value(), $errors['data'])) ? 'error' : ''; ?>"
  type="<?= $block->inputtype()?>"
  id="<?= $block->uniqueidentifier()?>"
  name="<?= $block->uniqueidentifier()?>"
  placeholder="<?= $block->placeholder()?>"
  value = "<?= $data != NULL ? htmlspecialchars($data[(string)$block->uniqueidentifier()]) : ''; ?>"
  <?php if($block->required()->toBool() === true):?>
    required
  <?php endif; ?>
  data-type="<?= $block->inputtype()?>"
  <?php if($block->inputtype() == "number"): ?>
    step=any
  <?php endif; ?>
/>
<?php if(!empty($errors) && !empty($errors['data']) && array_key_exists($block->uniqueidentifier()->value(), $errors['data'])): ?>
  <p class="input-field-text"><?= $errors['data'][$block->uniqueidentifier()->value()]; ?></p>
<?php endif; ?>