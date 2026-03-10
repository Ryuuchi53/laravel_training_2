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
                                <button class="btn">{{ __('Blog') }}</button>
                                <a href="{{ route('blogs.create') }}" class="btn btn-primary">Tambah Blog</a>
                            </div>
                        </div>

                        <div class="card-body">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th width="2%">{{ __('#') }}</th>
                                        <th width="30%">{{ __('Tajuk') }}</th>
                                        <th width="38%">{{ __('Keterangan') }}</th>
                                        <th width="30%">{{ __('Tindakan') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($blogs as $index => $blog)
                                        <tr>
                                            <td>{{ $blogs->firstItem() + $index }}</td>
                                            <td>{{ $blog->title }}</td>
                                            <td class="text-wrap text-break">{{ $blog->content }}</td>
                                            <td>
                                                <div class="d-flex flex-row">

                                                    <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="{{ route('blogs.show', $blog->id) }}"
                                                            class="btn btn-sm btn-outline-info me-2 mb-2">Lihat</a>
                                                        @if (auth()->id() == $blog->created_by)
                                                            <a href="{{ route('blogs.edit', $blog->id) }}"
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
                                    @if ($blogs->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">&laquo;</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $blogs->url(1) }}" rel="prev">&laquo;</a>
                                        </li>
                                    @endif

                                    {{-- Page number links (only three around current) --}}
                                    @php
                                        $current = $blogs->currentPage();
                                        $last = $blogs->lastPage();
                                        $start = max(1, $current - 1);
                                        $end = min($last, $current + 1);
                                    @endphp
                                    @foreach ($blogs->getUrlRange($start, $end) as $page => $url)
                                        <li class="page-item {{ $page == $current ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    {{-- Next link (jump to last page) --}}
                                    @if ($blogs->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $blogs->url($blogs->lastPage()) }}"
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
