<input
  class="w-full rounded-sm border-black border-solid border-2 px-5 py-5 <?= (!empty($errors) && !empty($errors['data']) && array_key_exists($block->uniqueidentifier()->value(), $errors['data'])) ? 'border-red-800' : ''; ?>"
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
  <p class="text-base text-red-800"><?= $errors['data'][$block->uniqueidentifier()->value()]; ?></p>
<?php endif; ?>