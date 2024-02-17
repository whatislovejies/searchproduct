<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <title>авторизация</title>
    <link rel="shortcut icon" href="#">
    <link rel="stylesheet" href="{{ asset('public/css/auth.css') }}">
  </head>
  <body>
    <div class="panel_blur"></div>
    <div class="panel">
      <div class="panel__form-wrapper">
        <a href="/">
        <button type="button" class="panel__prev-btn" aria-label="Вернуться на главную страницу" title="Вернуться на главную страницу">
          <svg fill="rgba(255,255,255,0.5)" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 0h24v24H0z" fill="none"/>
            <path d="M21 11H6.83l3.58-3.59L9 6l-6 6 6 6 1.41-1.41L6.83 13H21z"/>
          </svg>
        </button>
          </a>
        <ul class="panel__headers">
          <li class="panel__header"><a href="#register-form" class="panel__link" role="button">Регистрация</a></li>
          <li class="panel__header active"><a href="#login-form" class="panel__link" role="button">Вход</a></li>
        </ul>

        <div class="panel__forms">
          @include('auth.login')
          @include('auth.register')
        </div>
      </div>
    </div>
  </body>
</html>

<script src="{{asset('public/js/jquery.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>

    <script>

   $(function () {
    $(document).ready(function () {
  // Здесь ваш код инициализации jQuery Validation
});
  $("form").attr("novalidate", "novalidate");
  $(".panel__link, .form__retrieve-pass").on("click", function (e) {
    e.preventDefault();

    if ($(this).attr("href") === "#password-form") {
      $(".panel__header").removeClass("active");
    } else {
      $(this).parent().addClass("active");
      $(this).parent().siblings().removeClass("active");
    }
    target = $(this).attr("href");
    $(".panel__forms > form").not(target).hide();
    $(target).fadeIn(500);
  });

  $(".panel__prev-btn").on("click", function (e) {
    $(".panel, .panel_blur").fadeOut(300);
  });
});

$.validate({
  modules: "security",
  errorMessageClass: "form__error",
  validationErrorMsgAttribute: "data-error"
});


    </script>
  </body>
</html>
