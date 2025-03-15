@extends('lms::layouts.guest')
@section('content')
    <x-jet-authentication-card>
        <x-slot name="logo">
            <img src="{{ asset('vendor/lms/img/logo.jpg') }}" alt="lms" class="img-fluid" width="150" />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="block">
                <x-jet-label for="email" value="{{ __('lms::messages.Email') }}" />
                <x-jet-input id="email" class="form-control mt-1 w-full" type="email" name="email" :value="old('email', $request->email)"
                    required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('lms::messages.Password') }}" />
                <x-jet-input id="password" class="form-control mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('lms::messages.Confirm Password') }}" />
                <x-jet-input id="password_confirmation" class="form-control mt-1 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button>
                    {{ __('lms::messages.Reset Password') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
@endsection
