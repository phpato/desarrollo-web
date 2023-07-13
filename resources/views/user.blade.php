@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <user-component :user="{{auth()->user()}}"></user-component>
        </div>
    </div>
</div>
@endsection
