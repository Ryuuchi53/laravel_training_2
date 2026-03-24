@extends('layouts.custom.main')

@section('content')
    <div class="container-fluid px-4 py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card bg-white shadow-sm border-0">
                    <div class="card">
                        <div class="card-header">
                            {{ __('Profil Pengguna') }}
                        </div>
                        <form action="#"">
                            @csrf
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input class="form-control" value="{{ $user->name }}" readonly>
                                        <label for="name" class="form-label">{{ __('Nama') }}</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input class="form-control" value="{{ $user->email }}" readonly>
                                        <label for="email" class="form-label">{{ __('Alamat E-mel') }}</label>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
