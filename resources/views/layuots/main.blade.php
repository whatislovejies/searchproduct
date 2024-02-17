@extends('layuots.layuot')
@section('title', 'Главная')
@section('content')
<link rel="shortcut icon" href="#">
<div id="parallax-container">
    <canvas id="smokeCanvas" width="715" height="600"></canvas>
    <div id="parallax-text">
        <h2>Сравни цены на товары</h2>
        <p class="typewriter">Найдите лучшие предложения и сэкономьте деньги при покупке у нас. </p>
        <p>Мы предлагаем широкий ассортимент товаров по лучшим ценам.</p>
        <a href="/сравнение-товаров" class="btn">Сравнить</a>
    </div>
      <svg xmlns="{{ asset('public/img/wave.svg') }}" viewBox="0 0 1440 320">
        <path fill="#0099ff" fill-opacity="1111.11" d="M0,224L30,234.7C60,245,120,267,180,250.7C240,235,300,181,360,160C420,139,480,149,540,170.7C600,192,660,224,720,202.7C780,181,840,107,900,80C960,53,1020,75,1080,106.7C1140,139,1200,181,1260,202.7C1320,224,1380,224,1410,224L1440,224L1440,320L1410,320C1380,320,1320,320,1260,320C1200,320,1140,320,1080,320C1020,320,960,320,900,320C840,320,780,320,720,320C660,320,600,320,540,320C480,320,420,320,360,320C300,320,240,320,180,320C120,320,60,320,30,320L0,320Z"></path>
    </svg>
</div>
<section id="featured-products">
<div class="post-wrap">
    <div class="post-item">
    <div class="item-content">
    <div class="item-icon group"></div>
    <div class="item-body">
    <h3>Смартфоны</h3>
    <p>Сравни цены на смартфоны разных брендов и моделей.</p>
    </div>
    <div class="item-footer">
    <a href="#" class="link"><span>Подробнее</span></a>
    </div>
    </div>
    </div>
    
    <div class="post-item">
    <div class="item-content">
    <div class="item-icon tree"></div>
    <div class="item-body">
    <h3>Ноутбуки</h3>
    <p>Найди лучшие предложения на ноутбуки для работы и развлечений</p>
    </div>
    <div class="item-footer">
    <a href="#" class="link"><span>Подробнее</span></a>
    </div>
    </div>
    </div>
    
    <div class="post-item">
    <div class="item-content">
    <div class="item-icon anchor"></div>
    <div class="item-body">
    <h3>Телевизоры</h3>
    <p>Сравни цены на телевизоры разных размеров и марок.</p>
    </div>
    <div class="item-footer">
    <a href="#" class="link"><span>Подробнее</span></a>
    </div>
    </div>
    </div>
    
    <div class="post-item">
    <div class="item-content">
    <div class="item-icon video"></div>
    <div class="item-body">
    <h3>Фотокамеры</h3>
    <p>ыбери лучшую фотокамеру для своих фотографических нужд.</p>
    </div>
    <div class="item-footer">
    <a href="#" class="link"><span>Подробнее</span></a>
    </div>
    </div>
    </div>
    
    <div class="post-item">
    <div class="item-content">
    <div class="item-icon photo"></div>
    <div class="item-body">
    <h3>Наушники</h3>
    <p>Сравни цены на качественные наушники для музыки и аудиобука.</p>
    </div>
    <div class="item-footer">
    <a href="#" class="link"><span>Подробнее</span></a>
    </div>
    </div>
    </div>
    
    <div class="post-item">
    <div class="item-content">
    <div class="item-icon gift"></div>
    <div class="item-body">
    <h3>Планшеты</h3>
    <p>Сравни характеристики и цены на планшеты для работы и развлечений.</p>
    </div>
    <div class="item-footer">
    <a href="#" class="link"><span>Подробнее</span></a>
    </div>
    </div>
    </div>
    </div>
    </section>
<section id="search">
    <input type="text" placeholder="Поиск товаров...">
    <button class="btnn">Искать</button>
</section>
<script src="{{ asset('public/js/smoke.js') }}"></script>

