@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-white shadow-sm border-0">
                    <div class="card">
                        <div class="card-header">
                            {{ __('Kenderaan') }}
                        </div>

                        <form action="#"">
                            @csrf
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input class="form-control" value="{{ $vehicle->model }}" readonly>
                                        <label for="model" class="form-label">{{ __('Model') }}</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input class="form-control" value="{{ $vehicle->color }}" readonly>
                                        <label for="color" class="form-label">{{ __('Warna') }}</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input class="form-control" value="{{ $vehicle->make }}" readonly>
                                        <label for="make" class="form-label">{{ __('Buatan') }}</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input class="form-control" value="{{ $vehicle->year }}" readonly>
                                        <label for="year" class="form-label">{{ __('Tahun') }}</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input class="form-control" value="{{ $vehicle->brand }}" readonly>
                                        <label for="brand" class="form-label">{{ __('Jenama') }}</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input class="form-control" value="{{ $vehicle->license_plate }}" readonly>
                                        <label for="license_plate" class="form-label">{{ __('No. Pendaftaran') }}</label>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">Kembali</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
