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
                            <button class="btn">{{ __('Blog') }}</button>
                            <a href="{{ route('blogs.create') }}" class="btn btn-primary">Tambah Blog</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="d-flex flex-row-reverse">
                            <form action="{{ route('blogs.index') }}">
                                @csrf
                                <div class="input-group">
                                    <input type="text" id="title" name="title" class="form-control"
                                        onchange="submit()" placeholder="Sila cari...">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                    @if (request()->routeIs('blogs.index') && request()->query())
                                        <a href="{{ route('blogs.index') }}" class="btn btn-secondary">Set Semula</a>
                                    @endif
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-light table-bordered">
                                <thead>
                                    <tr class="table-dark">
                                        <th width="5%">{{ __('#') }}</th>
                                        <th width="30%">{{ __('Tajuk') }}</th>
                                        <th width="30%">{{ __('Keterangan') }}</th>
                                        <th width="15%" class="text-center">{{ __('Tindakan') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($blogs as $index => $blog)
                                        <tr>
                                            <td>{{ $blogs->firstItem() + $index }}</td>
                                            <td>{{ $blog->title }}</td>
                                            <td class="text-wrap text-break">{{ $blog->content }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('blogs.show', $blog->id) }}"
                                                    class="btn btn-sm btn-outline-info me-2">Lihat</a>
                                                @if (auth()->id() == $blog->created_by)
                                                    <a href="{{ route('blogs.edit', $blog->id) }}"
                                                        class="btn btn-sm btn-outline-primary me-2">Kemaskini</a>
                                                    <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm me-2"
                                                        onclick="confirmDelete(event, {{ $blog->id }})">
                                                        Hapus
                                                    </a>
                                                @endif
                                                <form id="delete-form-{{ $blog->id }}"
                                                    action="{{ route('blogs.destroy', $blog->id) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Tiada blog ditemui.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-end">
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
