function form(formElement) {
  const block = formElement.dataset.block;
  const formdata = new FormData(formElement);

  for (const [key, value] of formdata.entries()) {
    if (!['origin', 'g-recaptcha-response', 'language', 'csrf'].includes(key)) {
      const cleanKey = key.replace(/\[\]$/, ''); // delete []
      const formItem = formElement.querySelector(`[name="${key}"]`);
      const type = formItem?.dataset?.type;

      if (type !== undefined) {
        const hiddenType = document.createElement('input');
        hiddenType.type = 'hidden';
        hiddenType.name = `__type_${cleanKey}`;
        hiddenType.value = type;
        formElement.appendChild(hiddenType);
      }
    }
  }

  const blockInput = document.createElement('input');
  blockInput.type = 'hidden';
  blockInput.name = 'block-id';
  blockInput.value = block;
  formElement.appendChild(blockInput);

  formElement.submit();
}

export { form };
