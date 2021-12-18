// Обработка формы

var mask = document.getElementsByClassName("mask")[0];
var modal = document.getElementsByClassName("modal__wrapper")[0];
var authBtn = document.getElementsByClassName("auth-btn")[0];
var closeSpanBtn = document.getElementsByClassName("modal__content__close")[0];

authBtn.onclick = function() {
  mask.style.display = "block";
  modal.style.display = "block";
}

closeSpanBtn.onclick = function() {
  mask.style.display = "none";
  modal.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == modal) {
    mask.style.display = "none";
    modal.style.display = "none";
  }
} 

var modalContentRegistration = document.getElementsByClassName("modal__content__registration")[0];
var modalBottomRegBtn = document.getElementsByClassName("modal-footer__to-registration-btn")[0];

var modalContentLogin = document.getElementsByClassName("modal__content__login")[0];
var modalBottomLoginBtn = document.getElementsByClassName("modal-footer__to-login-btn")[0];

modalBottomRegBtn.onclick = function() {
  modalContentRegistration.style.display = "block";
  modalBottomRegBtn.disabled = true;

  modalContentLogin.style.display = "none";
  modalBottomLoginBtn.disabled = false;
}

modalBottomLoginBtn.onclick = function() {
  modalContentRegistration.style.display = "none";
  modalBottomRegBtn.disabled = false;

  modalContentLogin.style.display = "block";
  modalBottomLoginBtn.disabled = true;
}

// Валидация формы регистрации

var regFormElement = document.getElementById("regForm");

regFormElement.name.addEventListener('input', function (event) {
  var name = regFormElement.name;

  if (!name.validity.valid) {
    showError(name, "Введите корректное имя");
  } else {
    hideError();
  }
});

regFormElement.email.addEventListener('input', function (event) {
  checkEmailValidity(regFormElement.email);
});

regFormElement.phone.addEventListener('input', function (event) {
  var phone = regFormElement.phone;

  if (!phone.validity.valid) {
    showError(phone, "Введите корректный номер телефона");
  } else {
    hideError();
  }
});

regFormElement.password.addEventListener('input', function (event) {
  var password = regFormElement.password;
  var repeatPassword = regFormElement.repeatPassword;

  if (checkPasswordValidity(password)){
    checkPasswordsEqValidity(password, repeatPassword);
  }
});

regFormElement.repeatPassword.addEventListener('input', function (event) {
  var password = regFormElement.password;
  var repeatPassword = regFormElement.repeatPassword;

  if (!checkPasswordsEqValidity(password, repeatPassword)) {
    checkPasswordValidity(password);
  }
});

function checkPasswordValidity(password) {
  if (password.value.length < 6) {
    showErrorWithCustomValidity(password, "Пароль должен включать в себя минимум 6 символов");

  } else if (password.value.length === String(parseInt(password.value)).length) {
    showErrorWithCustomValidity(password, "Пароль не должен состоять только из цифр");

  } else {
    hideError();
    password.setCustomValidity("");
    return true;
  }
  return false;
}

function checkPasswordsEqValidity(password, repeatPassword) {
  let cond = password.value !== repeatPassword.value;
  if (cond) {
    showErrorWithCustomValidity(repeatPassword, "Пароли должны совпадать");
  } else {
    hideError();
    repeatPassword.setCustomValidity("");
  }
  return cond;
}

// Валидация формы логина

var loginFormElement = document.getElementById("loginForm");

loginFormElement.email.addEventListener('input', function (event) {
  checkEmailValidity(loginFormElement.email);
});

loginFormElement.password.addEventListener('input', function (event) {
  let password = loginFormElement.password;
  if (password.value.length == 0) {
    showErrorWithCustomValidity(password, "Введите корректный пароль");
  } else {
    hideError();
    password.setCustomValidity("");
  }
});

function showError(element, text) {
  let formError = document.getElementById("formError");
  formError.innerHTML = "*" + text;
  formError.style.display = "block";
  element.after(formError);
}

function showErrorWithCustomValidity(element, text) {
  showError(element, text);
  element.setCustomValidity(text);
}

function hideError() {
  document.getElementById("formError").style.display = "none";
}

// Отправка данных форм

regFormElement.addEventListener('submit', function (event) {
  var password = regFormElement.password.value;
  var repeatPassword = regFormElement.repeatPassword.value;

  for (var i = 0; i < regFormElement.length; i++) {
    if (!regFormElement[i].validity.valid) {
      event.preventDefault();
      return;
    }
  }

  event.preventDefault();

  let registerForm = new FormData();
  registerForm.append('name', regFormElement.name.value);
  registerForm.append('email', regFormElement.email.value);
  registerForm.append('phone', regFormElement.phone.value);
  registerForm.append('password', password);

  fetch('register.php', {
       method: 'POST',
       body: registerForm
    }
  )
  .then(response => response.json())
  .then(result => {
    if (result.errors) {
       showError(document.getElementById("regForm"), result.errors);
       event.preventDefault();

    } else { // успешная регистрация, обновляем страницу
      hideError();
      location.href = location.href;
    }
  })
  .catch(error => console.log(error));
});


loginFormElement.addEventListener('submit', function (event) {
  for (var i = 0; i < loginFormElement.length; i++) {
    if (!loginFormElement[i].validity.valid) {
      event.preventDefault();
      return;
    }
  }

  let loginForm = new FormData();
  loginForm.append('email', loginFormElement.email.value);
  loginForm.append('password', loginFormElement.password.value);

  event.preventDefault();

  fetch('login.php', {
       method: 'POST',
       body: loginForm
    }
  )
  .then(response => response.json())
  .then(result => {
    if (result.errors) {
       showError(document.getElementById("loginForm"), result.errors);

    } else { // успешный вход, обновляем страницу
      hideError();
      location.href = location.href;
    }
  })
  .catch(error => console.log(error));
});

function checkEmailValidity(email) {
  if (!email.validity.valid) {
    showError(email, "Введите корректный email");
  } else {
    hideError();
  }
}
