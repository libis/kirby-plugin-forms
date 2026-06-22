function select(selectWrapper) {
    const selectItem = selectWrapper.querySelector('select');
    const selectLength = selectItem.length;
    const newSelectItem = selectWrapper.querySelector('.select-form-item');
    const optionsDiv = selectWrapper.querySelector('.select-items');

    newSelectItem.innerHTML = selectItem.options[selectItem.selectedIndex].innerHTML;

    for (let j = 0; j < selectLength; j++) {
        const optionDiv = document.createElement("Button");
        optionDiv.type = "button";
        optionDiv.setAttribute("class", "select-item body-text");
        optionDiv.innerHTML = selectItem.options[j].innerHTML;

        optionDiv.addEventListener("click", function(e) {
            Array.from(selectItem.options).forEach((option, index) => {
                if (option.innerHTML === this.innerHTML) {
                    selectItem.selectedIndex = index;
                    newSelectItem.innerHTML = this.innerHTML;
                }
            });

            newSelectItem.click();
        });
        optionsDiv.appendChild(optionDiv);
    }

    newSelectItem.addEventListener("click", function(e) {
        e.stopPropagation();
        newSelectItem.nextElementSibling.classList.toggle("select-hide");
        newSelectItem.classList.toggle("select-open");
        newSelectItem.classList.toggle("select-arrow-active");
    });
}

export { select };