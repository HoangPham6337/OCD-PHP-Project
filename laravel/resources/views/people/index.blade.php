@extends('layouts.app')

@section('title', 'People List')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-white mb-6">People List</h1>
    @if ($people->isEmpty())
        <p class="text-gray-500">No people found.</p>
    @else
        <table class="min-w-full bg-white shadow-md rounded border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="py-2 px-4 border-b">ID</th>
                    <th class="py-2 px-4 border-b">First Name</th>
                    <th class="py-2 px-4 border-b">Last Name</th>
                    <th class="py-2 px-4 border-b">Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($people as $person)
                    <tr class="hover:bg-gray-50">
                        <!-- Make each row clickable -->
                        <td class="py-2 px-4 border-b">
                            <a href="{{ route('people.show', $person->id) }}" class="text-indigo-500 hover:underline">
                                {{ $person->id }}
                            </a>
                        </td>
                        <td class="py-2 px-4 border-b">
                            <a href="{{ route('people.show', $person->id) }}" class="text-indigo-500 hover:underline">
                                {{ $person->first_name }}
                            </a>
                        </td>
                        <td class="py-2 px-4 border-b">
                            <a href="{{ route('people.show', $person->id) }}" class="text-indigo-500 hover:underline">
                                {{ $person->last_name }}
                            </a>
                        </td>
                        <td class="py-2 px-4 border-b">
                            <a href="{{ route('people.show', $person->id) }}" class="text-indigo-500 hover:underline">
                                {{ $person->date_of_birth ?? 'N/A' }}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    @endif
</div>
@endsection