<!-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> -->
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<h1>Dashboard</h1>

<!-- Show All Accounts -->
<a href="{{ route('people.index') }}">Show All Accounts</a>

<!-- Show Account by ID -->
<form action="{{ route('people.show', ['id' => 1]) }}" method="GET" style="margin-top: 20px;">
    <label for="account_id">Show Account by ID:</label>
    <input type="number" name="id" id="account_id" placeholder="Enter Account ID" required>
    <button type="submit">Search</button>
</form>

<!-- Add New Account -->
<a href="{{ route('people.create') }}" style="margin-top: 20px; display: block;">Add New Account</a>

<!-- Log Out -->
<form method="POST" action="{{ route('logout') }}" style="margin-top: 20px;">
    @csrf
    <button type="submit">Log Out</button>
</form>
@endsection
