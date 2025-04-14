@extends('layouts.app')
@section('content')
    <main class="sb-nav-fixed">
        @include('partials.navbar')
        <div id="layoutSidenav">
            @include('partials.sidebar')
            <div id="layoutSidenav_content">
                <main>
                    @yield('admincontent')
                </main>
            </div>
        </div>
    </main>
@endsection
