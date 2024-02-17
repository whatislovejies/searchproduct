<form method="POST" action="{{ route('login') }}" class="form panel__login-form" id="login-form">
  @csrf
  <div class="form__row">
    <input type="text" id="email" class="form__input" name="email" data-validation="email" data-error="Неверный адрес электронной почты." required>
    <span class="form__bar"></span>
    <label for="email" class="form__label">Адрес электронной почты</label>
    <span class="form__error"></span>
  </div>
  <div class="form__row">
    <input type="password" id="password" class="form__input" name="password" data-validation="length" data-validation-length="8-25" data-error="Пароль должен содержать от 8 до 25 символов." required>
    <span class="form__bar"></span>
    <label for="password" class="form__label">Пароль</label>
    <span class="form__error"></span>
  </div>
  <div class="form__row">
    <input type="submit" class="form__submit" value="Войти!">
    <a href="#password-form" class="form__retrieve-pass" role="button">Забыли пароль?</a>
  </div>
</form>