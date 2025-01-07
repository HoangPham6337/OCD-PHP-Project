<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<h1>Edit Profile</h1>

@if (session('status'))
    <p>{{ session('status') }}</p>
@endif

<form method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('PATCH')

    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
    <br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
    <br>

    <button type="submit">Save Changes</button>
</form>

<form method="POST" action="{{ route('profile.destroy') }}" style="margin-top: 20px;">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('Are you sure you want to delete your account?')">Delete Account</button>
</form>
@endsection