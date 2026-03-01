@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-100">
    <div class="flex-1 p-8">
        <div class="max-w-6xl mx-auto">
            
            <div class="mb-6">
                <a href="{{ route('admin.dashboard') }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
                        <i class="fa fa-arrow-left"></i>
                </a>
            </div>

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Quản lý người dùng</h1>
                <p class="text-gray-500">Tổng số: {{ $users->total() }} thành viên</p>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-200">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 uppercase text-xs font-semibold text-gray-600">
                        <tr>
                            <th class="px-6 py-4 border-b">Họ tên</th>
                            <th class="px-6 py-4 border-b">Username</th>
                            <th class="px-6 py-4 border-b">Số điện thoại</th>
                            <th class="px-6 py-4 border-b">Địa chỉ</th>
                            <th class="px-6 py-4 border-b">Vai trò</th>
                            <th class="px-6 py-4 border-b text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $user->username }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $user->phone ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-gray-600 text-sm">{{ $user->address ?? 'N/A' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 transition">
                                        <i class="fa fa-trash"></i> Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection