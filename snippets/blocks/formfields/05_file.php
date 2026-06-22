<h5>
    <label class="font-semibold underline" for="<?= $block->uniqueidentifier()?>">
        <?= ucfirst($block->fieldlabel())?>
    </label> &nbsp;
    <span class="max-files">
        <?php $translation = t('libis.forms.files.begin.info', null, $language);
            echo Str::template($translation, [
                'max' => $block->maximumfiles()
            ]);
        ?>
    </span>
    <span class="file-error w-full flex flex-col">
        <span class="file-before-error form-text-hidden text-red-800"></span>
        <span class="file-after-error text-red-800">
            <?php if($errors != NULL && isset($errors['data']) && isset($errors['data'][$block->uniqueidentifier()->value()])): ?>
                <ul class="list-disc">
                    <?php foreach($errors['data'][$block->uniqueidentifier()->value()] as $error): ?>
                        <li class="ml-20"><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </span>
    </span>
</h5>
<input 
    type="file" 
    id= "<?= $block->uniqueidentifier()?>"
    name="<?= $block->uniqueidentifier()?>[]"
    class="form-file-type"
    accept=".jpg, .jpeg, .png"
    multiple 
    data-maxfiles="<?= $block->maximumfiles()?>"
    data-files="<?= $files != NULL && $files[$block->uniqueidentifier()->value()] != NULL ? htmlspecialchars(json_encode($files[$block->uniqueidentifier()->value()]), ENT_QUOTES, 'UTF-8') : "" ?>"
    data-type="files"
/>
<div class="preview file-empty"></div>