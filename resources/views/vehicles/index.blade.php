@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="col-md-8">
                <div class="card bg-white shadow-sm border-0">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <button class="btn">{{ __('Kenderaan') }}</button>
                                <a href="{{ route('vehicles.create') }}" class="btn btn-primary">Tambah Kenderaan</a>
                            </div>
                        </div>

                        <div class="card-body">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th width="2%">{{ __('#') }}</th>
                                        <th>{{ __('Model') }}</th>
                                        <th>{{ __('Warna') }}</th>
                                        <th>{{ __('Buatan') }}</th>
                                        <th>{{ __('Tahun') }}</th>
                                        <th>{{ __('Jenama') }}</th>
                                        <th>{{ __('No. Pendaftaran') }}</th>
                                        <th>{{ __('Tindakan') }}</th>
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
                                            <td>
                                                <div class="d-flex flex-row">

                                                    <form action="{{ route('vehicles.destroy', $vehicle->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="{{ route('vehicles.show', $vehicle->id) }}"
                                                            class="btn btn-sm btn-outline-info me-2 mb-2">Lihat</a>
                                                        @if (auth()->id() == $vehicle->created_by)
                                                            <a href="{{ route('vehicles.edit', $vehicle->id) }}"
                                                                class="btn btn-sm btn-outline-primary me-2 mb-2">Kemaskini</a>
                                                            <button type="button"
                                                                class="btn btn-sm btn-outline-danger me-2 mb-2"
                                                                onclick="confirmDelete(event)">Hapus</button>
                                                        @endif
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Tiada blog ditemui.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
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
    </div>
@endsection

<script>
    function confirmDelete(event) {
        event.preventDefault();
        const form = event.target.closest('form');
        Swal.fire({
            title: 'Anda pasti untuk hapus rekod ini?',
            text: "Tindakan ini tidak dapat dipulihkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            cancelButtonText: 'Batal',
            confirmButtonText: 'Ya, hapus!',
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
