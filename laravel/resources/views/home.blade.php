{{-- LAYOUT --}}
@extends('layouts.app')

{{-- PAGE TITLE --}}
@section('page-title', 'Home')

{{-- CONTENT --}}
@section('content')
<div class="container">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
