@extends('layouts.app')

@section('title', 'Add New Person')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-white mb-6">Add New Person</h1>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('people.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="first_name" class="block text-sm font-medium text-white">First Name</label>
            <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
        </div>

        <div>
            <label for="last_name" class="block text-sm font-medium text-white">Last Name</label>
            <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
        </div>

        <div>
            <label for="birth_name" class="block text-sm font-medium text-white">Birth Name</label>
            <input type="text" id="birth_name" name="birth_name" value="{{ old('birth_name') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>

        <div>
            <label for="middle_names" class="block text-sm font-medium text-white">Middle Names</label>
            <input type="text" id="middle_names" name="middle_names" value="{{ old('middle_names') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>

        <div>
            <label for="date_of_birth" class="block text-sm font-medium text-white">Date of Birth</label>
            <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>

        <div>
            <button type="submit"
                class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded">
                Add new person
            </button>
        </div>
    </form>
</div>
@endsection
