@extends('layouts.custom.main')

@section('content')
    <div class="container-fluid px-4 py-4">
        <div class="row justify-content-center">
            @if (session('error') && $errors->any())
                <div class="alert alert-danger alert-dismissible" role="alert">
                    {{ session('error') }}
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="col-md-12">
                <div class="card bg-white shadow-sm border-0">
                    <div class="card">
                        <div class="card-header">{{ __('Tambah Pengguna') }}</div>
                        <form action="{{ route('users.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input class="form-control" id="name" name="name" placeholder="{{ __('Nama') }}" value="{{ old('name') }}">
                                        <label for="name" class="form-label">{{ __('Nama') }}</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input class="form-control" type="email" name="email" placeholder="{{ __('Alamat E-mel') }}" value="{{ old('email') }}">
                                        <label for="email" class="form-label">{{ __('Alamat E-mel') }}</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input class="form-control" type="password" id="password" name="password" placeholder="{{ __('Kata Laluan') }}">
                                        <label for="password" class="form-label">{{ __('Kata Laluan') }}</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" placeholder="{{ __('Pengesahan Kata Laluan') }}">
                                        <label for="password_confirmation" class="form-label">{{ __('Pengesahan Kata Laluan') }}</label>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
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
