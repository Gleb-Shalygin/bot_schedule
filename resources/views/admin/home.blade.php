@extends('layouts.menu_auth')

@section('title', 'Админ панель')
@section('header')
@endsection


@section('content')
    <section class="page-section bg-primary text-white wrapper flex-grow-1" style="flex: 1 1 auto">
        <div class="container">
{{--            <div id="app">--}}
                <admin-component></admin-component>
{{--            </div>--}}
        </div>
    </section>
    <!-- Copyright Section-->
    <div class="copyright py-4 text-center text-white">
        <div class="container"><small>Telegram &copy; gleb_shalygin 2023</small></div>
    </div>
@endsection

@section('footer')
@endsection
