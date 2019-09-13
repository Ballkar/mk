@extends('admin.master')

@section('content')
    <div class="centerContainer">
        <form action="" method="POST" id="loginContainer">
            @csrf
            @include('parts.errors')
            <div class="title">Admin Login Panel</div>
            @if ($errors->has('email'))
                <span class="error">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
            <label for="email" class="label">Email</label>
            <input type="text" id="email" name="email" class="input">
            @if ($errors->has('password'))
                <span class="error">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
            <label for="password" class="label">Password</label>
            <input type="password" id="password" name="password" class="input">
            <button class="submitBtn">Login</button>
        </form>
    </div>

@endsection
