@extends('layouts.login') 
@section('content')
<style>
    #message {
        padding: 50px;
        width: 90%;
    }
</style>
<div class="container">
    <div id="message" class="mx-auto text-center">
        <h2>{{ $message }}</h2>
        <a href="{{url('/Auth')}}" class="btn btn-success">Click To Login</a>
    </div>
</div>
@endsection