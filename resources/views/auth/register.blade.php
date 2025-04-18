<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription</title>
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
      background: url("{{ asset('image/ectera.jpg') }}") no-repeat;
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
      background: rgba(0, 0, 0, 0.4);
      z-index: -1;
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
      background-color: #1e90ff;
      color: #fff;
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
    <form method="POST" action="{{ route('register') }}">
      @csrf
      <h1>{{ __('INSCRIPTION') }}</h1>

      <!-- Name -->
      <div class="input-box">
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="{{ __('Nom') }}">
        <i class='bx bxs-user'></i>
        @if ($errors->has('name'))
          <span class="text-red-500 text-sm">{{ $errors->first('name') }}</span>
        @endif
      </div>

      <!-- Email -->
      <div class="input-box">
        <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="{{ __('Email') }}">
        <i class='bx bx-envelope'></i>
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

      <!-- Confirm Password -->
      <div class="input-box">
        <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="{{ __('Confirmer le mot de passe') }}">
        <i class='bx bxs-lock'></i>
        @if ($errors->has('password_confirmation'))
          <span class="text-red-500 text-sm">{{ $errors->first('password_confirmation') }}</span>
        @endif
      </div>

      <!-- Bouton Inscription -->
      <button type="submit" class="btn">{{ __('S\'INSCRIRE') }}</button>

      <!-- Lien vers connexion -->
      <div class="register-link">
        <p>{{ __('Déjà un compte ?') }} <a href="{{ route('login') }}">{{ __('Se connecter') }}</a></p>
      </div>
    </form>
  </div>
</body>
</html>
