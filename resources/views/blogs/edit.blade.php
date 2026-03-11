@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-white shadow-sm border-0">
                    <div class="card">
                        <div class="card-header">{{ __('Blog Form') }}</div>
                        <form action="{{ route('blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="title" name="title"
                                            value="{{ $blog->title }}" required>
                                        <label for="title" class="form-label">{{ __('Tajuk') }}</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <textarea class="form-control" id="content" name="content" required oninput="autoResize(this);">{{ $blog->content }}</textarea>
                                        <label for="content" class="form-label">{{ __('Keterangan') }}</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        @if ($blog->attachment != null)
                                            <img src="{{ asset('storage/' . $blog->attachment) }}" alt="" class="form-control" style="height: auto;">
                                        @endif
                                        <input type="file" name="attachment" id="attachment" class="form-control mt-2">
                                        <label for="attachment" class="form-label">{{ __('Gambar') }}</label>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('blogs.index') }}" class="btn btn-secondary">Kembali</a>
                                    <button type="submit" class="btn btn-primary">{{ __('Hantar') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function autoResize(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const descriptionTextarea = document.getElementById('content');

        autoResize(descriptionTextarea);
    });
</script>
