<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <!-- Favicon -->
  <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
  <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">

  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background:url("{{ asset('image/ectera.jpg') }}") no-repeat;
      background-size: cover;
      background-position: center;
    }
    body::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.4); /* Superposition sombre */
    z-index: -1; /* Pour que la superposition soit derrière le contenu */
}

    .wrapper {
      width: 420px;
      background: transparent;
      border: 2px solid rgba(255, 255, 255, .2);
      backdrop-filter: blur(9px);
      color: #fff;
      border-radius: 12px;
      padding: 30px 40px;
    }

    .wrapper h1 {
      font-size: 36px;
      text-align: center;
    }

    .wrapper .input-box {
      position: relative;
      width: 100%;
      height: 50px;
      margin: 30px 0;
    }

    .input-box input {
      width: 100%;
      height: 100%;
      background: transparent;
      border: none;
      outline: none;
      border: 2px solid rgba(255, 255, 255, .2);
      border-radius: 40px;
      font-size: 16px;
      color: #fff;
      padding: 20px 45px 20px 20px;
    }

    .input-box input::placeholder {
      color: #fff;
    }

    .input-box i {
      position: absolute;
      right: 20px;
      top: 30%;
      transform: translate(-50%);
      font-size: 20px;
    }

    .wrapper .remember-forgot {
      display: flex;
      justify-content: space-between;
      font-size: 14.5px;
      margin: -15px 0 15px;
    }

    .remember-forgot label input {
      accent-color: #fff;
      margin-right: 3px;
    }

    .remember-forgot a {
      color: #fff;
      text-decoration: none;
    }

    .remember-forgot a:hover {
      text-decoration: underline;
    }

    .wrapper .btn {
      width: 100%;
      height: 45px;
      background: #fff;
      border: none;
      outline: none;
      border-radius: 40px;
      box-shadow: 0 0 10px rgba(0, 0, 0, .1);
      cursor: pointer;
      font-size: 16px;
      color: #333;
      font-weight: 600;
    }
    .wrapper .btn:hover {
    background-color: #1e90ff; /* Change la couleur en bleu lorsque le curseur passe dessus */
    color: #fff; /* Change la couleur du texte en blanc */
}

    .wrapper .register-link {
      font-size: 14.5px;
      text-align: center;
      margin: 20px 0 15px;
    }

    .register-link p a {
      color: #fff;
      text-decoration: none;
      font-weight: 600;
    }

    .register-link p a:hover {
      text-decoration: underline;
    }

  </style>
</head>
<body>
  <div class="wrapper">
    <form method="POST" action="{{ route('login') }}">
      @csrf
      <h1>{{ __('CONNEXION') }}</h1>

      <!-- Email Address -->
      <div class="input-box">
        <input id="email" type="email" name="email" :value="old('email')" required autofocus placeholder="{{ __('Email') }}">
        <i class='bx bxs-user'></i>
        @if ($errors->has('email'))
          <span class="text-red-500 text-sm">{{ $errors->first('email') }}</span>
        @endif
      </div>

      <!-- Password -->
      <div class="input-box">
        <input id="password" type="password" name="password" required placeholder="{{ __('Mot de passe') }}">
        <i class='bx bxs-lock-alt'></i>
        @if ($errors->has('password'))
          <span class="text-red-500 text-sm">{{ $errors->first('password') }}</span>
        @endif
      </div>

      <!-- Remember Me -->
      <!-- <div class="remember-forgot">
        <label><input id="remember_me" type="checkbox" name="remember">{{ __('se souvenir ') }}</label>
        @if (Route::has('password.request'))
          <a href="{{ route('password.request') }}">{{ __('Mot de passe oublier ?') }}</a>
        @endif
      </div> -->

      <button type="submit" class="btn">{{ __('SE CONNECTER') }}</button>

      <div class="register-link">
        @if (Route::has('register'))
          <p>{{ __("Pas de compte ?") }} <a href="{{ route('register') }}">{{ __('creer un compte') }}</a></p>
        @endif
      </div>
    </form>
  </div>
</body>
</html>
