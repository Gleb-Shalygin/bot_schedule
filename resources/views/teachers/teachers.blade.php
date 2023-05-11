@extends('layouts.menu_auth')

@section('title', 'Преподы')
@section('header')
@endsection


@section('content')
    <section class="page-section text-secondary wrapper flex-grow-1 mt-5" style="flex: 1 1 auto">
        <div class="container">
            <teachers-component></teachers-component>
        </div>
    </section>
    <!-- Copyright Section-->
    <div class="copyright py-4 text-center text-white">
        <div class="container"><small>Telegram &copy; gleb_shalygin 2023</small></div>
    </div>
@endsection

@section('footer')
@endsection
