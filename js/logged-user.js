// Выход

document.getElementById("exitBtn").addEventListener('click', function (event) {
  fetch('logout.php', { method: 'POST' })
  .then(response => response)
  .then(result => {location.href = location.href;})
  .catch(error => console.log(error));
});