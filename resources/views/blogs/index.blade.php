@extends('Layouts.custom.main')

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
                            <button class="btn">{{ __('Blog') }}</button>
                            <a href="{{ route('blogs.create') }}" class="btn btn-primary">Tambah Blog</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="GET" action="{{ route('blogs.index') }}">
                            @csrf
                            <div class="row row-cols-auto g-1 justify-content-end">
                                <div class="col form-floating">
                                    <select class="form-select" name="mytask" id="mytask"
                                        data-placeholder="Sila pilih...">
                                        <option value="">Sila pilih...</option>
                                        <option value="1">Ya</option>
                                    </select>
                                    <label for="mytask">Tugasan Saya</label>
                                </div>
                                <div class="col">
                                    <div class="input-group">
                                        <div class="form-floating">
                                            <input type="text" id="title" name="title" class="form-control"
                                                onchange="submit()" placeholder="tajuk / keterangan">
                                            <label for="title">tajuk / keterangan</label>
                                        </div>
                                        <button type="submit" class="btn btn-primary input-group-text">Cari</button>
                                        @if (request()->routeIs('blogs.index') && request()->query())
                                            <a href="{{ route('blogs.index') }}"
                                                class="btn btn-secondary input-group-text d-flex align-items-center">Set
                                                Semula</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive rounded">
                            <table class="table table-light table-bordered rounded">
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
                                            <td>
                                                {{ $blog->title }} <br><br>
                                                <small class="text-muted">
                                                    <em>
                                                        {{ __('Dicipta Oleh : ') . $blog->user->name }} <br>
                                                        @if ($blog->created_at == $blog->updated_at)
                                                            {{ __('Dicipta Pada : ') . $blog->created_at->format('d/m/Y') }}
                                                        @else
                                                            {{ __('Dikemaskini Pada : ') . $blog->updated_at->format('d/m/Y') }}
                                                        @endif
                                                    </em>
                                                </small>
                                            </td>
                                            <td class="text-wrap text-break">{{ $blog->content }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('blogs.show', $blog->id) }}"
                                                    class="btn btn-sm btn-secondary me-2 mb-2">Lihat</a>
                                                @if (auth()->id() == $blog->created_by)
                                                    <a href="{{ route('blogs.edit', $blog->id) }}"
                                                        class="btn btn-sm btn-primary me-2 mb-2">Kemaskini</a>
                                                    <a href="javascript:void(0);" class="btn btn-danger btn-sm me-2 mb-2"
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
                                <li class="page-item">
                                    <span class="page-link">
                                        {{ $blogs->firstItem() . ' - ' . $blogs->firstItem() + $index . ' daripada ' . $blogs->total() . ' Rekod' }}
                                    </span>
                                </li>
                                @if ($blogs->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">&laquo;</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $blogs->url(1) }}" rel="prev">&laquo;</a>
                                    </li>
                                @endif
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
