{{-- LAYOUT --}}
@extends('layouts.app')

{{-- PAGE TITLE --}}
@section('page-title', 'Goals')

{{-- CONTENT TITLE --}}
@section('content-title')
<header class="content__title">
    <h1>Goals</h1>
    <small>Manage every area of your life.</small>

    <div class="actions">
        <a href="" class="actions__item zmdi zmdi-trending-up"></a>
        <a href="" class="actions__item zmdi zmdi-check-all"></a>

        <div class="dropdown actions__item">
            <i data-toggle="dropdown" class="zmdi zmdi-more-vert"></i>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="" class="dropdown-item">Refresh</a>
                <a href="" class="dropdown-item">Manage Widgets</a>
                <a href="" class="dropdown-item">Settings</a>
            </div>
        </div>

        <button class="btn btn-light" @click="goalsSave()">@{{ saveButtonText }}</button>
    </div>
</header>
@endsection

{{-- CONTENT --}}
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            {{-- <goals @goals-saving="goalsSaving()" @goals-saved="goalsSaved()" ref="goalsComponent"></goals> --}}
            <goal-list></goal-list>
        </div>
    </div>
</div>
@endsection