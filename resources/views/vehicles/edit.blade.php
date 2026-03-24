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
                        <div class="card-header">
                            {{ __('Kenderaan') }}
                        </div>

                        <form action="{{ route('vehicles.update', $vehicle->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input class="form-control" name="model" value="{{ $vehicle->model }}"
                                            placeholder="{{ __('Model') }}">
                                        <label for="model" class="form-label">{{ __('Model') }}</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input class="form-control" name="color" value="{{ $vehicle->color }}"
                                            placeholder="{{ __('Warna') }}">
                                        <label for="color" class="form-label">{{ __('Warna') }}</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input class="form-control" name="make" value="{{ $vehicle->make }}"
                                            placeholder="{{ __('Buatan') }}">
                                        <label for="make" class="form-label">{{ __('Buatan') }}</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <select class="form-select" name="year" id="year" required data-type="select2" data-placeholder="Sila pilih...">
                                            @php
                                                $currentYear = date('Y');
                                            @endphp
                                            @for ($y = 1999; $y <= $currentYear; $y++)
                                                <option value="{{ $y }}"
                                                    {{ $vehicle->year == $y ? 'selected' : '' }}>
                                                    {{ $y }}
                                                </option>
                                            @endfor
                                        </select>
                                        <label for="year" class="form-label">{{ __('Tahun') }}</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input class="form-control" name="brand" value="{{ $vehicle->brand }}"
                                            placeholder="{{ __('Jenama') }}">
                                        <label for="brand" class="form-label">{{ __('Jenama') }}</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input class="form-control" name="license_plate"
                                            value="{{ $vehicle->license_plate }}"
                                            placeholder="{{ __('No. Pendaftaran') }}">
                                        <label for="license_plate" class="form-label">{{ __('No. Pendaftaran') }}</label>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">Kembali</a>
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
