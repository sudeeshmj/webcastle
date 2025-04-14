@extends('layouts.app')
@section('content')
    <main class="login-form vh-100">
        <div class="container">
            <div class="row  align-items-center justify-content-center">
                <div class="col-md-6 ">
                    <img src="{{ asset('assets/image/loginlogo.png') }}" alt="Image" class="img-fluid">
                </div>
                <div class="col-md-6 contents">
                    <div class="row justify-content-center">

                        <div class="col-md-8">

                            <div class="mb-4">
                                <h3>Doctris</h3>
                                <p class="mb-4 text-muted">Doctor Appointment Booking System</p>
                            </div>
                            <form method="POST" action="{{ route('login.submit') }}">
                                @csrf
                                <div class="form-group mb-4">
                                    <label for="email">Email</label>
                                    <input type="email" required placeholder="Email" id="email" class="form-control"
                                        name="email" autofocus>
                                    @if ($errors->has('email'))
                                        <span class="text-danger fs-14">{{ $errors->first('email') }}</span>
                                    @endif
                                    @if (session()->has('message'))
                                        <span class="text-danger fs-14">{{ session()->get('message') }}</span>
                                    @endif
                                </div>

                                <div class="form-group  mb-4 ">
                                    <label for="password">Password</label>
                                    <input type="password" required placeholder="Password" id="password"
                                        class="form-control" name="password">
                                    @if ($errors->has('password'))
                                        <span class="text-danger fs-14">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>

                                <div class="d-grid mx-auto">
                                    <button type="submit" class="btn btn-block btn-primary login-btn">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
