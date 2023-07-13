@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <home-component :current-user="{{auth()->user()}}"></home-component>
        </div>
    </div>
</div>
@endsection
