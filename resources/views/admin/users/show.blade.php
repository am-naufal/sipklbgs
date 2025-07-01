@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Detail User</h1>
        <div class="mb-4">
            <strong>Nama:</strong> {{ $user->name }}
        </div>
        <div class="mb-4">
            <strong>Email:</strong> {{ $user->email }}
        </div>
        <a href="{{ route('users.edit', $user) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">Edit</a>
        <a href="{{ route('users.index') }}" class="ml-2 text-gray-600">Kembali</a>
    </div>
@endsection
