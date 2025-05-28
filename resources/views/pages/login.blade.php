@extends('template.app')
@section('page')
    <section class="login">
        <div class="container">
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <h2>Вход</h2>
                <div class="form-input">
                    <label for="login" class="text-medium">Введите логин <span style="color: red;">*</span></label>
                    <input id="login" type="text" name="login" class="input-transparent">
                    @error('login')
                        <p class="error text-small">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-input">
                    <label for="password" class="text-medium">Введите пароль <span style="color: red;">*</span></label>
                    <input id="password" type="password" name="password" class="input-transparent">
                    @error('password')
                        <p class="error text-small">{{ $message }}</p>
                    @enderror
                </div>
                <button class="button-red">Войти</button>
            </form>
        </div>
    </section>
@endsection
