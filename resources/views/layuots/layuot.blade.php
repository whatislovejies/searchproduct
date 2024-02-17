<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main | @yield('title','home')</title>
    <link rel="stylesheet" href="{{ asset('public/css/style.css') }}">
    <link rel="shortcut icon" href="#">

</head>
<body>
    <header>
        <div class="header-container">
            <ul class="snip1226">
                <li class="current"><a href="/" data-hover="Главная" class="a">Главная</a></li>
                <li><a href="/products" data-hover="Товары" class="a">Товары</a></li>
                <li><a href="/about" data-hover="О нас" class="a">О нас</a></li>
                <li><a href="#" data-hover="Контакты" class="a">Контакты</a></li>
                @if(auth()->check())
                <div class="dropdown left-ship" >
                    <button id="dropdown-button" class="dropbtn">
                        <div>{{ auth()->user()->name }}</div>
                        <div class="ml-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </button>
                    @php
                        $userRole = app('App\Http\Controllers\ProfileController')->hasRole(request());
                    @endphp
                    @if($userRole === 'admin')
                    <div id="dropdown-content" class="dropdown-content">
                    <a href="/admin/favorites" class="dropdown-element">Избранные пользователей</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" class="dropdown-element" onclick="event.preventDefault(); this.closest('form').submit();">Выход</a>
                    </form>
                    </div>
                    @else
                    <div id="dropdown-content" class="dropdown-content">
                        <a href="/profile" class="dropdown-element">Личный кабинет</a>
                        <a href="/favorites" class="dropdown-element">Избранные</a>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" class="dropdown-element" onclick="event.preventDefault(); this.closest('form').submit();">Выход</a>
                        </form>
                    </div>
                </div>
                @endif
                @else
                <li class="left-ship"><a href="/auth" data-hover="Авторизация" class="a">Авторизация</a></li>
                @endif
            </ul>
        </div>
    </header>
    <div class="content">
        @yield('content')
    </div>
    
    <footer>
        <div class="footer-content">
            <div class="footer-links">
                <ul>
                    <li><a href="#">Главная</a></li>
                    <li><a href="#">Товары</a></li>
                    <li><a href="#">О нас</a></li>
                    <li><a href="#">Контакты</a></li>
                </ul>
            </div>
        
        </div>
        <div class="contact-info">
            <p>Email: info@example.com</p>
            <p>Телефон: +1 123-456-7890</p>
        </div>
        <div class="copyright">
            &copy; 2023 Ваша Компания. Все права защищены.
        </div>
    </footer>
    <script>
    const dropdownButton = document.getElementById('dropdown-button');
const dropdownContent = document.getElementById('dropdown-content');

dropdownButton.addEventListener('click', function() {
    dropdownContent.classList.toggle('active');
});

document.addEventListener('click', function(event) {
    if (!dropdownButton.contains(event.target)) {
        dropdownContent.classList.remove('active');
    }
});
    </script>
</body>
</html>
