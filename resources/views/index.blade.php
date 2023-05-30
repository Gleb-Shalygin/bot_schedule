@extends('layouts.menu_auth')

@section('title', 'Главная')
@section('header')
{{--    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />--}}
{{--    <!-- Font Awesome icons (free version)-->--}}
{{--    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>--}}
{{--    <!-- Google fonts-->--}}
{{--    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />--}}
{{--    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />--}}
{{--    <!-- Core theme CSS (includes Bootstrap)-->--}}
{{--    <link href="css/styles.css" rel="stylesheet" />--}}
@endsection


@section('content')
    <!-- Masthead-->
    <header class="masthead bg-primary text-white text-center">
        <div class="container d-flex align-items-center flex-column">
            <!-- Masthead Avatar Image-->
            <img class="masthead-avatar mb-5" src="assets/img/telegram.png" alt="..." />
            <!-- Masthead Heading-->
            <h1 class="masthead-heading text-uppercase mb-0">Начать работу с ботом</h1>
            <!-- Icon Divider-->
            <div class="divider-custom divider-light">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- Masthead Subheading-->
            <p class="masthead-subheading font-weight-light mb-0">Авторизуйтесь под логином и паролем</p>
        </div>
    </header>
    <!-- About Section-->
    <section class="page-section bg-white text-secondary mb-0" style="padding-bottom: 10%" id="about">
        <div class="container">
            <!-- About Section Heading-->
            <h2 class="page-section-heading text-center text-uppercase text-secondary">О нас</h2>
            <!-- Icon Divider-->
            <div class="divider-custom divider-light">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- About Section Content-->
            <div class="row">
                <div class="col-lg-4 ms-auto"><p class="lead">Данный бот позволяет расширять возможности благодаря telegram-bot. С помощью бота помощника преподаватели смогут вносить расписание на грядущую неделю, а так-же задавать на несколько недель вперед.</p></div>
                <div class="col-lg-4 me-auto"><p class="lead">Вы сможете просматривать расписание своей группы, в несколько кликов, свое расписание. Закреплять объявления для группы</p></div>
            </div>
        </div>
    </section>
    <!-- Contact Section-->
    <section class="page-section bg-primary text-white" id="contact">
        <div class="container">
            <!-- Contact Section Heading-->
            <h2 class="page-section-heading text-center text-uppercase text-white mb-0">Задайте нам вопрос</h2>
            <!-- Icon Divider-->
            <div class="divider-custom divider-light">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <div id="app">
                <support-form-component></support-form-component>
            </div>
        </div>
    </section>
    <!-- Copyright Section-->
    <div class="copyright py-4 text-center text-white">
        <div class="container"><small>Telegram &copy; gleb_shalygin 2023</small></div>
    </div>

@endsection

@section('footer')
@endsection

