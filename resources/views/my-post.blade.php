@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <my-post-component :current-user="{{ auth()->user() }}" :states="{{ $states }}"></my-post-component>
        </div>
    </div>
</div>
@endsection
