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

                        <form action="{{ route('vehicles.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input class="form-control" name="model" placeholder="{{ __('Model') }}" required>
                                        <label for="model" class="form-label">{{ __('Model') }}</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input class="form-control" name="color" placeholder="{{ __('Warna') }}" required>
                                        <label for="color" class="form-label">{{ __('Warna') }}</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input class="form-control" name="make" placeholder="{{ __('Buatan') }}" required>
                                        <label for="make" class="form-label">{{ __('Buatan') }}</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <select class="form-select" name="year" id="year" required data-type="select2" data-placeholder="Sila pilih...">
                                            @php
                                                $currentYear = date('Y');
                                            @endphp
                                            <option value="">Sila pilih...</option>
                                            @for ($y = 1999; $y <= $currentYear; $y++)
                                                <option value="{{ $y }}">{{ $y }}</option>
                                            @endfor
                                        </select>
                                        <label for="year" class="form-label">{{ __('Tahun') }}</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input class="form-control" name="brand" placeholder="{{ __('Jenama') }}" required>
                                        <label for="brand" class="form-label">{{ __('Jenama') }}</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input class="form-control" name="license_plate"
                                            placeholder="{{ __('No. Pendaftaran') }}" required>
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