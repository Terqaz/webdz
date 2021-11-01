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

var captcha = document.getElementById("captcha");
modalBottomRegBtn.before(captcha);


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

var regForm = document.getElementById("regForm");

regForm.name.addEventListener('input', function (event) {
  var name = regForm.name;

  if (!name.validity.valid) {
    showError(name, "Введите корректное имя");
  } else {
    hideError();
  }
});

regForm.email.addEventListener('input', function (event) {
  checkEmailValidity(regForm.email);
});

regForm.phone.addEventListener('input', function (event) {
  var phone = regForm.phone;

  if (!phone.validity.valid) {
    showError(phone, "Введите корректный номер телефона");
  } else {
    hideError();
  }
});

regForm.password.addEventListener('input', function (event) {
  var password = regForm.password;
  var repeatPassword = regForm.repeatPassword;

  if (checkPasswordValidity(password)){
    checkPasswordsEqValidity(password, repeatPassword);
  }
});

regForm.repeatPassword.addEventListener('input', function (event) {
  var password = regForm.password;
  var repeatPassword = regForm.repeatPassword;

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

regForm.addEventListener('submit', function (event) {
  var password = regForm.password.value;
  var repeatPassword = regForm.repeatPassword.value;

  for (var i = 0; i < regForm.length; i++) {
    if (!regForm[i].validity.valid) {
      event.preventDefault();
      return;
    }
  }
  console.log('Register: ' 
    +'\nName: '            + regForm.name.value 
    +'\nEmail: '           + regForm.email.value 
    +'\nPhone number: '    + regForm.phone.value
    +'\nPassword: '        + password
    +'\nRepeat password: ' + repeatPassword); 
});


var loginForm = document.getElementById("loginForm");

loginForm.email.addEventListener('input', function (event) {
  checkEmailValidity(loginForm.email);
});

loginForm.password.addEventListener('input', function (event) {
  let password = loginForm.password;
  if (password.value.length == 0) {
    showErrorWithCustomValidity(password, "Введите корректный пароль");
  } else {
    hideError();
    password.setCustomValidity("");
  }
});

loginForm.addEventListener('submit', function (event) {
  for (var i = 0; i < loginForm.length; i++) {
    if (!loginForm[i].validity.valid) {
      event.preventDefault();
      return;
    }
  }
  console.log('Login: '
    +'\nEmail: '    + loginForm.email.value 
    +'\nPassword: ' + loginForm.password.value);
});

function checkEmailValidity(email) {
  if (!email.validity.valid) {
    showError(email, "Введите корректный email");
  } else {
    hideError();
  }
}

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


// reCAPTCHA
function onClick(e) {
  e.preventDefault();
  grecaptcha.ready(function() {
    grecaptcha.execute('reCAPTCHA_site_key', {action: 'submit'}).then(function(token) {
        // Add your logic to submit to your backend server here.
    });
  });
}
