@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Edit User</h1>
        <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label for="name" class="block">Nama</label>
                <input type="text" name="name" id="name" class="border rounded w-full p-2"
                    value="{{ old('name', $user->name) }}">
                @error('name')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="email" class="block">Email</label>
                <input type="email" name="email" id="email" class="border rounded w-full p-2"
                    value="{{ old('email', $user->email) }}">
                @error('email')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="password" class="block">Password (isi jika ingin mengubah)</label>
                <input type="password" name="password" id="password" class="border rounded w-full p-2">
                @error('password')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="password_confirmation" class="block">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="border rounded w-full p-2">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
            <a href="{{ route('users.index') }}" class="ml-2 text-gray-600">Batal</a>
        </form>
    </div>
@endsection
