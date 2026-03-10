@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-white shadow-sm border-0">
                    <div class="card">
                        <div class="card-header">
                            {{ __('Blog') }}
                        </div>
                        <form action="#"">
                            @csrf
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input class="form-control" value="{{ $blog->title }}" readonly>
                                        <label for="title" class="form-label">{{ __('Tajuk') }}</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <textarea class="form-control" id="content" name="content" oninput="autoResize(this);" readonly>{{ $blog->content }}</textarea>
                                        <label for="content" class="form-label">{{ __('Keterangan') }}</label>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('blogs.index') }}" class="btn btn-secondary">Kembali</a>
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
