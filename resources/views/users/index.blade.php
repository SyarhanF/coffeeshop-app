@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title"><i class="bi bi-people-fill me-2"></i>Manajemen User</h2>
    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Tambah User
    </a>
</div>

<div class="card">
    <div class="card-header py-3">
        <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Daftar User</h5>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Dibuat</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $i => $user)
                <tr>
                    <td>{{ $users->firstItem() + $i }}</td>
                    <td><strong>{{ $user->name }}</strong></td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role === 'admin')
                            <span class="badge bg-danger badge-role">Admin</span>
                        @else
                            <span class="badge bg-info badge-role">Kasir</span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    <td class="text-center">
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm me-1">
                            <i class="bi bi-pencil-fill"></i> Edit
                        </a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin hapus user {{ $user->name }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                <i class="bi bi-trash-fill"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>Belum ada user
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="card-footer">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection