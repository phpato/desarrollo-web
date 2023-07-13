@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <post-component :current-user="{{auth()->user()}}" :states="{{ $states }}"></post-component>
        </div>
    </div>
</div>
@endsection
