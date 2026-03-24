@extends('layouts.custom.main')

@section('content')
    <div class="container-fluid px-4 py-4">
        <div class="row justify-content-center">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="col-md-12">
                <div class="card bg-white">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <button class="btn">{{ __('Pengguna') }}</button>
                            <a href="{{ route('users.create') }}" class="btn btn-primary">Tambah Pengguna</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="GET" action="{{ route('users.index') }}">
                            @csrf
                            <div class="row row-cols-auto g-1 justify-content-end">
                                <div class="col">
                                    <div class="input-group">
                                        <div class="form-floating">
                                            <input type="text" id="name" name="name" class="form-control"
                                                onchange="submit()" placeholder="Nama">
                                            <label for="name">Nama</label>
                                        </div>
                                        <button type="submit" class="btn btn-primary input-group-text">Cari</button>
                                        @if (request()->routeIs('users.index') && request()->query())
                                            <a href="{{ route('users.index') }}"
                                                class="btn btn-secondary input-group-text d-flex align-items-center">Set
                                                Semula</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive rounded">
                            <table class="table table-light table-bordered">
                                <thead>
                                    <tr class="table-dark">
                                        <th width="5%">{{ __('#') }}</th>
                                        <th width="30%">{{ __('Nama') }}</th>
                                        <th width="30%">{{ __('Alamat E-mel') }}</th>
                                        <th width="15%" class="text-center">{{ __('Tindakan') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $index => $user)
                                        <tr>
                                            <td>{{ $users->firstItem() + $index }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td class="text-wrap text-break">{{ $user->email }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('users.show', $user->id) }}"
                                                    class="btn btn-sm btn-secondary me-2 mb-2">Lihat</a>
                                                <a href="{{ route('users.edit', $user->id) }}"
                                                    class="btn btn-sm btn-primary me-2 mb-2">Kemaskini</a>
                                                @if ($user->status == 1)
                                                    <a href="javascript:void(0);" class="btn btn-danger btn-sm me-2 mb-2"
                                                        onclick="confirmDeactivate(event, {{ $user->id }})">
                                                        Nyahaktif
                                                    </a>
                                                @else
                                                    <a href="javascript:void(0);" class="btn btn-success btn-sm me-2 mb-2"
                                                        onclick="confirmActivate(event, {{ $user->id }})">
                                                        Aktifkan
                                                    </a>
                                                @endif
                                                <form id="deactivate-form-{{ $user->id }}"
                                                    action="{{ route('users.deactivate', $user->id) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                </form>
                                                <form id="activate-form-{{ $user->id }}"
                                                    action="{{ route('users.activate', $user->id) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Tiada pengguna ditemui.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-end">
                                <li class="page-item">
                                    <span class="page-link">
                                        {{ $users->firstItem() . ' - ' . $users->firstItem() + $index . ' daripada ' . $users->total() . ' Rekod' }}
                                    </span>
                                </li>
                                @if ($users->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">&laquo;</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $users->url(1) }}" rel="prev">&laquo;</a>
                                    </li>
                                @endif
                                @php
                                    $current = $users->currentPage();
                                    $last = $users->lastPage();
                                    $start = max(1, $current - 1);
                                    $end = min($last, $current + 1);
                                @endphp
                                @foreach ($users->getUrlRange($start, $end) as $page => $url)
                                    <li class="page-item {{ $page == $current ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                @if ($users->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $users->url($users->lastPage()) }}"
                                            rel="next">&raquo;</a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">&raquo;</span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function confirmDeactivate(event, userId) {
        // Prevent the link from navigating
        event.preventDefault();

        Swal.fire({
            title: 'Adakah anda pasti?',
            text: 'Tindakan ini tidak boleh diundur.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Nyahaktif!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, submit the form
                document.getElementById('deactivate-form-' + userId).submit();
                Swal.fire(
                    'Hapus!',
                    'Pengguna ini telah berjaya dinyahaktif.',
                    'success'
                );
            } else {
                Swal.fire(
                    'Batal',
                    'Rekod ini tidak dinyahaktif.',
                    'info'
                );
            }
        });
    }

    function confirmActivate(event, userId) {
        // Prevent the link from navigating
        event.preventDefault();

        Swal.fire({
            title: 'Adakah anda pasti?',
            text: 'Tindakan ini tidak boleh diundur.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Aktifkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, submit the form
                document.getElementById('activate-form-' + userId).submit();
                Swal.fire(
                    'Hapus!',
                    'Pengguna ini telah berjaya diaktifkan.',
                    'success'
                );
            } else {
                Swal.fire(
                    'Batal',
                    'Rekod ini tidak diaktifkan.',
                    'info'
                );
            }
        });
    }
</script>
