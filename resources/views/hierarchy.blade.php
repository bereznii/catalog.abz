@extends('layouts.app')

@section('content')
    <div class="list-group">
        <a href="#" class="list-group-item">{{$president->position}} | {{$president->name}}</a>
    </div>
@endsection