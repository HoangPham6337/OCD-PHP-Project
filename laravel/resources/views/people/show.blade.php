@extends('layouts.app')

@section('title', 'Person Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-white mb-6">Person Details</h1>

    <div class="bg-gray-800 text-white p-6 rounded-lg shadow-md">
        <p><strong>ID:</strong> {{ $person->id }}</p>
        <p><strong>First Name:</strong> {{ $person->first_name }}</p>
        <p><strong>Last Name:</strong> {{ $person->last_name }}</p>
        <p><strong>Birth Name:</strong> {{ $person->birth_name ?? 'N/A' }}</p>
        <p><strong>Middle Names:</strong> {{ $person->middle_names ?? 'N/A' }}</p>
        <p><strong>Date of Birth:</strong> {{ $person->date_of_birth ?? 'N/A' }}</p>
        <p><strong>Created At:</strong> {{ $person->created_at->format('Y-m-d') }}</p>
    </div>

    <div class="mt-6">
        <a href="{{ route('people.index') }}" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded">Back to People List</a>
    </div>
</div>
@endsection
