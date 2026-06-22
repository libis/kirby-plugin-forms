let t = "";
function files(fileWrapper, translation) {
  const input = fileWrapper.querySelector('input');
  const preview = fileWrapper.querySelector(".preview");
  const errorSpan = fileWrapper.querySelector('.file-before-error');

  t = translation;

  const fileMax = input.dataset.maxfiles; // this data is coming from the user who made the form
  const maxFileSize = 2 * 1024 * 1024; // 2MB in bytes

  let selectedFiles = []; // this array wil be use to preview the images and replace it when needed with the input files

  // listen to the input when there is someting is changed (new images, ...)
  input.addEventListener("change", function () {
      let files = Array.from(input.files);
      
      const validFiles = files.filter(file => file.size <= maxFileSize);
      const hasTooManyFiles = files.length > fileMax;
      const hasTooLargeFiles = validFiles.length < files.length;

      let errorMessage = "";

      //if the selected images are more then 2 MB then filter them out and replace the input      
      if (hasTooLargeFiles) {
        errorMessage = t["libis.forms.sizeToBig"];

        const dataTransfer = new DataTransfer();
        validFiles.forEach(file => dataTransfer.items.add(file));
        input.files = dataTransfer.files;
        files = validFiles;
      }

      //if there are to many images set some error text       
      if (hasTooManyFiles) {
        if(errorMessage == "") {
          errorMessage = translate(t["libis.forms.toManyFiles"], {
            fileMax: fileMax,
            fileslength: files.length
          });
        }
        else {
          errorMessage += (errorMessage ? '<br>' : '') + translate(t["libis.forms.toManyFiles"], {
            fileMax: fileMax,
            fileslength: files.length
          });
        }
      }
      
      if (errorMessage) {
        errorSpan.classList.remove('form-text-hidden');
        errorSpan.innerHTML = errorMessage;
      } else {
        errorSpan.classList.add('form-text-hidden');
        errorSpan.innerHTML = '';
      }

      selectedFiles = files;
      // call the function to display the selected images
      updatePreview();
  });

  function updatePreview() {
      preview.innerHTML = '';    
      //if there are no images add a class and return
      preview.classList.toggle('file-empty', selectedFiles.length === 0);
      if (selectedFiles.length === 0) return;

      //create a list where we can add the list with images
      const list = document.createElement("ul");
      preview.appendChild(list);

      // for every image that there is we add an item with the image and a text with some info about the image
      selectedFiles.forEach((file, index) => {
        const listItem = document.createElement("li");
        const p = document.createElement("p");

        p.textContent = validFileType(file)
        ? translate(t["libis.forms.imageInfo"], {name: file.name, size: returnFileSize(file.size)})
        : translate(t["libis.forms.wrongFileExtension"], {name: file.name});
  
        // make it possible that user can delete an image out of the list
        if (validFileType(file)) {
            const image = document.createElement("img");
            image.src = URL.createObjectURL(file);
            image.alt = image.title = file.name;

            const removeBtn = document.createElement("button");
            removeBtn.classList.add('file-delete-btn');
            removeBtn.textContent = "Verwijder";

            //if the image is deleted take the wright image and delete this and update the input
            removeBtn.addEventListener("click", () => {
                selectedFiles.splice(index, 1);

                const dataTransfer = new DataTransfer();
                selectedFiles.forEach(file => dataTransfer.items.add(file));

                input.files = dataTransfer.files;
                input.dispatchEvent(new Event("change"));
            });

            listItem.appendChild(image);
            listItem.appendChild(p);
            listItem.appendChild(removeBtn);
        }

        list.appendChild(listItem);
      });
  }

  //if php render the 
  const filesFromServer = input.dataset.files;

  if (filesFromServer) {
    const dataTransfer = new DataTransfer();

    JSON.parse(filesFromServer).forEach(fileData => {    
      const bytes = Uint8Array.from(atob(fileData.content), c => c.charCodeAt(0));
      dataTransfer.items.add(new File([bytes], fileData.name, { type: fileData.type }));
    });

    input.files = dataTransfer.files;
    input.dispatchEvent(new Event("change"));
  }
}

const fileTypes = ["image/jpeg", "image/jpg", "image/png", "image/webp"];

function validFileType(file) {
  return fileTypes.includes(file.type);
}

const returnFileSize = size =>
  size < 1e3 ? `${size} bytes` :
  size < 1e6 ? `${(size / 1e3).toFixed(1)} KB` :
  `${(size / 1e6).toFixed(1)} MB`;



function translate(key, replacements = {}) {
  const raw = t[key];
  let text = typeof raw === "string" ? raw : key;

  for (const [placeholder, value] of Object.entries(replacements)) {
    text = text.replace(`{${placeholder}}`, value);
  }

  return text;
}


export { files };