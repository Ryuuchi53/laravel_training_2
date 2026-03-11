@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card bg-white">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <button class="btn">{{ __('Kenderaan') }}</button>
                            <a href="{{ route('vehicles.create') }}" class="btn btn-primary">Tambah Kenderaan</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="d-flex flex-row-reverse">
                            <form action="{{ route('vehicles.index') }}">
                                @csrf
                                <div class="input-group">
                                    <input type="text" id="name" name="name" class="form-control"
                                        onchange="submit()" placeholder="Sila cari...">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                    @if (request()->routeIs('vehicles.index') && request()->query())
                                        <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">Set Semula</a>
                                    @endif
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-light table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">{{ __('#') }}</th>
                                        <th width="auto">{{ __('Model') }}</th>
                                        <th width="auto">{{ __('Warna') }}</th>
                                        <th width="auto">{{ __('Buatan') }}</th>
                                        <th width="auto">{{ __('Tahun') }}</th>
                                        <th width="auto">{{ __('Jenama') }}</th>
                                        <th width="auto">{{ __('No. Pendaftaran') }}</th>
                                        <th width="20%" class="text-center">{{ __('Tindakan') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($vehicles as $index => $vehicle)
                                        <tr>
                                            <td>{{ $vehicles->firstItem() + $index }}</td>
                                            <td>{{ $vehicle->model }}</td>
                                            <td>{{ $vehicle->color }}</td>
                                            <td>{{ $vehicle->make }}</td>
                                            <td>{{ $vehicle->year }}</td>
                                            <td>{{ $vehicle->brand }}</td>
                                            <td>{{ $vehicle->license_plate }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('vehicles.show', $vehicle->id) }}"
                                                    class="btn btn-sm btn-outline-info me-2">Lihat</a>
                                                @if (auth()->id() == $vehicle->created_by)
                                                    <a href="{{ route('vehicles.edit', $vehicle->id) }}"
                                                        class="btn btn-sm btn-outline-primary me-2">Kemaskini</a>
                                                    <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm me-2"
                                                        onclick="confirmDelete(event, {{ $vehicle->id }})">
                                                        Hapus
                                                    </a>
                                                @endif
                                                <form id="delete-form-{{ $vehicle->id }}"
                                                    action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">Tiada blog ditemui.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-end">
                                {{-- Previous link (jump to first page) --}}
                                @if ($vehicles->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">&laquo;</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $vehicles->url(1) }}" rel="prev">&laquo;</a>
                                    </li>
                                @endif

                                {{-- Page number links (only three around current) --}}
                                @php
                                    $current = $vehicles->currentPage();
                                    $last = $vehicles->lastPage();
                                    $start = max(1, $current - 1);
                                    $end = min($last, $current + 1);
                                @endphp
                                @foreach ($vehicles->getUrlRange($start, $end) as $page => $url)
                                    <li class="page-item {{ $page == $current ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                {{-- Next link (jump to last page) --}}
                                @if ($vehicles->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $vehicles->url($vehicles->lastPage()) }}"
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
    function confirmDelete(event, blogId) {
        // Prevent the link from navigating
        event.preventDefault();

        Swal.fire({
            title: 'Adakah anda pasti?',
            text: 'Tindakan ini tidak boleh diundur.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, submit the form
                document.getElementById('delete-form-' + blogId).submit();
                Swal.fire(
                    'Hapus!',
                    'Rekod ini telah berjaya dihapus.',
                    'success'
                );
            } else {
                Swal.fire(
                    'Batal',
                    'Rekod ini tidak dihapus.',
                    'info'
                );
            }
        });
    }
</script>
