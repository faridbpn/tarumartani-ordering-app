<div class="flex h-screen">
    @include('layouts.app')


    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Tambah Pengguna Baru</h1>
    
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                {{ session('success') }}
            </div>
        @endif
    
        <form action="{{ route('admin.users.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            @csrf
    
            <!-- Nama -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md p-2 @error('name') border-red-500 @enderror"
                    required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
    
            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md p-2 @error('email') border-red-500 @enderror"
                    required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
    
            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password"
                    class="mt-1 block w-full border border-gray-300 rounded-md p-2 @error('password') border-red-500 @enderror"
                    required>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
    
            <!-- Role -->
            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role" id="role"
                    class="mt-1 block w-full border border-gray-300 rounded-md p-2 @error('role') border-red-500 @enderror"
                    required>
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
    
            <!-- Tombol Submit -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.users') }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Kembali</a>
                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Tambah Pengguna</button>
            </div>
        </form>
    </div>
</div>