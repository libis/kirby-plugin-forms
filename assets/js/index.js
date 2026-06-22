import { form } from '../js/form.js';
import { select } from '../js/select.js';
import { files } from '../js/file.js';

document.addEventListener('DOMContentLoaded', async () => {
    //form
    const forms = document.querySelectorAll('.form');

    forms.forEach(formElement => {
        formElement.addEventListener('submit', function (e) {
            form(formElement);
        });
    });

    //select
    const selectWrappers = document.querySelectorAll('.select-wrapper');
    selectWrappers.forEach(selectWrapper => {
        select(selectWrapper);
    });

    //file
    const fileBlocks = document.querySelectorAll('.form-file-block');

    for (const fileBlock of fileBlocks) {
        const form = fileBlock.closest('form');
        const lang = form.dataset.language;
        const translation = await loadTranslation(lang);
        files(fileBlock, translation);
    }

});

async function loadTranslation(lang) {
  try {
    const response = await fetch(`/media/plugins/libis/forms/translations/${lang}.json`);
    if (!response.ok) throw new Error('Bestand niet gevonden');
    const data = await response.json();
    return data;
  } catch (error) {
    console.error('Fout bij laden vertaling:', error);
  }
}
