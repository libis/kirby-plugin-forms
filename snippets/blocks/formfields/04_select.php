<?php 
if($block->optiontype()->value() == 'normal') {
  $options = $block->optionsnormal()->toBlocks();
}
else {
  $options = $block->optionsemail()->toBlocks();
}
?>
<div class="select-wrapper">
  <select 
    id="<?= $block->uniqueidentifier()?>"
    name="<?= $block->uniqueidentifier()?>"
    data-type="select"
  >
    <?php foreach($options as $option): ?>
      <option 
        value="<?= $option->value() ?>" 
        <?= $data != NULL && $data[$block->uniqueidentifier()->value()] == $option->value() ? 'selected' : ''?>
      >
        <?= $option->label()?>
      </option>
    <?php endforeach; ?>
  </select>
  <button type="button" class="select-form-item">

  </button>
  <div class="select-items select-hide">

  </div>
</div>