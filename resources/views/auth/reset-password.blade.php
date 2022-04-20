@extends('template.layout_login')
@section('content')
<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <img class="img-Change-pass" src="{{ asset('img/administrador/login.png') }}" alt="Homepage" >
        </x-slot>

        <!-- Validation Errors -->
        <!--<x-auth-validation-errors class="mb-4" :errors="$errors" />-->
        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            @if($errors->any())  
            <div class="mb-4">
            <div class="font-medium text-red-600">
                Usted posee los siguientes errores:
            </div>  
            @foreach($errors->all() as $error)
            <li>{!! $error !!}</li>
            @endforeach
            @endif    
        </ul>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Correo')" />

                <x-input readonly="true" id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Contraseña')" />

                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Validar Contraseña')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                    type="password"
                                    name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Reestablecer contraseña') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
