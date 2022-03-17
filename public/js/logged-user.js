// Перейти к загрузке скриншота
document.getElementById("loadFileBtn").addEventListener('click', function (event) {
  document.location.href = "/new-file";
});

// Выход
document.getElementById("exitBtn").addEventListener('click', function (event) {
  fetch('/logout', { method: 'POST' })
    .then(response => response)
    .then(result => { location.href = location.href; })
    .catch(error => console.log(error));
});
