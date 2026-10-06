
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <title>Connexion</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <style type="text/css">
            body {
                background-image: url(http://www.joburgchiropractor.co.za/images/background.jpg);
                background-size: cover;
                height: 100vh; /* Full height of the viewport */
            }
            .container {
                height: 100%; /* Full height of the viewport */
                display: flex;
                justify-content: center; /* Center horizontally */
                align-items: center; /* Center vertically */
            }
            .form-container {
                background-color: rgba(255, 255, 255, 0.9); /* White background with some opacity */
                padding: 20px;
                border-radius: 10px; /* Rounded corners */
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Shadow */
                width: 100%; /* Full width of the parent */
                max-width: 400px; /* Maximum width for smaller size */
            }
            h1 {
                font-size: 24px; /* Smaller title font size */
                margin-bottom: 20px; /* Margin below the title */
            }
            .form-group label {
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="form-container">
                <h1 class="text-center text-success">Connexion</h1>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="form-group">
                        <x-input-label for="email" :value="__('E-mail')" />
                        <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="form-group mt-4">
                        <x-input-label for="password" :value="__('Mot de passe')" />
                        <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="form-check mt-4">
                        <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                        <label for="remember_me" class="form-check-label">{{ __('Se souvenir de moi') }}</label>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                                {{ __('Mot de passe oublié ?') }}
                            </a>
                        @endif
                        <x-primary-button class="ms-4 btn btn-primary">
                            {{ __('Se connecter') }}
                        </x-primary-button>
                    </div>
                </form>

                <div class="text-center mt-3">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                        {{ __('Pas de compte ? Inscrivez-vous') }}
                    </a>
                </div>
            </div>
        </div>
    </body>
    </html>
