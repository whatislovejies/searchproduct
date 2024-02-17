<form method="POST" action="{{ route('register') }}" class="form panel__register-form" id="register-form">
  @csrf
  <div class="form__row">
    <input type="text" id="register-email" class="form__input" name="name" data-validation="name" data-error="Ведите имя." required>
    <span class="form__bar"></span>
    <label for="register-name" class="form__label">Имя</label>
    <span class="form__error"></span>
  </div>
  <div class="form__row">
    <input type="text" id="register-email" class="form__input" name="email" data-validation="email" data-error="Неверный адрес электронной почты." required>
    <span class="form__bar"></span>
    <label for="register-email" class="form__label">Адрес электронной почты</label>
    <span class="form__error"></span>
  </div>
  <div class="form__row">
    <input type="password" id="register-password" class="form__input" name="password" data-validation="length" data-validation-length="8-25" data-error="Пароль должен содержать от 8 до 25 символов." required>
    <span class="form__bar"></span>
    <label for="register-password" class="form__label">Пароль</label>
    <span class="form__error"></span>
  </div>
  <div class="form__row">
    <input type="password" id="register-password-check" class="form__input" name="password_confirmation" data-validation="confirmation" data-validation-confirm="password" data-error="Пароли не совпадают." required>
    <span class="form__bar"></span>
    <label for="register-password-check" class="form__label">Подтверждение пароля</label>
    <span class="form__error"></span>
  </div>
  <div class="form__row">
    <input type="submit" class="form__submit" value="Зарегистрироваться!">
  </div>
</form>
<form class="form panel__password-form" id="password-form" method="post" action="/">
  <div class="form__row">
    <p class="form__info">Не можете войти? Пожалуйста, введите ваш адрес электронной почты. Мы отправим вам письмо с инструкциями по сбросу пароля.</p>
  </div>
  <div class="form__row">
    <input type="text" id="retrieve-pass-email" class="form__input" name="retrieve-mail" data-validation="email" data-error="Неверный адрес электронной почты." required>
    <span class="form__bar"></span>
    <label for="retrieve-pass-email" class="form__label">Адрес электронной почты</label>
    <span class="form__error"></span>
  </div>
  <div class="form__row">
    <input type="submit" class="form__submit" value="Отправить новый пароль!">
  </div>
</form>