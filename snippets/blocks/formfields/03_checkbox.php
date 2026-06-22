<input type="hidden" 
  name="<?= $block->uniqueidentifier() ?>" 
  value="false">
<input 
  type="checkbox" 
  data-type="checkbox"
  class="checkbox-input--checkbox"
  id="<?= $block->uniqueidentifier()?>"
  name="<?= $block->uniqueidentifier()?>"
  value="<?= $block->value() != '' ? $block->value() : 'true' ?>"
  <?php if($block->required()->toBool() === true):?>
    required
  <?php endif; ?>
  <?= $data != NULL && isset($data[$block->uniqueidentifier()->value()]) ? 'checked' : ''?>
>
<h5>
  <label class="checkbox-label" for="<?= $block->uniqueidentifier()?>">
    <?= $block->fieldlabel();?>
    <?php if($block->required()->toBool()): ?>
      <span class="checkbox-asterisk">*</span>
    <?php endif; ?>
  </label>
</h5>  