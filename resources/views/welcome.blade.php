@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-white shadow-sm border-0">
                    <div class="card-body text-center">
                        @guest
                        @else
                             <h1>Selamat Datang {{ Auth::user()->name }}</h1>
                             <p>Anda telah Log Masuk ke dalam sistem.</p>
                             <p>Sila klik butang di bawah untuk ke halaman utama.</p>
                             <a href="{{ route('home') }}" class="btn btn-primary">{{ __('Kembali') }}</a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
