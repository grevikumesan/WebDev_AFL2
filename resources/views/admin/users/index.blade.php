@extends('layouts.main')

@section('main_content')
<div class="container-fluid">
    <h3 class="fw-bold mb-4 text-dark">Kelola Pengguna</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Foto</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="ps-4">
                                <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('images/foto.jpeg') }}"
                                     class="rounded-circle border" style="width: 40px; height: 40px; object-fit: cover;">
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->role == 'admin')
                                    <span class="badge bg-danger">ADMIN</span>
                                @else
                                    <span class="badge bg-primary">CUSTOMER</span>
                                @endif
                            </td>
                            <td>
                                {{-- Tombol Edit --}}
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning text-white">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                {{-- Tombol Hapus (Jangan hapus diri sendiri) --}}
                                @if(Auth::id() != $user->id)
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus user ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
