@extends('layouts.app') <!-- Assuming you have a layout file in resources/views/layouts/app.blade.php -->

@section('title', 'Login')

@section('content')
<style>
    /* BASIC */
    html {
        background-color: white;
    }

    body {
        font-family: "Poppins", sans-serif;
        height: 100vh;
    }

    a {
        color: #92badd;
        display: inline-block;
        text-decoration: none;
        font-weight: 400;
    }

    h2 {
        text-align: center;
        font-size: 20px;
        font-weight: 600;
        text-transform: uppercase;
        display: inline-block;
        color: #cccccc;
    }

    h3 {
        display: inline-block;
        color: #cccccc;
        margin-top: 10px;
    }

    /* STRUCTURE */
    .wrapper {
        display: flex;
        align-items: center;
        flex-direction: column;
        justify-content: center;
        width: 100%;
        min-height: 100%;
        padding: 20px;
    }

    #formContent {
        border-radius: 10px;
        background: #fff;
        padding: 30px;
        width: 90%;
        max-width: 450px;
        position: relative;
        padding: 0px;
        box-shadow: 0 30px 60px 0 rgba(0, 0, 0, 0.3);
        text-align: center;
    }

    #formFooter {
        background-color: #f6f6f6;
        border-top: 1px solid #dce8f1;
        padding: 25px;
        text-align: center;
        border-radius: 0 0 10px 10px;
    }

    /* FORM TYPOGRAPHY */
    input[type="text"],
    input[type="email"],
    input[type="password"] {
        background-color: #f6f6f6;
        border: none;
        color: #0d0d0d;
        padding: 15px 32px;
        text-align: center;
        font-size: 16px;
        margin: 5px;
        width: 85%;
        border: 2px solid #f6f6f6;
        border-radius: 5px;
        transition: all 0.5s ease-in-out;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus {
        background-color: #fff;
        border-bottom: 2px solid #5fbae9;
    }

    input[type="submit"] {
        background-color: #56baed;
        border: none;
        color: white;
        padding: 15px 80px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        text-transform: uppercase;
        font-size: 13px;
        box-shadow: 0 10px 30px 0 rgba(95, 186, 233, 0.4);
        border-radius: 5px;
        margin: 5px 20px 40px 20px;
        transition: all 0.3s ease-in-out;
    }

    input[type="submit"]:hover {
        background-color: #39ace7;
    }

    .icon-header {
        display: flex;                /* Use flexbox for alignment */
        align-items:flex-end;         /* Center items vertically */
        justify-content: center;     /* Center items horizontally */
    }

    #icon {
        width: 70px;                 /* Set icon size */
        height: auto;                /* Maintain aspect ratio */
    }

    .icon-header h3 {
        font-size: 20px;             /* Match icon size */
        margin-left: 10px;           /* Space between icon and text */
        color: #cccccc;              /* Consistent text color */
    }
</style>

<div class="wrapper fadeInDown">
    <div id="formContent">
        <!-- Icon -->
        <div class="fadeIn first">
            <div class="icon-header">
                <img src="{{ asset('images/869636.png') }}" id="icon" alt="User Icon" />
                <h3>Welcome to MyShop</h3>
            </div>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <input type="email" id="email" class="fadeIn second" name="email" placeholder="Email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />

            <!-- Password -->
            <input type="password" id="password" class="fadeIn third" name="password" placeholder="Password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <input type="submit" class="fadeIn fourth" value="Log In" />
        </form>

        <!-- Remind Password -->
        <div id="formFooter">
            @if (Route::has('password.request'))
                <a class="underlineHover" href="{{ route('password.request') }}">
                    {{ __('Forgot Password?') }}
                </a>
            @endif
        </div>
    </div>
</div>
@endsection