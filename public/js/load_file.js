// Загрузка скриншота

let inputFile = document.getElementById("inputFile");

inputFile.addEventListener('change', function (e) {
  let inputButton = document.getElementById("inputFileBtn");
  let fileName = inputFile.files[0].name;

  if (fileName.length <= 20) {
    inputButton.innerText = fileName;

  } else {
    inputButton.innerText = fileName.substring(0, 17) + '...';
  }
});


let loadFileSubmitBtn = document.getElementById("loadFileSubmitBtn");
let fileForm = document.getElementById("fileForm");


fileForm.addEventListener('submit', function (event) {
  event.preventDefault();

  let file = inputFile.files[0];
  let fileType = file.type;

  if (fileType != "image/png" && fileType != "image/jpeg") {
    showError(loadFileSubmitBtn, "Скриншот данного формата не поддерживается");
    return;
  }

  if (!file) {
    showError(loadFileSubmitBtn, "Пожалуйста, выберите файл");
    return;
  }

  hideError();

  let loadFileForm = new FormData();
  loadFileForm.append('isPrivate', fileForm.isPrivate.checked);
  loadFileForm.append('file', file);

  fetch('/new-file', {
       method: 'POST',
       body: loadFileForm
    }
  )
  .then(response => response.json())
  .then(result => {
    if (result.errors) {
      showError(loadFileSubmitBtn, result.errors);

    } else { // успешная загрузка файла
      hideError();
      location.href = "/detail/" + result.id;
    }
  })
  .catch(error => console.log(error));
});

function showError(element, text) {
  let formError = document.getElementById("formError");
  formError.innerHTML = "*" + text;
  formError.style.display = "block";
  element.after(formError);
}

function hideError() {
  document.getElementById("formError").style.display = "none";
}